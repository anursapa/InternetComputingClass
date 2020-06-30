<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Ui_Admin_Id_Items_New
{
	private function _import(
		ZI2_11Items_Data_Repo $repoItems,
		ZI2_21Purchases_Data_Repo $repoPurchases
	)
	{}

	public function post( $slug, array $post, $id )
	{
		$errors = array();
		if( ! (isset($post['item']) && $post['item']) ){
			$errors['item'] = '__Required Field__';
		}
		if( $errors ){
			throw new HC4_App_Exception_FormErrors( $errors );
		}

	// DO
		try {
			$purchase = $this->repoPurchases->findById( $id );
			$lines = $purchase->lines;

			foreach( $post['item'] as $itemId ){
				$item = $this->repoItems->findById( $itemId );

				$line = new ZI2_21Purchases_Data_Model_Line;
				// $line->qty = $post['qty'];
				// $line->price = $post['price'];
				$line->qty = 1;
				$line->price = $item->defaultCost;
				$line->item = $item;

				$lines[] = $line;
			}

			$purchase = clone $purchase;
			$purchase->lines = $lines;

			$purchase = $this->repoPurchases->update( $purchase );
		}
		catch( HC4_App_Exception_DataError $e ){
			$to = '-referrer-';
			$return = array( $to, NULL, $e->getMessage() );
			return $return;
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -1) );

		$return = array( $to, '__Purchase Saved__' );
		return $return;
	}
}