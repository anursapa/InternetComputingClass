<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Translate_WordPress_Boot
{
/**
*	$config
*		['domain']		string
*		['plugin_dir']	string
*		['locale']		string Force locale, otherwise WordPress' one is used
*
*	@param array $config
*	@return array
*/

	public static function bind( array $config = array() )
	{
		$bind = array();
		$bind['HC4_Translate_Interface'] = 'HC4_Translate_WordPress_Implementation';

		if( isset($config['domain']) ){
			$bind['HC4_Translate_WordPress_Implementation->domain'] = $config['domain'];
		}
		if( isset($config['plugin_dir']) ){
			$bind['HC4_Translate_WordPress_Implementation->pluginDir'] = $config['plugin_dir'];
		}
		if( isset($config['locale']) ){
			$bind['HC4_Translate_WordPress_Implementation->locale'] = $config['locale'];
		}

		return $bind;
	}

	public function __invoke()
	{}
}