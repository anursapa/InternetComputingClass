<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_02Conf_Boot
{
	public function _import(
		HC4_Migration_Interface $migration,
		HC4_Settings_Interface $settings,
		HC4_App_Router $router,
		HC4_Html_Screen_Config $screen
	)
	{}

	public function __invoke()
	{
	// DATA
		$this->migration
			->register( 'conf', 1, 'ZI2_02Conf_Data_Migration@version1' )
			;

	// DEFAULTS
		$this->settings
			->init( 'datetime_date_format', 'j M Y' )
			->init( 'datetime_time_format', 'g:ia' )
			->init( 'datetime_week_starts', 0 )
			;

	// UI
		$this->router
			->add( 'GET/admin/conf',				'ZI2_02Conf_Ui_Admin_Index@get' )

			->add( 'GET/admin/conf/datetime',	'ZI2_02Conf_Ui_Admin_Datetime@get' )
			->add( 'POST/admin/conf/datetime',	'ZI2_02Conf_Ui_Admin_Datetime@post' )

			->add( 'GET/admin/conf/email',	'ZI2_02Conf_Ui_Admin_Email@get' )
			->add( 'POST/admin/conf/email',	'ZI2_02Conf_Ui_Admin_Email@post' )
			;

		$this->screen
			->menu(	'',				array( 'admin/conf', '__Settings__', 1000) )
			->menu(	'admin/conf',	array( '../datetime', '__Date and Time__') )
			->menu(	'admin/conf',	array( '../email', '__Email__') )

			->title(	'admin/conf',				'__Settings__' )
			->title(	'admin/conf/datetime',	'__Date and Time__' )
			->title(	'admin/conf/email',		'__Email__' )
			;

		$defaultEmail = 'info@' . $_SERVER['SERVER_NAME'];
		$this->settings
			->init( 'email_from', $defaultEmail )
			->init( 'email_fromname', 'Z Inventory Manager' )
			->init( 'email_html', 1 )
			;
	}
}