<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface ZI2_22Sales_Data_Repo_Shipments_Lines_
{
	public function findManyByShipments( array $shipments );
	public function findManyByItem( ZI2_11Items_Data_Model $item );
	public function create( ZI2_22Sales_Data_Model_Shipment $shipment, ZI2_22Sales_Data_Model_Shipment_Line $line );
	public function delete( ZI2_22Sales_Data_Model_Shipment_Line $model );
}

class ZI2_22Sales_Data_Repo_Shipments_Lines
	implements ZI2_22Sales_Data_Repo_Shipments_Lines_
{
	public function __construct(
		ZI2_11Items_Data_Repo $repoItems,
		ZI2_22Sales_Data_Crud_Shipments_Lines $crud
	)
	{}

	protected function _fromTable( array $array )
	{
		$return = NULL;

		$item = $this->repoItems->findById( $array['item_id'] );
		if( ! $item ){
			return $return;
		}

		$return = new ZI2_22Sales_Data_Model_Shipment_Line;

		$return->id = $array['id'];
		$return->qty = $array['qty'];
		$return->item = $item;

		return $return;
	}

	protected function _toTable( ZI2_22Sales_Data_Model_Shipment_Line $model )
	{
		$return = array();

		$return['qty'] = $model->qty;
		$return['item_id'] = $model->item->id;

		return $return;
	}

	public function findManyByShipments( array $shipments )
	{
		$return = array();

		reset( $shipments );
		foreach( $shipments as $e ){
			$return[ $e->id ] = array();
		}

		$q = new HC4_Crud_Q;
		$q->where( 'shipment_id', '=', array_keys($return) );
		$results = $this->crud->read( $q );

		foreach( $results as $e ){
			$model = $this->_fromTable( $e );
			if( ! $model ){
				continue;
			}
			$return[ $e['shipment_id'] ][ $model->id ] = $model;
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

	public function create( ZI2_22Sales_Data_Model_Shipment $shipment, ZI2_22Sales_Data_Model_Shipment_Line $model )
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
		if( ! strlen($shipment->id) ){
			$msg = '__Sale Shipment__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}

		$values = $this->_toTable( $model );
		$values['shipment_id'] = $shipment->id;

		$id = $this->crud->create( $values );
		$model->id = $id;

		return $model;
	}

	public function delete( ZI2_22Sales_Data_Model_Shipment_Line $model )
	{
		$this->crud->delete( $model->id );
		return $model;
	}
}