<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Migration_Boot
{
	public static function bind()
	{
		$bind = array();
		$bind['HC4_Migration_Interface'] = 'HC4_Migration_Settings';
		return $bind;
	}

	public function __invoke()
	{}
}