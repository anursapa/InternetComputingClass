<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_12WooItems_Boot
{
	public function _import(
		HC4_App_Factory $factory,
		HC4_Settings_Interface $settings,
		HC4_Html_Href_Interface $href,
		HC4_App_Router $router,
		HC4_Html_Screen_Config $screen
	)
	{}

	public function __invoke()
	{
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$ns = 'ZI2_12WooItems_';

		$this->settings
			->init( 'use_woo_inventory', 1 )
			;

		if( $this->settings->get('use_woo_inventory') ){
			$this->factory
				->bind( 'ZI2_11Items_Data_Repo', 'ZI2_12WooItems_Data_Repo' )
				;
			$this->href
				->alias( 'admin/inventory/new', admin_url('post-new.php?post_type=product') )
				;
		}

		$this->router
			->add( 'GET/admin/conf/inventory',	$ns . 'Ui_Admin_Inventory@get' )
			->add( 'POST/admin/conf/inventory',	$ns . 'Ui_Admin_Inventory@post' )
			;

		$this->screen
			->menu(	'admin/conf',	array( '../inventory', '__Inventory__') )
			->title(	'admin/conf/inventory',	'__Inventory__' )
			;
	}
}