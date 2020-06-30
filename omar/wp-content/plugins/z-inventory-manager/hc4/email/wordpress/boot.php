<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Email_Wordpress_Boot
{
	public static function bind()
	{
		$bind = array();
		$bind['HC4_Email_Interface'] = 'HC4_Email_Wordpress_Implementation';
		return $bind;
	}

	public function __invoke()
	{}
}