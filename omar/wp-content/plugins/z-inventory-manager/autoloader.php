<?php
return function( $srcDirs = array() )
{
	return function( $inclass ) use ( $srcDirs )
	{
		$class = $inclass;
		// $class = trim( $class );

		if( ! (('_' == substr($class, 3, 1)) OR ('_' == substr($class, 4, 1))) ){
			return;
		}

		$class = strtolower( $class );

	// by default search in the current dir
		$dir = __DIR__;
		$shortClass = $class;

	// or find dir of the module
		foreach( $srcDirs as $prefix => $moduleDir ){
			if( substr($class, 0, strlen($prefix) + 1) == $prefix . '_' ){
				$dir = $moduleDir;
				$shortClass = substr( $class, strlen($prefix) + 1 );
				break;
			}
			elseif( '*' === $prefix ){
				$dir = $moduleDir;
				break;
			}
		}

		$thisFile = str_replace( '_', '/', $shortClass ) . '.php';
		$thisFile = $dir . '/' . $thisFile;
		$fileExists = file_exists( $thisFile );

		if( $fileExists ){
			require( $thisFile );
	// echo "'" . $thisFile . "',<br>";
		}
		else {
	// echo "HC4 FOR '$inclass' TRIED $thisFile<br>\n";
		}

		return;
	};
};