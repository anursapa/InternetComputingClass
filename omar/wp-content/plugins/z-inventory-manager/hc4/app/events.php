<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface HC4_App_Events_
{
/* NOTIFY ABOUT EVENTS */
	public function filter( $eventName, $return, $args );

/* register listener */
	public function listen( $eventClassName, $listenerClassName );
}

class HC4_App_Events
implements HC4_App_Events_
{
	protected $listeners = array();
	protected $filters = array();
	protected $debug = FALSE;

	public function __construct(
		HC4_App_Factory $factory,
		HC4_App_Profiler $profiler = NULL,
		$debug = FALSE
	)
	{
		$this->factory = $factory;
		$this->profiler = $profiler;
		$this->debug = $debug;
	}

	public function listen( $eventClassName, $listener )
	{
		// $constructorArgs = $this->factory->getArgs( $listenerClassName, '__construct' );
		// if( ! $constructorArgs ){
			// return $this;
		// }
		// $eventClassName = $constructorArgs[0]->getClass()->getName();

		$eventClassName = strtolower( $eventClassName );

		$listenerClassName = is_object( $listener ) ? get_class( $listener ) : $listener;
		$listenerClassName = strtolower( $listenerClassName );

		if( $this->debug ){
			if( ! $this->checkExists($eventClassName) ){
				echo __CLASS__ . ": event '$eventClassName' doesn't exist<br>";
				return $this;
			}
			if( ! $this->checkExists($listenerClassName) ){
				echo __CLASS__ . ": event listener '$listenerClassName' doesn't exist<br>";
				return $this;
			}
		}

		if( ! isset($this->listeners[$eventClassName]) ){
			$this->listeners[$eventClassName] = array();
		}
		$this->listeners[$eventClassName][$listenerClassName] = $listener;

		return $this;
	}

	public function filter( $eventName, $return, $args )
	{
		$eventName = strtolower( $eventName );

		$listeners = array();

		if( isset($this->listeners['*']) ){
			$listeners = array_merge( $listeners, $this->listeners['*'] );
		}

		if( isset($this->listeners[$eventName]) ){
			$listeners = array_merge( $listeners, $this->listeners[$eventName] );
		}

		foreach( $listeners as $listener ){
			if( $listener === $eventName ){
				continue;
			}

			if( is_callable($listener) ){
			}
			if( FALSE === strpos($listener, '@') ){
				$listener = $this->factory->make( $listener );
			}
			else {
				list( $listenerClassName, $listenerMethodName ) = explode( '@', $listener );
				$listener = $this->factory->make( $listenerClassName );
				$listener = array( $listener, $listenerMethodName );
			}

			$argsToListener = array_merge( array($eventName, $return), $args );
			$thisReturn = call_user_func_array( $listener, $argsToListener );
			if( NULL !== $thisReturn ){
				$return = $thisReturn;
			}
		}

		return $return;
	}

	public function checkExists( $eventName )
	{
		$return = TRUE;

		if( '*' === $eventName ){
			return $return;
		}

		if( FALSE !== strpos($eventName, '@') ){
			list( $className, $methodName ) = explode( '@', $eventName );
		}
		else {
			$className = $eventName;
			$methodName = NULL;
		}

		if( ! (class_exists($className) OR interface_exists($className)) ){
			$return = FALSE;
			return $return;
		}

		if( (NULL !== $methodName) && (! method_exists($className, $methodName)) ){
			$return = FALSE;
			return $return;
		}

		return $return;
	}
}