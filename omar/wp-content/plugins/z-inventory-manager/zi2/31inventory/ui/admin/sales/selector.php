<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_31Inventory_Ui_Admin_Sales_Selector
{
	private function _import(
		ZI2_11Items_Data_Repo $repoItems,
		ZI2_22Sales_Data_Repo $repoSales,
		ZI2_31Inventory_Ui_Admin_Selector $selector
	)
	{}

	public function get( $slug, $saleId )
	{
		$entries = $this->repoItems->findAll();

		$sale = $this->repoSales->findById( $saleId );
		if( $sale->lines ){
			$currentIds = array();
			foreach( $sale->lines as $line ){
				$currentIds[] = $line->item->id;
			}
			$entries = array_filter( $entries, function($e) use ($currentIds){
				return ( ! in_array($e->id, $currentIds) );
			});
		}

		$return = call_user_func( $this->selector, $entries );
		return $return;
	}
}