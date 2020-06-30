<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Database_WordPress_Boot
{
	public static function bind()
	{
		$bind = array();

		$bind['HC4_Database_Interface'] = array();
		$bind['HC4_Database_Interface'][] = 'HC4_Database_Wordpress_Implementation';
		$bind['HC4_Database_Interface'][] = 'HC4_Database_Profiled';
		$bind['HC4_Database_Interface'][] = 'HC4_Database_Prefixed';

		global $wpdb;
		$bind['HC4_Database_Prefixed->prefix'] = $wpdb->prefix;

		return $bind;
	}

	public function __invoke()
	{}
}