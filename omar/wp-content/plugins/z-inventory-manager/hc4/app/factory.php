<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_App_Factory
{
	protected $modules = array();
	protected $bind = array();

	public $profiler = NULL;
	protected $events = NULL;

	public function __construct( 
		array $modules = array(),
		$profiler
	)
	{
		$bind = array();
		$bind[ __CLASS__ ] = $this;

		$this->profiler = $profiler;
		$bind[ 'hc4_app_profiler' ] = $this->profiler;

	// find bind configurations in modules
		$this->modules = array();
		$ii = 0;
		foreach( $modules as $moduleName => $moduleConfig ){
			$this->modules[ $moduleName ] = $ii++;
			$moduleClassName = $moduleName . '_Boot';
			if( class_exists($moduleClassName) && method_exists($moduleClassName, 'bind') ){
				$thisBind = call_user_func( array($moduleClassName, 'bind'), $moduleConfig );
				$bind = array_merge( $bind, $thisBind );
			}
		}

	// finalize bind
		$this->bind = array();

		reset( $bind );
		foreach( $bind as $k => $v ){
			$k = strtolower( $k );
			if( is_array($v) ){
			}
			elseif( ! is_object($v) ){
				$v = strtolower( $v );
			}
			$this->bind[ $k ] = $v;
		}

		foreach( $modules['hc4_app'] as $k => $v ){
			if( is_array($v) ){
				foreach( $v as $k2 => $v2 ){
					$bindK = 'hc4_app_' . $k . '->' . $k2;
					$this->bind[ $bindK ] = $v2;
				}
			}
		}
	}

	public function bind( $k, $v )
	{
		$k = strtolower( $k );
		if( ! is_object($v) ){
			$v = strtolower( $v );
		}
		$this->bind[ $k ] = $v;
		return $this;
	}


/**
* Makes a functor object of a class. All of them are singletons. 
*
* @param string	$className		A class name to make object.
*
* @return object
*/
	public function make( $className, $wrap = TRUE )
	{
// if( $this->profiler ){
	// $this->profiler->markStart( __METHOD__ );
// }
		static $_reflections = array();

		$className = strtolower( trim($className) );

		if( strtolower(__CLASS__) === $className ){
			return $this;
		}

	// maybe scalar (as param name like Class_Name->param1)
		if( FALSE !== strpos($className, '->') ){
			$return = isset($this->bind[$className]) ? $this->bind[$className] : NULL;
			return $return;
		}

		if( ! isset($this->bind[$className]) ){
			$this->bind[$className] = $className;
		}

	// chain of implementations
		if( is_array($this->bind[$className]) ){
			$chain = $this->bind[$className];
			while( $rexClassName = array_shift($chain) ){
				$rex = $this->make( $rexClassName, $wrap );
				$this->bind[ $className ] = $rex;
			}
		}

	// ALREADY INSTANTIATED
		if( is_object($this->bind[$className]) ){
			$return = $this->bind[$className];
		}
	// CONSTRUCT NEW
		else {
			$realClassName = $this->bind[$className];
			if( ! strlen($realClassName) ){
				return;
			}

if( $this->profiler ){
	$this->profiler->markFactoryStackStart( $realClassName );
}

		// __construct
			$args = $this->_makeArgs( $realClassName, '__construct', FALSE );
			if( $args ){
				$class = new ReflectionClass( $realClassName );
				$return = $class->newInstanceArgs( $args );

			//	automatically assign internal properties
				foreach( $args as $argName => $arg ){
					if( property_exists($return, $argName) ){
						continue;
					}
					$return->{$argName} = $arg;
				}
			}
			else {
				$return = new $realClassName;
			}

		// _import
			$importMethod = '_import';
			if( method_exists($return, $importMethod) ){
				$args = $this->_makeArgs( $realClassName, $importMethod, TRUE );

				foreach( $args as $argName => $arg ){
					if( property_exists($return, $argName) ){
						continue;
					}
					$return->{$argName} = $arg;
				}

				// call_user_func_array( array($return, $importMethod), $args );
			}

if( $this->profiler ){
	$this->profiler->markFactoryStackEnd();
}
		}

		$this->bind[$className] = $return;

		if( $wrap ){
			$importMethod = '_import';
			$wrapperArgs = $this->_makeArgs( 'HC4_App_Factory_Wrapper', $importMethod, FALSE );

			$return = new HC4_App_Factory_Wrapper( $return );
			foreach( $wrapperArgs as $argName => $arg ){
				$return->{$argName} = $arg;
			}
		}

		return $return;
	}

	public function getArgs( $className, $methodName )
	{
		static $_reflections = array();

		$return = array();

		if( is_object($className) ){
			$className = get_class( $className );
		}
		$className = strtolower( $className );

		if( ! isset($_reflections[$className]) ){
			$_reflections[$className] = new ReflectionClass( $className );
		}
		$classReflection = $_reflections[$className];

		if( ! $classReflection->hasMethod($methodName) ){
			return $return;
		}

		$methodReflection = $classReflection->getMethod( $methodName );
		$return = $methodReflection->getParameters();

		return $return;
	}

	protected function _makeArgs( $className, $methodName, $wrap = TRUE )
	{
		static $cache = array();

		$className = strtolower( $className );
		// $methodName = strtolower( $methodName );

		$cacheKey = $className . '::' . $methodName;
		if( isset($cache[$cacheKey]) ){
			return $cache[$cacheKey];
		}

		$return = array();

		$needArgs = $this->getArgs( $className, $methodName );

		$numberOfArgs = count( $needArgs );

		for( $ii = 0; $ii < $numberOfArgs; $ii++ ){
			$needArg = $needArgs[$ii];
			$needArgName = $needArg->getName();

	// NEED TO INJECT MISSING ARGS
			$isOptional = $needArg->isOptional();
			$argCreated = FALSE;

			try {
				$needArgClass = $needArg->getClass();

				if( $needArgClass ){
					$needArgClassName = $needArgClass->getName();
					$needArgClassName = strtolower( $needArgClassName );

				// CHECK CIRCULAR REFERENCE
					if( $needArgClassName === $className ){
						echo __CLASS__ . ': circular reference<br>' . $needArgClassName . ' -> ' . $className . ' -> ' . $needArgClassName . '<br>';
						exit;
					}

				/* NOW CHECK IF THE PARENT CLASS IS ALLOWED TO MAKE ITS ARGUMENT */
				// FIND THE MODULE OF PARENT
					if( ! $this->_isImportAllowed($className, $needArgClassName) ){
						echo "FACTORY: '$className' IS NOT ALLOWED TO MAKE '$needArgClassName'<br>";
						exit;
					}

					$arg = $this->make( $needArgClassName, $wrap );
					$argCreated = TRUE;
				}
				else {
				// if we have scalar binded
					$makeName = $className . '->' . $needArgName;

					$arg = $this->make( $makeName, $wrap );
					if( NULL !== $arg ){
						$argCreated = TRUE;
					}
					else {
						if( $isOptional ){
							$arg = $needArg->getDefaultValue();
							$argCreated = TRUE;
						}
					}
				}
			}
			catch( ReflectionException $e ){
				echo __CLASS__ . ": can't create '$needArgName' $ii argument of '$className::$methodName'!<br>";
				echo $e->getMessage();
				exit;
			}

			if( ! $argCreated ){
				echo  __CLASS__ . ": can't build '$needArgName' $ii argument of '$className::$methodName'!<br>";
				exit;
			}

			$return[ $needArgName ] = $arg;
		}
// if( $this->profiler ){
	// $this->profiler->markEnd( __METHOD__ );
// }

// echo "SET CACHE FOR '$cacheKey'<br>";
		$cache[$cacheKey] = $return;

		return $return;
	}

	protected function _isImportAllowed( $parentClassName, $childClassName )
	{
		static $classesToModules = array();

		$parentModuleIndex = -1;
		$childModuleIndex = -1;

		if( isset($classesToModules[$parentClassName]) ){
			$parentModuleIndex = $classesToModules[$parentClassName];
		}
		if( isset($classesToModules[$childClassName]) ){
			$childModuleIndex = $classesToModules[$childClassName];
		}

		if( ($parentModuleIndex < 0) OR ($childModuleIndex < 0) ){
			reset( $this->modules );
			foreach( $this->modules as $moduleName => $jj ){
				if( $parentModuleIndex < 0 ){
					if( substr($parentClassName, 0, strlen($moduleName) + 1 ) == $moduleName . '_' ){
						$parentModuleIndex = $jj;
					}
				}

				if( $childModuleIndex < 0 ){
					if( substr($childClassName, 0, strlen($moduleName) + 1 ) == $moduleName . '_' ){
						$childModuleIndex = $jj;
					}
				}

				if( ($parentModuleIndex >= 0) && ($childModuleIndex >= 0) ){
					break;
				}
			}

			$classesToModules[$parentClassName] = $parentModuleIndex;
			$classesToModules[$childClassName] = $childModuleIndex;
		}

		if( $parentModuleIndex == -1 ){
			echo __CLASS__ . ': module is unknown for ' . $parentClassName . '<br>';
			_print_r( $this->modules );
			exit;
		}

		if( $childModuleIndex == -1 ){
			echo __CLASS__ . ': module is unknown for ' . $childClassName . '<br>';
			_print_r( $this->modules );
			exit;
		}

// echo "$parentClassName:$parentModuleIndex VS $childClassName:$childModuleIndex<br>";
// _print_r( $this->modules );

		$return = ( $parentModuleIndex >= $childModuleIndex );

		if( ! $return ){
// echo "$parentClassName:$parentModuleIndex VS $childClassName:$childModuleIndex<br>";
// _print_r( $this->modules );
		}

		return $return;
	}
}