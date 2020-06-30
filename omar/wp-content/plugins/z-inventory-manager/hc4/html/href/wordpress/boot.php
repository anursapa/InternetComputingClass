<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Href_WordPress_Boot
{
/**
*	$config
*		['app_short_name']	string Used to make links like hcs=zi2 
*		['plugin_file']		string Full path to current plugin, used in many WP functions 
*		['assets']				array Defines path for certain prefixes, like this: 'hc4' => 'path1' 
*
*	@param array $config
*	@return array
*/

	public static function bind( array $config = array() )
	{
		$bind = array();
		$bind['HC4_Html_Href_Interface'] = 'HC4_Html_Href_WordPress_Implementation';

		if( isset($config['assets']) ){
			$bind['HC4_Html_Href_WordPress_Implementation->assetSrc'] = $config['assets'];
		}
		if( isset($config['app_short_name']) ){
			$bind['HC4_Html_Href_WordPress_Implementation->appShortName'] = $config['app_short_name'];
		}
		if( isset($config['plugin_file']) ){
			$bind['HC4_Html_Href_WordPress_Implementation->pluginFile'] = $config['plugin_file'];
		}

		return $bind;
	}

	public function __invoke()
	{}
}