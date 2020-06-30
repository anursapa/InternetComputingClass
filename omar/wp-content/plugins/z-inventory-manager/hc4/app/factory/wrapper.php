<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_App_Factory_Wrapper
{
	public $src;
	protected $srcClassName;

	public function __construct( $src )
	{
		$this->src = $src;
		$this->srcClassName = strtolower( get_class($this->src) );
	}

	public function _import(
		HC4_App_Factory $factory,
		HC4_App_Events $events,
		HC4_App_Profiler $profiler = NULL
	)
	{}

	public function __invoke()
	{
		if( ! is_callable($this->src) ){
			echo __CLASS__ . ': ' . get_class($this->src) . ' IS NOT CALLABLE!<br>';
			return;
		}

		if( $this->profiler ){
			$stack = $this->srcClassName . '@';
			$this->profiler->markFactoryStackStart( $stack );
		}

		$args = func_get_args();
		$return = call_user_func_array( $this->src, $args );

		$eventName = $this->srcClassName;
		$return = $this->events->filter( $eventName, $return, $args );

		if( $this->profiler ){
			$this->profiler->markFactoryStackEnd( $stack );
		}

		return $return;
	}

	public function __call( $method, $args )
	{
		if( $this->profiler ){
			$stack = $this->srcClassName . '@' . strtolower($method);
			$this->profiler->markFactoryStackStart( $stack );
		}

		$return = call_user_func_array( array($this->src, $method), $args );

		$eventName = $this->srcClassName . '@' . strtolower($method);
		$return = $this->events->filter( $eventName, $return, $args );

		if( $return === $this->src ){
			$return = $this;
		}

		if( $this->profiler ){
			$this->profiler->markFactoryStackEnd();
		}

		return $return;
	}
}