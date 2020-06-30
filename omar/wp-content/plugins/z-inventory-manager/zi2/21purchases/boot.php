<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Boot
{
	private function _import(
		HC4_Settings_Interface $settings,
		HC4_Migration_Interface $migration,
		HC4_App_Router $router,
		HC4_App_Events $events,
		HC4_Html_Screen_Config $screen
	)
	{}

	public function __invoke()
	{
		$ns = 'ZI2_21Purchases_';

		$this->migration
			->register( 'purchases', 1, 'ZI2_21Purchases_Data_Migration@version1' )
			;

	// CONF
		$this->settings
			->init( 'purchases_numbers_auto', TRUE )
			->init( 'purchases_numbers_auto_prefix', 'PO-' )
			->init( 'purchases_numbers_auto_method', 'seq' )
			;

		$this->screen
			->menu(	'admin/conf',	array( '../purchases', '__Purchases__') )
			->title(	'admin/conf/purchases',	'__Purchases__' )
			;
		$this->router
			->add( 'GET/admin/conf/purchases',	'ZI2_21Purchases_Ui_Admin_Conf_Purchases@get' )
			->add( 'POST/admin/conf/purchases',	'ZI2_21Purchases_Ui_Admin_Conf_Purchases@post' )
			;

	// DELETE
		$this->router
			->add( 'GET/admin/purchases/[:id]/delete',	$ns . 'Ui_Admin_Id_Delete@get' )
			->add( 'POST/admin/purchases/[:id]/delete',	$ns . 'Ui_Admin_Id_Delete@post' )
			;
		$this->screen
			->menu(	'admin/purchases/[:id]',		array('../delete', '&times; ' . '__Delete__', 900) )
			->title(	'admin/purchases/[:id]/delete',	'__Delete__' )
			;

	// UI
		$this->router
			->add( 'GET/admin/purchases',			'ZI2_21Purchases_Ui_Admin_Index@get' )

			->add( 'GET/admin/purchases/[:id]',		'ZI2_21Purchases_Ui_Admin_Id@get' )
			->add( 'POST/admin/purchases/[:id]',	'ZI2_21Purchases_Ui_Admin_Id@post' )

			->add( 'GET/admin/purchases/[:id]/receipts/new',	'ZI2_21Purchases_Ui_Admin_Id_Receipts_New@get' )
			->add( 'POST/admin/purchases/[:id]/receipts/new',	'ZI2_21Purchases_Ui_Admin_Id_Receipts_New@post' )

			->add( 'GET/admin/purchases/[:id]/receipts',	'ZI2_21Purchases_Ui_Admin_Id_Receipts@get' )
			->add( 'GET/admin/purchases/[:pid]/receipts/[:id]',	'ZI2_21Purchases_Ui_Admin_Id_Receipts_Id@get' )
			->add( 'POST/admin/purchases/[:pid]/receipts/[:id]',	'ZI2_21Purchases_Ui_Admin_Id_Receipts_Id@post' )
			->add( 'POST/admin/purchases/[:pid]/receipts/[:id]/delete',	'ZI2_21Purchases_Ui_Admin_Id_Receipts_Id@postDelete' )
			;

		$this->screen
			->menu(	'',			array('admin/purchases', '__Purchases__') )

			->title(	'admin/purchases',		'__Purchases__' )

			->title( 'admin/purchases/[:id]',	'ZI2_21Purchases_Ui_Admin_Id@title' )
			->menu(	'admin/purchases/[:id]',	'ZI2_21Purchases_Ui_Admin_Id@menu' )

			->title( 'admin/purchases/[:id]/receipts/new',	'__Receive Items__' )
			->title( 'admin/purchases/[:id]/receipts',		'__Received Items__' )

			->title( 'admin/purchases/[:pid]/receipts/[:id]',	'__Purchase Receipt__' )
			->menu( 'admin/purchases/:pid/receipts/:id',		array( 'POST/../delete', '__Delete__') )
			;

	// NEW
		$this->router
			->add( 'GET/admin/purchases/new',	'ZI2_21Purchases_Ui_Admin_New@get' )
			->add( 'POST/admin/purchases/new',	'ZI2_21Purchases_Ui_Admin_New@post' )
			;
		$this->screen
			->menu(	'admin/purchases',		array('../new', '__New Purchase__') )
			->title(	'admin/purchases/new',	'__New Purchase__' )
			;

	// ITEMS
		$this->router
			->add( 'GET/admin/purchases/[:id]/items',	'ZI2_21Purchases_Ui_Admin_Id_Items@get' )
			->add( 'POST/admin/purchases/[:id]/items',	'ZI2_21Purchases_Ui_Admin_Id_Items@post' )

			->add( 'POST/admin/purchases/[:id]/items/new',	'ZI2_21Purchases_Ui_Admin_Id_Items_New@post' )
			;

		$this->screen
			// ->js( 'admin/purchases/[:id]/items',	'hc4/assets/ajax.js' )

			->title( 'admin/purchases/[:id]/items',			'__Edit Items__' )
			->menu( 'admin/purchases/:id/items',	array( '../new', '__Add Items__') )
			->title( 'admin/purchases/:id/items/new',	'__Add Items__' )
			;

	// LISTEN TO ITEM DELETE
		$this->events
			->listen( 'ZI2_11Items_Data_Repo@delete', $ns . 'Data_Listen@itemDeleted' )
			;
	}
}