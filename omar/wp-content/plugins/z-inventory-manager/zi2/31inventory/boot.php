<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_31Inventory_Boot
{
	public function _import(
		HC4_App_Router $router,
		HC4_Html_Screen_Config $screen
	)
	{}

	public function __invoke()
	{
		$ns = 'ZI2_31Inventory_';

	// UI
		$this->router
			->add( 'GET/admin/inventory',					$ns . 'Ui_Admin_Index@get' )
			->add( 'GET/admin/inventory/status/[:s]',	$ns . 'Ui_Admin_Index@get' )

			->add( 'GET/admin/inventory/new',	$ns . 'Ui_Admin_New@get' )
			->add( 'POST/admin/inventory/new',	$ns . 'Ui_Admin_New@post' )

			->add( 'GET/admin/inventory/[:id]',		$ns . 'Ui_Admin_Id@get' )
			->add( 'POST/admin/inventory/[:id]',	$ns . 'Ui_Admin_Id@post' )
			;

		$this->screen
			->title(	'admin/inventory',					'__Inventory__' )

			->title(	'admin/inventory/new',		'__New Item__' )
			->title( 'admin/inventory/[:id]',	$ns . 'Ui_Admin_Id@title' )

			->menu(	'',						array('admin/inventory', '__Inventory__', 50) )
			->menu(	'admin/inventory',	array('../new', '+ __New Item__') )
			;

	// DELETE
		$this->router
			->add( 'GET/admin/inventory/[:id]/delete',	$ns . 'Ui_Admin_Id_Delete@get' )
			->add( 'POST/admin/inventory/[:id]/delete',	$ns . 'Ui_Admin_Id_Delete@post' )
			;
		$this->screen
			->menu( 'admin/inventory/[:id]',		array( '../delete', '&times; ' . '__Delete__', 900 ) )
			->title( 'admin/inventory/[:id]/delete',	'__Delete__' )
			;

	// PURCHASES ITEM SELECTOR
		$this->router
			->add( 'GET/admin/purchases/[:id]/items/new',	'ZI2_31Inventory_Ui_Admin_Purchases_Selector@get' )
			;

	// SALES ITEM SELECTOR
		$this->router
			->add( 'GET/admin/sales/[:id]/items/new',			'ZI2_31Inventory_Ui_Admin_Sales_Selector@get' )
			;
	}
}