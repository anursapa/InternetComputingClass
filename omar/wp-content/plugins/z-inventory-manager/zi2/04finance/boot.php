<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_04Finance_Boot
{
	public function _import(
		HC4_Settings_Interface $settings,
		HC4_App_Router $router,
		HC4_Html_Screen_Config $screen
	)
	{}

	public function __invoke()
	{
	// DEFAULTS
		$this->settings
			->init( 'finance_price_format_before', '$' )
			->init( 'finance_price_format_number', array('.', ',') )
			->init( 'finance_price_format_after', '' )
			;

	// UI
		$this->router
			->add( 'GET/admin/conf/finance',		'ZI2_04Finance_Ui_Admin_Conf_Finance@get' )
			->add( 'POST/admin/conf/finance',	'ZI2_04Finance_Ui_Admin_Conf_Finance@post' )
			;

		$this->screen
			->menu(	'admin/conf',	array( '../finance', '__Finance__') )
			->title(	'admin/conf/finance',	'__Finance__' )
			;
	}
}