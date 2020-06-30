<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Boot
{
	private function _import(
		HC4_Settings_Interface $settings,
		HC4_Migration_Interface $migration,
		HC4_App_Router $router,
		HC4_Html_Screen_Config $screen
	)
	{}

	public function __invoke()
	{
		$ns = 'ZI2_22Sales_';

		$this->migration
			->register( 'sales', 1, 'ZI2_22Sales_Data_Migration@version1' )
			;

	// CONF
		$this->settings
			->init( 'sales_numbers_auto', TRUE )
			->init( 'sales_numbers_auto_prefix', 'SO-' )
			->init( 'sales_numbers_auto_method', 'seq' )
			;

		$this->screen
			->menu(	'admin/conf',	array( '../sales', '__Sales__') )
			->title(	'admin/conf/sales',	'__Sales__' )
			;
		$this->router
			->add( 'GET/admin/conf/sales',	'ZI2_22Sales_Ui_Admin_Conf_Sales@get' )
			->add( 'POST/admin/conf/sales',	'ZI2_22Sales_Ui_Admin_Conf_Sales@post' )
			;

	// DELETE
		$this->router
			->add( 'GET/admin/sales/[:id]/delete',	$ns . 'Ui_Admin_Id_Delete@get' )
			->add( 'POST/admin/sales/[:id]/delete',	$ns . 'Ui_Admin_Id_Delete@post' )
			;
		$this->screen
			->menu(	'admin/sales/[:id]',		array('../delete', '&times; ' . '__Delete__', 900) )
			->title(	'admin/sales/[:id]/delete',	'__Delete__' )
			;

	// UI
		$this->router
			->add( 'GET/admin/sales',			'ZI2_22Sales_Ui_Admin_Index@get' )

			->add( 'GET/admin/sales/[:id]',	'ZI2_22Sales_Ui_Admin_Id@get' )
			->add( 'POST/admin/sales/[:id]',	'ZI2_22Sales_Ui_Admin_Id@post' )

			->add( 'GET/admin/sales/[:id]/shipments/new',	'ZI2_22Sales_Ui_Admin_Id_Shipments_New@get' )
			->add( 'POST/admin/sales/[:id]/shipments/new',	'ZI2_22Sales_Ui_Admin_Id_Shipments_New@post' )

			->add( 'GET/admin/sales/[:id]/shipments',	'ZI2_22Sales_Ui_Admin_Id_Shipments@get' )
			->add( 'GET/admin/sales/[:pid]/shipments/[:id]',	'ZI2_22Sales_Ui_Admin_Id_Shipments_Id@get' )
			->add( 'POST/admin/sales/[:pid]/shipments/[:id]',	'ZI2_22Sales_Ui_Admin_Id_Shipments_Id@post' )
			->add( 'POST/admin/sales/[:pid]/shipments/[:id]/delete',	'ZI2_22Sales_Ui_Admin_Id_Shipments_Id@postDelete' )
			;

		$this->screen
			->menu(	'',			array('admin/sales', '__Sales__') )

			->title(	'admin/sales',		'__Sales__' )

			->title( 'admin/sales/[:id]',	'ZI2_22Sales_Ui_Admin_Id@title' )
			->menu(	'admin/sales/[:id]',	'ZI2_22Sales_Ui_Admin_Id@menu' )

			->title( 'admin/sales/[:id]/shipments/new',	'__Ship Items__' )
			->title( 'admin/sales/[:id]/shipments',		'__Shipped Items__' )

			->title( 'admin/sales/[:pid]/shipments/[:id]',	'__Sale Shipment__' )
			->menu( 'admin/sales/:pid/shipments/:id',		array( 'POST/../delete', '__Delete__') )
			;

	// NEW
		$this->router
			->add( 'GET/admin/sales/new',		'ZI2_22Sales_Ui_Admin_New@get' )
			->add( 'POST/admin/sales/new',	'ZI2_22Sales_Ui_Admin_New@post' )
			;

		$this->screen
			->menu(	'admin/sales',		array('../new', '__New Sale__') )
			->title(	'admin/sales/new',	'__New Sale__' )
			;

	// ITEMS
		$this->router
			->add( 'GET/admin/sales/[:id]/items',	'ZI2_22Sales_Ui_Admin_Id_Items@get' )
			->add( 'POST/admin/sales/[:id]/items',	'ZI2_22Sales_Ui_Admin_Id_Items@post' )

			->add( 'POST/admin/sales/[:id]/items/new',	'ZI2_22Sales_Ui_Admin_Id_Items_New@post' )
			;

		$this->screen
			->title( 'admin/sales/[:id]/items',			'__Edit Items__' )
			->menu( 'admin/sales/:id/items',	array( '../new', '__Add Items__') )
			->title( 'admin/sales/:id/items/new',	'__Add Items__' )
			;
	}
}