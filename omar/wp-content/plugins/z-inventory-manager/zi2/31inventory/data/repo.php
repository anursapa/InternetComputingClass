<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface ZI2_31Inventory_Data_Repo_
{
	public function getQty( ZI2_11Items_Data_Model $item );
}

class ZI2_31Inventory_Data_Repo
	implements ZI2_31Inventory_Data_Repo_
{
	public function __construct(
		ZI2_21Purchases_Data_Repo $repoPurchases,
		ZI2_22Sales_Data_Repo $repoSales,

		HC4_Time_Interface $t
	)
	{}

	public function getQty( ZI2_11Items_Data_Model $item )
	{
		$return = 0;

	// FIND RECEIVED PURCHASES
		$purchases = $this->repoPurchases->findManyByItem( $item );
		foreach( $purchases as $purchase ){
			foreach( $purchase->receipts as $receipt ){
				foreach( $receipt->lines as $line ){
					if( $line->item->id != $item->id ){
						continue;
					}
					$return += $line->qty;
				}
			}
		}

	// FIND SHIPPED SALES
		$sales = $this->repoSales->findManyByItem( $item );
		foreach( $sales as $sale ){
			foreach( $sale->shipments as $shipment ){
				foreach( $shipment->lines as $line ){
					if( $line->item->id != $item->id ){
						continue;
					}
					$return -= $line->qty;
				}
			}
		}

		return $return;
	}
}