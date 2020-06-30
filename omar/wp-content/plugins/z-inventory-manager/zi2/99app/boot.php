<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_99App_Boot
{
	public static function bind()
	{
		$return = array();
		$return['ZI2_99App_Ui_Promo'] = 'ZI2_99App_Ui_Promo_Promo';
		return $return;
	}

	private function _import(
		HC4_Migration_Interface $migration,

		HC4_Settings_Interface $settings,
		HC4_Time_Interface $t,
		HC4_Time_Format $tf,

		HC4_App_Events $events,
		HC4_App_Router $router,
		HC4_Html_Screen_Config $screen
	)
	{}

	public function __invoke()
	{
		$this->migration
			->register( 'app', 1, 'ZI2_99App_Data_Migration@version1' )
			;

		$this->tf->dateFormat = $this->settings->get( 'datetime_date_format', 'j M Y' );
		$this->tf->timeFormat = $this->settings->get( 'datetime_time_format', 'g:ia' );
		$this->t->weekStartsOn = $this->settings->get( 'datetime_week_starts', 0 );

		$this->screen
			->css( '*',	'hc4/assets/hc.css' )
			->css( '*',	'hc4/assets/hc4-theme.css' )
			;

		$this->router
			->add( 'GET',	'ZI2_99App_Ui_Index@get' )
			;

		$this->screen
			->title( '', 	'ZI2_99App_Ui_Index@title' )
			;

		$this->router
			->add( 'GET/upgrade',	'ZI2_99App_Ui_Upgrade@get' )
			;

	// ADD PROMO
		$this->events
			->listen( 'HC4_Html_Screen_Config@getHeader', 'ZI2_99App_X_Html_Screen_Config_GetHeader' )
			;
	}
}