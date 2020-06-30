<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface ZI2_21Purchases_Data_Repo_Receipts_Lines_
{
	public function findManyByReceipts( array $receipts );
	public function findManyByItem( ZI2_11Items_Data_Model $item );
	public function create( ZI2_21Purchases_Data_Model_Receipt $receipt, ZI2_21Purchases_Data_Model_Receipt_Line $line );
	public function delete( ZI2_21Purchases_Data_Model_Receipt_Line $model );
}

class ZI2_21Purchases_Data_Repo_Receipts_Lines
	implements ZI2_21Purchases_Data_Repo_Receipts_Lines_
{
	public function __construct(
		ZI2_11Items_Data_Repo $repoItems,
		ZI2_21Purchases_Data_Crud_Receipts_Lines $crud
	)
	{}

	protected function _fromTable( array $array )
	{
		$return = NULL;

		$item = $this->repoItems->findById( $array['item_id'] );
		if( ! $item ){
			return $return;
		}

		$return = new ZI2_21Purchases_Data_Model_Receipt_Line;

		$return->id = $array['id'];
		$return->qty = $array['qty'];
		$return->item = $this->repoItems->findById( $array['item_id'] );

		return $return;
	}

	protected function _toTable( ZI2_21Purchases_Data_Model_Receipt_Line $model )
	{
		$return = array();

		$return['qty'] = $model->qty;
		$return['item_id'] = $model->item->id;

		return $return;
	}

	public function findManyByReceipts( array $receipts )
	{
		$return = array();

		reset( $receipts );
		foreach( $receipts as $e ){
			$return[ $e->id ] = array();
		}

		$q = new HC4_Crud_Q;
		$q->where( 'receipt_id', '=', array_keys($return) );
		$results = $this->crud->read( $q );

		foreach( $results as $e ){
			$model = $this->_fromTable( $e );
			if( ! $model ){
				continue;
			}

			$return[ $e['receipt_id'] ][ $model->id ] = $model;
		}

		return $return;
	}

	public function findManyByItem( ZI2_11Items_Data_Model $item )
	{
		$return = array();

		$q = new HC4_Crud_Q;
		$q->where( 'item_id', '=', $item->id );
		$results = $this->crud->read( $q );

		foreach( $results as $e ){
			$model = $this->_fromTable( $e );
			if( ! $model ){
				continue;
			}

			$return[ $model->id ] = $model;
		}

		return $return;
	}

	public function create( ZI2_21Purchases_Data_Model_Receipt $receipt, ZI2_21Purchases_Data_Model_Receipt_Line $model )
	{
	// required
		if( ! strlen($model->qty) ){
			$msg = '__Quantity__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}
		if( ! $model->item ){
			$msg = '__Item__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}
		if( ! strlen($receipt->id) ){
			$msg = '__Purchase Receipt__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}

		$values = $this->_toTable( $model );
		$values['receipt_id'] = $receipt->id;

		$id = $this->crud->create( $values );
		$model->id = $id;

		return $model;
	}

	public function delete( ZI2_21Purchases_Data_Model_Receipt_Line $model )
	{
		$this->crud->delete( $model->id );
		return $model;
	}
}