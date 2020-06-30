<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
if( ! function_exists('_print_r') ){
	function _print_r( $thing )
	{
		echo '<pre>';
		print_r( $thing );
		echo '</pre>';
	}
}

class HC4_App_Index
{
	protected $logFile = NULL;

	protected $modules = array();
	protected $factory = NULL;
	protected $myConfig = array();
	protected $profiler = NULL;

	protected $router = NULL;
	protected $slugCheck = NULL;

/**
*	$modulesConfig
*		['hc4_app']
*			['debug_post']			boolean
*			['events']['debug']	boolean
*			['profiler']			boolean
*
*	@param array $config
*	@return array
*/

	public function __construct( array $modulesConfig )
	{
		if( isset($modulesConfig['hc4_app']) ){
			$this->myConfig = $modulesConfig['hc4_app'];
		}

		if(
			( isset($this->myConfig['profiler']) && $this->myConfig['profiler'] ) OR
			( array_key_exists('hcprofiler', $_GET) && $_GET['hcprofiler'] )
			){
				$this->profiler = new HC4_App_Profiler;
			}

if( $this->profiler ){
	$this->profiler->markFactoryStackStart( __CLASS__ );
}

		$finalModules = array();
	// if submodule, also include parent module(s)
		foreach( $modulesConfig as $module => $moduleConfig ){
			$module = strtolower( $module );
			$moduleArray = explode( '_', $module );
			while( count($moduleArray) > 2 ){
				array_pop( $moduleArray );
				$parentModule = join( '_', $moduleArray );
				if( ! in_array($parentModule, $finalModules) ){
					$finalModules[ $parentModule ] = array();
				}
			}
			$finalModules[ $module ] = $moduleConfig;
		}
		$this->modules = $finalModules;
	}

	public function boot()
	{
if( $this->profiler ){
	$this->profiler->markFactoryStackStart( __CLASS__ . '@' . __FUNCTION__ );
}
	// init factory
		$this->factory = new HC4_App_Factory( $this->modules, $this->profiler );

		reset( $this->modules );
		foreach( array_keys($this->modules) as $moduleName ){
			if( 'hc4_' == substr($moduleName, 0, strlen('hc4_')) ){
				// continue;
			}

			$moduleClassName = $moduleName . '_Boot';
			if( class_exists($moduleClassName) ){
				$moduleBoot = $this->factory->make( $moduleClassName );
				call_user_func( $moduleBoot );
			}
		}

	// MIGRATIONS
		if( isset($this->modules['hc4_migration']) ){
			$migration = $this->factory->make( 'HC4_Migration_Interface' );
			$migration->up();
		}

		$this->slugCheck = $this->factory->make( 'HC4_App_SlugCheck' );
		$this->router = $this->factory->make( 'HC4_App_Router' );

if( $this->profiler ){
	$this->profiler->markFactoryStackEnd();
}
	}

	public function handleRequest( $defaultSlug = NULL )
	{
// if( $this->profiler ){
	// $this->profiler->markFactoryStackStart( __CLASS__ . '@' . __FUNCTION__ );
// }
		$uri = new HC4_App_Uri();
		$slug = $uri->getSlug();
		if( ! strlen($slug) ){
			$slug = $defaultSlug;
		}

		if( NULL !== strpos($slug, '$') ){
			$slug = str_replace( '$', '#', $slug );
		}

		$request = new HC4_App_Request;
		$requestMethod = $request->getMethod();

		$isAjax = $request->isAjax();
		if( ':ajax' == substr($slug, -strlen(':ajax')) ){
			$isAjax = TRUE;
			$slug = substr($slug, 0, -strlen(':ajax'));
		}

		$postData = NULL;
		if( in_array($requestMethod, array('post', 'put', 'patch')) ){
			$postData = $request->getPost();
		}

	// LOG
		$this->logRequest( $request, $slug );

		$result = NULL;

		$result = $this->handle( $requestMethod, $slug, $postData );
		$result = $this->_processResult( $slug, $result, $postData, $isAjax );

		if( $this->profiler ){
			$this->profiler->markEnd( 'handle' );
			$result = $this->profiler->render( $result );
			// $return = $this->profiler->run();
		}

		return $result;
	}

