<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface HC4_App_Router_
{
	public function add( $contextRoute, $handler );
	public function alias( $alias, $real );
	public function close( array $contexts = array() );
	public function find( $context, $slug, $limit = NULL );
}

class HC4_App_Router implements HC4_App_Router_
{
	protected $routes = array();
	protected $aliases = array();
	protected $closed = FALSE;

	public function __construct(
	)
	{}

	public function find( $context, $slug, $limit = NULL )
	{
		if( ! $this->closed ){
			$this->close();
		}

		$return = array();
		$context = strtoupper( $context );

		if( ! isset($this->routes[$context]) ){
			return $return;
		}

// if( 'LAYOUT' === $context ){
	// echo "GOT RESULTS";
	// _print_r( $this->routes[$context] );
	// exit;
// }

		reset( $this->routes[$context] );
		foreach( $this->routes[$context] as $r ){
			list( $thisRoute, $thisHandler ) = $r;

			$ok = FALSE;
		// re?
			if( '%' == substr($thisRoute, 0, 1) ){
				if( preg_match($thisRoute, $slug, $params) ){
					$ok = TRUE;
					array_shift( $params );
				}
			}
			else {
				if( $thisRoute == $slug ){
					$ok = TRUE;
					$params = array();
				}
			}

			if( ! $ok ){
				continue;
			}

			$return[] = array( $thisHandler, $params );

			if( (NULL !== $limit) && ($limit >= count($return)) ){
				break;
			}
		}

		return $return;
	}

	public function add( $contextRoute, $handler )
	{
		if( $this->closed ){
			echo __CLASS__ . ': closed for new routes<br>';
			return;
		}

		list( $context, $route ) = $this->_prepareContextRoute( $contextRoute );

		if( ! isset($this->routes[$context]) ){
			$this->routes[$context] = array();
		}
		$this->routes[$context][] = array( $route, $handler );

		return $this;
	}

	public function prepend( $contextRoute, $handler )
	{
		if( $this->closed ){
			echo __CLASS__ . ': closed for new routes<br>';
			return;
		}

		list( $context, $route ) = $this->_prepareContextRoute( $contextRoute );

		if( ! isset($this->routes[$context]) ){
			$this->routes[$context] = array();
		}
		array_unshift( $this->routes[$context], array( $route, $handler) );

		return $this;
	}

	protected function _prepareContextRoute( $contextRoute )
	{
		$contextRouteArray = explode( '/', $contextRoute, 2 );
		$context = $contextRouteArray[0];
		$route = isset($contextRouteArray[1]) ? $contextRouteArray[1] : '';
		$return = array( $context, $route );
		return $return;
	}

	public function alias( $alias, $real )
	{
		if( ! isset($this->aliases[$alias]) ){
			$this->aliases[$alias] = array();
		}
		$this->aliases[$alias][] = $real;
		return $this;
	}

/* if we close then it 1) expands aliases; 2) gets unavailable for adding new routes */
	public function close( array $contexts = array() )
	{
		$this->closed = TRUE;

		if( ! $contexts ){
			$contexts = array_keys( $this->routes );
		}

	// expand aliases
		foreach( $contexts as $context ){
			$count = count( $this->routes[$context] );
			for( $ii = ($count - 1); $ii >= 0; $ii-- ){
				list( $thisRoute, $thisHandler ) = $this->routes[$context][$ii];

				$first = strpos( $thisRoute, '{' );
				if( FALSE === $first ){
					// not aliased
					continue;
				}

				$realRoutes = $this->expandAlias( $thisRoute );
				$expandedRoutes = array();
				foreach( $realRoutes as $realRoute ){
					$expandedRoutes[] = array( $realRoute, $thisHandler );
				}

				array_splice( $this->routes[$context], $ii, 1, $expandedRoutes );
			}
		}

	// convert to re's where needed
		foreach( $contexts as $context ){
			$count = count( $this->routes[$context] );
			for( $ii = ($count - 1); $ii >= 0; $ii-- ){
				list( $thisRoute, $thisHandler ) = $this->routes[$context][$ii];

				if( (FALSE !== strpos($thisRoute, ':')) OR (FALSE !== strpos($thisRoute, '*')) ){
					$re = $this->makeRe($thisRoute);
					$this->routes[$context][$ii][0] = $re;
				}
			}
		}

		return $this;
	}

	public function makeRe( $route )
	{
		static $cache = array();

		if( isset($cache[$route]) ){
			return $cache[$route];
		}

		$return = $route;

		if( '*' === $return ){
			$return = '.*';
		}
		else {
			$return = str_replace( '*', '.+', $return );
			$return = str_replace( '[', '(', $return );
			$return = str_replace( ']', ')', $return );

			// $re = str_replace( ':id', '[\w\-]+', $return );
			$return = str_replace( ':id', '[\d\_\-]+', $return );
		// find :param like things
			$return = preg_replace( '/\:(\w+)/', '[^\/]+', $return );
		}

		$return = '%^' . $return . '$%';

		$cache[$route] = $return;
		return $return;
	}

	public function expandAlias( $route )
	{
		static $cache = array();
		if( isset($cache[$route]) ){
			return $cache[$route];
		}

		$return = array();

		$first = strpos( $route, '{' );
		$second = strpos( $route, '}', $first );
		$alias = substr( $route, $first, $second - $first + 1 );

		if( ! isset($this->aliases[$alias]) ){
			return $return;
		}

		reset( $this->aliases[$alias] );
		foreach( $this->aliases[$alias] as $aliasReplace ){
			$realRoute = substr_replace( $route, $aliasReplace, $first, $second - $first + 1 );

		// no more aliases
			$first = strpos( $realRoute, '{' );
			if( FALSE === $first ){
				$return[] = $realRoute;
			}
			else {
				$realRoutes = $this->expandAlias( $realRoute );
				$return = array_merge( $return, $realRoutes );
			}
		}

		$cache[$route] = $return;
		return $return;
	}
}