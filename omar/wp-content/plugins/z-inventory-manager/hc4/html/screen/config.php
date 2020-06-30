<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface HC4_Html_Screen_Config_
{
	public function css( $slugPreg, $path );
	public function js( $slugPreg, $path );
	public function title( $slugPreg, $value );
	public function header( $slugPreg, $value );
	public function breadcrumbTitle( $slugPreg, $value );
	public function breadcrumb( $slug, $value );
	public function menu( $slugPreg, $menuLink );

	public function getCss( $slug );
	public function getJs( $slug );
	public function getTitle( $slug );
	public function getMenu( $slug );
	public function getBreadcrumb( $slug, $limit = NULL );
	public function getSubheader( $slug );
	public function getHeader( $slug );
}

class HC4_Html_Screen_Config
implements HC4_Html_Screen_Config_
{
	public function _import(
		HC4_App_Factory $factory,
		HC4_App_Router $router
	)
	{}

// CSS
	public function css( $slug, $path )
	{
		$this->router->add( 'CSS/' . $slug, $path );
		return $this;
	}
	public function getCss( $slug, $noFullScreen = FALSE )
	{
		return $this->_routerFindMany( 'CSS', $slug );
	}

// JS
	public function js( $slug, $path )
	{
		$this->router->add( 'JS/' . $slug, $path );
		return $this;
	}
	public function getJs( $slug, $noFullScreen = FALSE )
	{
		return $this->_routerFindMany( 'JS', $slug );
	}

// HEADER
	public function header( $slug, $path )
	{
		$this->router->add( 'HEADER/' . $slug, $path );
		return $this;
	}
	public function getHeader( $slug )
	{
		return $this->_routerFindOne( 'HEADER', $slug );
	}

// SUBHEADER
	public function subheader( $slug, $path )
	{
		$this->router->add( 'SUBHEADER/' . $slug, $path );
		return $this;
	}
	public function getSubheader( $slug )
	{
		return $this->_routerFindOne( 'SUBHEADER', $slug );
	}

// SUBFOOTER
	public function subfooter( $slug, $path )
	{
		$this->router->add( 'SUBFOOTER/' . $slug, $path );
		return $this;
	}

	public function getSubfooter( $slug )
	{
		return $this->_routerFindOne( 'SUBFOOTER', $slug );
	}

// TITLE
	public function title( $slug, $value )
	{
		$this->router->add( 'TITLE/' . $slug, $value );
		return $this;
	}

	public function getTitle( $slug )
	{
		return $this->_routerFindOne( 'TITLE', $slug );
	}

// BREADCRUMB
	public function breadcrumb( $slug, $value )
	{
		$this->router->add( 'BREADCRUMB/' . $slug, $value );
		return $this;
	}

	public function getBreadcrumbExplicit( $slug )
	{
		$return = FALSE;

		$results = $this->router->find( 'BREADCRUMB', $slug, 1 );
		if( $results ){
			$results = $this->_processRouterResults( $slug, $results );
			$return = array_shift( $results );
		}

		return $return;
	}

	public function getBreadcrumb( $slug, $limit = NULL )
	{
		$return = array();
		if( ! $slug ){
			return $return;
		}

		$explicitParent = $this->getBreadcrumbExplicit( $slug );

		if( NULL !== $explicitParent ){
			if( $explicitParent ){
				$parentSlug = $explicitParent;
			}
			else {
				$slugParts = explode( '/', $slug );
				array_pop( $slugParts );
				$parentSlug = join( '/', $slugParts );
			}

			$thisTitle = $this->getBreadcrumbTitle( $parentSlug );
			if( FALSE === $thisTitle ){
				$thisTitle = $this->getTitle( $parentSlug );
			}

			if( $thisTitle ){
				if( is_array($thisTitle) ){
					$thisTitle = $thisTitle[0];
					$thisTitle = strip_tags( $thisTitle );
				}
				$return[] = array( $parentSlug, $thisTitle );
			}

			if( NULL === $limit ){
				$parentReturn = $this->getBreadcrumb( $parentSlug );
				$return = array_merge( $parentReturn, $return );
			}
			else {
				if( $limit ){
					$limit--;
					$parentReturn = $this->getBreadcrumb( $parentSlug, $limit );
					$return = array_merge( $parentReturn, $return );
				}
			}
		}

		return $return;
	}

	public function breadcrumbTitle( $slug, $value )
	{
		$this->router->add( 'BREADCRUMBTITLE/' . $slug, $value );
		return $this;
	}

	public function getBreadcrumbTitle( $slug )
	{
		$return = FALSE;

		$results = $this->router->find( 'BREADCRUMBTITLE', $slug, 1 );
		if( $results ){
			$results = $this->_processRouterResults( $slug, $results );
			$return = array_shift( $results );
		}

		return $return;
	}

// MENU
	public function menu( $slug, $value )
	{
		$this->router->add( 'MENU/' . $slug, $value );
		return $this;
	}

	public function getMenu( $slug )
	{
		$rawReturn = $this->_routerFindMany( 'MENU', $slug );

		$return = array();

	// straight out
		foreach( $rawReturn as $rm ){
			if( isset($rm[0]) && is_array($rm[0]) ){
				foreach( $rm as $rm2 ){
					$return[] = $rm2;
				}
			}
			else {
				$return[] = $rm;
			}
		}

	// priority
		$order = 100;
		$count = count( $return );
		for( $ii = 0; $ii < $count; $ii++ ){
			if( ! isset($return[$ii][2]) ){
				$return[$ii][2] = $order++;
			}
		}

		usort( $return, function($a, $b){
			return ( $a[2] > $b[2] );
		});

		return $return;
	}

// HELPERS
	protected function _routerFindOne( $context, $slug, $autorun = TRUE )
	{
		$return = NULL;

		$results = $this->router->find( $context, $slug, 1 );
		if( $results ){
			$results = $this->_processRouterResults( $slug, $results, $autorun );
			$return = array_shift( $results );
		}

		return $return;
	}

	protected function _routerFindMany( $context, $slug )
	{
		$return = NULL;

		$results = $this->router->find( $context, $slug );
		$return = $this->_processRouterResults( $slug, $results );

		return $return;
	}

	protected function _processRouterResults( $slug, array $results, $autorun = TRUE )
	{
		$return = array();

		foreach( $results as $result ){
			list( $thisOne, $params ) = $result;

			if( is_array($thisOne) ){
				
			}
			else {
				if( strpos($thisOne, '@') !== FALSE ){
					list( $className, $method ) = explode( '@', $thisOne );
					$thisOne = $this->factory->make( $className );

					if( $autorun ){
						$args = $params;
						// $args = array_slice( $args, 1 );
						array_unshift( $args, $slug );
						if( strlen($method) ){
							$thisOne = array($thisOne, $method);
						}
						$thisOne = call_user_func_array( $thisOne, $args );
					}
				}
				else {
					if( count($params) > 1 ){
						for( $ii = 1; $ii < count($params); $ii++ ){
							$search = '{$' . $ii . '}';
							$replace = $params[$ii];
							$thisOne = str_replace( $search, $replace, $thisOne );
						}
					}
				}
			}

			if( is_array($thisOne) && (! $thisOne) ){
				continue;
			}

			// if( ! $thisOne ){
				// continue;
			// }

			$return[] = $thisOne;
		}

		return $return;
	}
}