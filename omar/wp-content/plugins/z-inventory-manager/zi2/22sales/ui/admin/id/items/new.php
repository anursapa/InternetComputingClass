<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Ui_Admin_Id_Items_New
{
	public function __construct(
		ZI2_11Items_Data_Repo $repoItems,
		ZI2_22Sales_Data_Repo $repoSales
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
			$sale = $this->repoSales->findById( $id );
			$lines = $sale->lines;

			foreach( $post['item'] as $itemId ){
				$item = $this->repoItems->findById( $itemId );

				$line = new ZI2_22Sales_Data_Model_Line;
				// $line->qty = $post['qty'];
				// $line->price = $post['price'];
				$line->qty = 1;
				$line->price = $item->defaultPrice;
				$line->item = $item;

				$lines[] = $line;
			}

			$sale = clone $sale;
			$sale->lines = $lines;

			$sale = $this->repoSales->update( $sale );
		}
		catch( HC4_App_Exception_DataError $e ){
			$to = '-referrer-';
			$return = array( $to, NULL, $e->getMessage() );
			return $return;
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -1) );

		$return = array( $to, '__Sale Saved__' );
		return $return;
	}
}