<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_31Inventory_Ui_Admin_Purchases_Selector
{
	private function _import(
		ZI2_11Items_Data_Repo $repoItems,
		ZI2_21Purchases_Data_Repo $repoPurchases,
		ZI2_31Inventory_Ui_Admin_Selector $selector
	)
	{}

	public function get( $slug, $purchaseId )
	{
		$entries = $this->repoItems->findAll();

		$purchase = $this->repoPurchases->findById( $purchaseId );
		if( $purchase->lines ){
			$currentIds = array();
			foreach( $purchase->lines as $line ){
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