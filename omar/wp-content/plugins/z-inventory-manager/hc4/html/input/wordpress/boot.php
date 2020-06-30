<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Input_WordPress_Boot
{
	public static function bind()
	{
		$bind = array();
		$bind['HC4_Html_Input_RichTextarea'] = 'HC4_Html_Input_WordPress_RichTextarea';
		return $bind;
	}

	public function __invoke()
	{}
}