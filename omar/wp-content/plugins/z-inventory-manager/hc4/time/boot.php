<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Time_Boot
{
	public static function bind()
	{
		$bind = array();
		$bind['HC4_Time_Interface'] = 'HC4_Time_Implementation';
		return $bind;
	}

	public function __invoke()
	{}
}