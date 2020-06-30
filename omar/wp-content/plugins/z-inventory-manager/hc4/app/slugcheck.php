<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_App_SlugCheck
{
	public function _import(
		HC4_App_Router $router,
		HC4_App_Factory $factory
	)
	{}

	public function __invoke( $requestMethod, $slug, $postData = NULL )
	{
		$return = TRUE;

		$requestMethod = 'CHECK:' . $requestMethod;
		$handlers = $this->router->find( $requestMethod, $slug );

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

		return $return;
	}
}