<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface ZI2_21Purchases_Data_Repo_Lines_
{
	public function findManyByPurchases( array $purchases );
	public function findManyByItem( ZI2_11Items_Data_Model $item );
	public function delete( ZI2_21Purchases_Data_Model_Line $model );
	public function create( ZI2_21Purchases_Data_Model $purchase, ZI2_21Purchases_Data_Model_Line $model );
	public function update( ZI2_21Purchases_Data_Model_Line $model );
}

class ZI2_21Purchases_Data_Repo_Lines
	implements ZI2_21Purchases_Data_Repo_Lines_
{
	public function __construct(
		ZI2_11Items_Data_Repo $repoItems,
		ZI2_21Purchases_Data_Crud_Lines $crud
	)
	{}

	protected function _fromTable( array $array )
	{
		$return = NULL;

		$item = $this->repoItems->findById( $array['item_id'] );
		if( ! $item ){
			return $return;
		}

		$return = new ZI2_21Purchases_Data_Model_Line;
		$return->id = $array['id'];
		$return->qty = $array['qty'];
		$return->price = $array['price'];
		$return->item = $item;

		return $return;
	}

	protected function _toTable( ZI2_21Purchases_Data_Model_Line $model )
	{
		$return = array();

		$return['qty'] = $model->qty;
		$return['price'] = $model->price;
		$return['item_id'] = $model->item->id;

		return $return;
	}

	public function findManyByPurchases( array $purchases )
	{
		$return = array();

		reset( $purchases );
		foreach( $purchases as $e ){
			$return[ $e->id ] = array();
		}

		$q = new HC4_Crud_Q;
		$q->where( 'purchase_id', '=', array_keys($return) );
		$results = $this->crud->read( $q );

		foreach( $results as $e ){
			$model = $this->_fromTable( $e );
			if( ! $model ){
				continue;
			}

			$return[ $e['purchase_id'] ][ $model->id ] = $model;
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

	public function delete( ZI2_21Purchases_Data_Model_Line $model )
	{
		$this->crud->delete( $model->id );
		return $model;
	}

	public function create( ZI2_21Purchases_Data_Model $purchase, ZI2_21Purchases_Data_Model_Line $model )
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
		if( ! strlen($purchase->id) ){
			$msg = '__Purchase__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}

		$values = $this->_toTable( $model );
		$values['purchase_id'] = $purchase->id;

		$id = $this->crud->create( $values );
		$model->id = $id;

		return $model;
	}

	public function update( ZI2_21Purchases_Data_Model_Line $model )
	{
		$id = $model->id;

	// required
		if( ! strlen($model->qty) ){
			$msg = '__Quantity__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}
		if( ! $model->item ){
			$msg = '__Item__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}

		$array = $this->_toTable( $model );

		// $current = $this->findById( $id );
		// $currentArray = $this->_toTable( $current );

		$changes = array();
		// $keys = array_keys( $array );
		// foreach( $keys as $k ){
			// if( ! array_key_exists($k, $currentArray) ){
				// unset( $array[$k] );
				// continue;
			// }

			// $v = $array[$k];
			// if( $v == $currentArray[$k] ){
				// unset( $array[$k] );
				// continue;
			// }

			// $changes[ $k ] = array( $currentArray[$k], $v );
		// }

// _print_r( $changes );
// exit;

		if( $array ){
			$this->crud->update( $id, $array );
		}

		return $model;
	}
}