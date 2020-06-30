<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Redirect_Boot
{
	public static function bind()
	{
		$bind = array();
		$bind['HC4_Redirect_Interface'] = 'HC4_Redirect_Header';
		return $bind;
	}

	public function __invoke()
	{}
}