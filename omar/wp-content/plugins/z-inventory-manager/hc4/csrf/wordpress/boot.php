<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Csrf_WordPress_Boot
{
	public static function bind()
	{
		$bind = array();
		$bind['HC4_Csrf_Interface'] = 'HC4_Csrf_Wordpress_Implementation';
		return $bind;
	}

	public function __invoke()
	{}
}