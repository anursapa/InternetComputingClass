<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Auth_Wordpress_Boot
{
	public static function bind()
	{
		$bind = array();
		$bind['HC4_Auth_Interface'] = 'HC4_Auth_WordPress_Implementation';
		return $bind;
	}

	public function __invoke()
	{}
}