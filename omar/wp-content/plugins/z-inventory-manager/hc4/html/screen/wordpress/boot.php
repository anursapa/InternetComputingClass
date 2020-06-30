<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Screen_WordPress_Boot
{
	public static function bind()
	{
		$ns = 'HC4_Html_Screen_WordPress_';

		$bind = array();
		$bind['HC4_Html_Screen_Interface'] = $ns . 'Implementation';
		$bind['HC4_Html_Screen_Enqueuer_Interface'] = $ns . 'Enqueuer';

		return $bind;
	}

	public function _import(
		HC4_App_Events $events
	)
	{}

	public function __invoke()
	{
		$ns = 'HC4_Html_Screen_WordPress_';

		$this->events
			->listen( 'HC4_Html_Screen_Layout_MenuItem', $ns . 'Layout_MenuItem' )
			;
	}
}