<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Session_Boot
{
/**
*	$config
*		['prefix']	string Session name prefix
*
*	@param array $config
*	@return array
*/

	public static function bind( array $config = array() )
	{
		$bind = array();
		$bind['HC4_Session_Interface'] = 'HC4_Session_Implementation';

		if( isset($config['prefix']) ){
			$bind['HC4_Session_Implementation->prefix'] = $config['prefix'];
		}

		return $bind;
	}

	public function __invoke()
	{}
}