	public function factory( $className )
	{
		return $this->factory->make( $className );
	}

	public function handle( $requestMethod, $slug, $postData = NULL )
	{
if( $this->profiler ){
	$this->profiler->markFactoryStackStart( __CLASS__ . '@' . __FUNCTION__ );
}
		$return = NULL;

		$return = call_user_func( $this->slugCheck, $requestMethod, $slug, $postData );
		if( FALSE === $return ){
			$return = FALSE;
			return $return;
		}

		$handlers = $this->router->find( $requestMethod, $slug );

		if( ! $handlers ){
			$return = "NOTHING TO HANDLE THIS REQUEST: '$requestMethod:$slug'<br>";
if( $this->profiler ){
	$this->profiler->markFactoryStackEnd();
}
			return $return;
		}

		foreach( $handlers as $h ){
			list( $handler, $args ) = $h;

		// ADD POST TO ARGUMENTS
			if( NULL !== $postData ){
				array_unshift( $args, $postData );
			}
		// ADD SLUG TO ARGUMENTS
			array_unshift( $args, $slug );

			$handler = trim( $handler );
			$method = NULL;

			if( FALSE !== strpos($handler, '@') ){
				list( $handler, $method ) = explode( '@', $handler );
			}

			$handler = $this->factory->make( $handler );
			if( $method ){
				$handler = array( $handler, $method );
			}

		// HANDLE
			try {
				$return = call_user_func_array( $handler, $args );
			}
			catch( HC4_App_Exception_DataError $e ){
				if( isset($this->modules['hc4_session']) ){
					$session = $this->factory->make( 'HC4_Session_Interface' );
					$error = $e->getMessage();
					$session->setFlashdata( 'error', $error );
					$session->setFlashdata( 'post', $postData );
				}
				$return = array( $slug, NULL, $error );
			}
			catch( HC4_App_Exception_FormErrors $e ){
				if( isset($this->modules['hc4_session']) ){
					$session = $this->factory->make( 'HC4_Session_Interface' );
					$session->setFlashdata( 'form_errors', $e->getErrors() );
					$session->setFlashdata( 'post', $postData );
				}
				$return = array( $slug, NULL );
			}

			if( NULL !== $return ){
				break;
			}
		}

if( $this->profiler ){
	$this->profiler->markFactoryStackEnd();
}

		return $return;
	}

