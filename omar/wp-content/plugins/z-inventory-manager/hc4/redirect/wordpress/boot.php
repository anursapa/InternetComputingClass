<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Redirect_WordPress_Boot
{
	public static function bind()
	{
		$bind = array();
		$bind['HC4_Redirect_Interface'] = 'HC4_Redirect_Wordpress_Implementation';
		return $bind;
	}

	public function __invoke()
	{}
}