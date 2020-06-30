<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface ZI2_22Sales_Data_Repo_Shipments_
{
	public function findManyBySales( array $sales );
	public function create( ZI2_22Sales_Data_Model $sale, ZI2_22Sales_Data_Model_Shipment $shipment );
	public function delete( ZI2_22Sales_Data_Model_Shipment $model );
	public function update( ZI2_22Sales_Data_Model_Shipment $model );
}

class ZI2_22Sales_Data_Repo_Shipments
	implements ZI2_22Sales_Data_Repo_Shipments_
{
	public function __construct(
		ZI2_22Sales_Data_Crud_Shipments $crud,
		ZI2_22Sales_Data_Repo_Shipments_Lines $repoLines
	)
	{}

	protected function _fromTable( array $array )
	{
		$return = new ZI2_22Sales_Data_Model_Shipment;

		$return->id = $array['id'];
		$return->refno = $array['refno'];
		$return->createdDate = $array['created_date'];
		$return->description = $array['description'];

		return $return;
	}

	protected function _toTable( ZI2_22Sales_Data_Model_Shipment $model )
	{
		$return = array();

		$return['refno'] = $model->refno;
		$return['created_date'] = $model->createdDate;
		$return['description'] = $model->description;

		return $return;
	}

	public function findManyBySales( array $sales )
	{
		$return = array();

		reset( $sales );
		foreach( $sales as $e ){
			$return[ $e->id ] = array();
		}

		$q = new HC4_Crud_Q;
		$q->where( 'sale_id', '=', array_keys($return) );
		$results = $this->crud->read( $q );

		$models = array();
		reset( $results );
		foreach( $results as $e ){
			$model = $this->_fromTable( $e );
			$models[ $model->id ] = $model;
		}

		$lines = $this->repoLines->findManyByShipments( $models );
		foreach( $lines as $id => $thisLines ){
			$models[$id]->lines = $thisLines;
		}

		reset( $results );
		foreach( $results as $e ){
			$return[ $e['sale_id'] ][ $e['id'] ] = $models[ $e['id'] ];
		}

		return $return;
	}

	public function create( ZI2_22Sales_Data_Model $sale, ZI2_22Sales_Data_Model_Shipment $model )
	{
	// required
		if( ! strlen($model->refno) ){
			$msg = '__Refno__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}
		if( ! strlen($model->createdDate) ){
			$msg = '__Date__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}
		if( ! strlen($sale->id) ){
			$msg = '__Sale__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}

	// duplicated
		$q = new HC4_Crud_Q;
		$q->where( 'refno', '=', $model->refno );
		$q->limit( 1 );
		$already = $this->crud->read( $q );
		if( $already ){
			$msg = '__This value is already used__' . ': ' . strip_tags( $model->refno );
			throw new HC4_App_Exception_DataError( $msg );
		}

		$values = $this->_toTable( $model );
		$values['sale_id'] = $sale->id;

		$id = $this->crud->create( $values );
		$model->id = $id;

		foreach( $model->lines as $line ){
			$this->repoLines->create( $model, $line );
		}

		return $model;
	}

	public function update( ZI2_22Sales_Data_Model_Shipment $model )
	{
		$id = $model->id;

	// required
		if( ! strlen($model->refno) ){
			$msg = '__Refno__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}
		if( ! strlen($model->createdDate) ){
			$msg = '__Date__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}

	// duplicated
		$q = new HC4_Crud_Q;
		$q->where( 'refno', '=', $model->refno );
		$q->where( 'id', '<>', $id);
		$q->limit( 1 );
		$already = $this->crud->read( $q );
		if( $already ){
			$msg = '__This value is already used__' . ': ' . strip_tags( $model->refno );
			throw new HC4_App_Exception_DataError( $msg );
		}

		$array = $this->_toTable( $model );

		$currentArray = array();
		$q = new HC4_Crud_Q;
		$q->where( 'id', '=', $id );
		$results = $this->crud->read( $q );
		if( $results ){
			$currentArray = array_shift( $results );
		}

		$changes = array();
		$keys = array_keys( $array );
		foreach( $keys as $k ){
			if( ! array_key_exists($k, $currentArray) ){
				unset( $array[$k] );
				continue;
			}

			$v = $array[$k];
			if( $v == $currentArray[$k] ){
				unset( $array[$k] );
				continue;
			}

			$changes[ $k ] = array( $currentArray[$k], $v );
		}

		if( $array ){
			$this->crud->update( $id, $array );
		}

		return $model;
	}

	public function delete( ZI2_22Sales_Data_Model_Shipment $model )
	{
		foreach( $model->lines as $line ){
			$this->repoLines->delete( $line );
		}

		$this->crud->delete( $model->id );
		return $model;
	}
}