	protected function _processResult( $slug, $result, $postData, $isAjax )
	{
	// AUTH CHECK FAILED
		if( FALSE === $result ){
			$result = array( 'notallowed', NULL );
		}

	// IF STRING THEN SHOW IT
		if( ! is_array($result) ){
			$this->close();

		// PROCESS CHILD REQUESTS IF ANY
			preg_match_all( '/\<\#(.+)\>/U', $result, $ma );
			$count = count( $ma[0] );
			for( $ii = 0; $ii < $count; $ii++ ){
				// $childSlug = $slug . '/' . $ma[1][$ii];

				$search = $ma[0][$ii];

				$childTo = $slug . '#' . $ma[1][$ii];
				$childResult = $this->handle( 'get', $childTo );

				$result = str_replace( $search, $childResult, $result );
			}

			if( isset($this->modules['hc4_html_screen']) ){
				$screen = $this->factory->make( 'HC4_Html_Screen_Interface' );
				$result = call_user_func( $screen, $slug, $result, $isAjax );
			}

			return $result;
		}

	// REDIRECT OR HEADER STATUS
		$to = array_shift( $result );
		$msg = array_shift( $result);
		$error = array_shift( $result );

	// HEADER WITH HTTP STATUS
		if( is_numeric($to) ){
			$out = array();
			if( $msg ){
				$out['message'] = $message;
			}
			if( $error ){
				$out['error'] = $error;
			}

		// CLOSING
			$this->close();

			HC4_App_Functions::httpStatusCode( $to );
			header( 'Content-type: application/json' );
			$out = json_encode( $out );
			echo $out;
			exit;
		}

	// SET ERRORS IN SESSION
		if( isset($this->modules['hc4_session']) ){
			$session = $this->factory->make( 'HC4_Session_Interface' );
			if( $error ){
				$session->setFlashdata( 'error', $error );
				$session->setFlashdata( 'post', $postData );
			}
			if( $msg ){
				$session->setFlashdata( 'message', $msg );
			}
		}

	// IF GET THEN SHOW THE NEW TARGET
		if( NULL === $postData ){
			return $this->handle( 'get', $to );
		}

	// IF POST THEN REDIRECT
		$this->close();

		$uri = new HC4_App_Uri();
		$to = $uri->makeUrl( $to );

		if( isset($this->myConfig['debug_post']) && $this->myConfig['debug_post'] && (! $isAjax) ){
			$return = 'DEBUG POST<br>';
			$return .= '<a href="' . $to . '">' . $to . '</a>';
			$screen = $this->factory->make( 'HC4_Html_Screen_Interface' );
			$return = call_user_func( $screen, 'debug', $return, $isAjax );
			return $return;
		}
		else {
			$redirectClass = $isAjax ? 'HC4_Redirect_Ajax' : 'HC4_Redirect_Interface';
			$redirect = $this->factory->make( $redirectClass );
			call_user_func( $redirect, $to );
			exit;
		}
	}

	public function check( $method, $slug, $postData = NULL )
	{
if( $this->profiler ){
	$this->profiler->markFactoryStackStart( __CLASS__ . '@' . __FUNCTION__ );
}
		$return = TRUE;

		$method = 'CHECK:' . $method;
		$handlers = $this->router->find( $method, $slug );

		foreach( $handlers as $h ){
			list( $handler, $args ) = $h;

		// ADD POST TO ARGUMENTS
			if( NULL !== $postData ){
				array_unshift( $args, $postData );
			}
		// ADD SLUG TO ARGUMENTS
			array_unshift( $args, $slug );

			$handler = trim( $handler );
			$method = NULL;

			if( FALSE !== strpos($handler, '@') ){
				list( $handler, $method ) = explode( '@', $handler );
			}
			$handler = $this->factory->make( $handler );
			if( NULL !== $method ){
				$handler = array( $handler, $method );
			}

		// HANDLE
			$return = call_user_func_array( $handler, $args );
			if( NULL !== $return ){
				break;
			}
		}

if( $this->profiler ){
	$this->profiler->markFactoryStackEnd();
}

		return $return;
	}

	public function close()
	{
		reset( $this->modules );
		foreach( array_keys($this->modules) as $moduleName ){
			$moduleClassName = $moduleName . '_Close';
			if( class_exists($moduleClassName) ){
				$module = $this->factory->make( $moduleClassName );
			}
		}
		return $this;
	}

	public function logRequest( $request, $slug )
	{
		if( ! $this->logFile ){
			return;
		}

		$out = array();
		$out[] = $request->getIpAddress();
		$out[] = $request->getMethod();
		$out[] = $slug;

		$postData = $request->getPost();
		if( $postData ){
			$out[] = http_build_query( $postData );
		}

		$this->log( $out );
		return $this;
	}

	public function log( array $log = array() )
	{
		if( ! $this->logFile ){
			return;
		}

		if( ! $log ){
			return;
		}

		$now = date( 'j M Y g:ia', time() );
		array_unshift( $log, $now );

		$out = join( "\t", $log );

		$fp = fopen( $this->logFile, 'a' );
		fwrite( $fp, $out . "\n" );
		fclose( $fp );

		return $this;
	}
}