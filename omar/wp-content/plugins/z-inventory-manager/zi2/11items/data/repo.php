<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface ZI2_11Items_Data_Repo
{
	public function create( ZI2_11Items_Data_Model $model );
	public function update( ZI2_11Items_Data_Model $model );
	public function delete( ZI2_11Items_Data_Model $model );
	public function findById( $id );
	public function findAll();
}

class ZI2_11Items_Data_Repo_Builtin
	implements ZI2_11Items_Data_Repo
{
	protected $_loaded = NULL;

	public function __construct(
		ZI2_11Items_Data_Crud $crud,
		HC4_App_Events $events
	)
	{}

	protected function _toTable( ZI2_11Items_Data_Model $model )
	{
		$return = array(
			'title'				=> $model->title,
			'description'		=> $model->description,
			'status'				=> $model->status,
			'sku'					=> $model->sku,
			'default_cost'		=> $model->defaultCost,
			'default_price'	=> $model->defaultPrice,
			);
		return $return;
	}

	protected function _fromTable( array $array )
	{
		$return = new ZI2_11Items_Data_Model;

		$return->id = $array['id'];
		$return->title = $array['title'];
		$return->description = $array['description'];
		$return->status = $array['status'];
		$return->sku = $array['sku'];
		$return->defaultCost = $array['default_cost'];
		$return->defaultPrice = $array['default_price'];

		return $return;
	}

	public function create( ZI2_11Items_Data_Model $model )
	{
	// required
		if( ! strlen($model->title) ){
			$msg = '__Title__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}
		if( ! strlen($model->sku) ){
			$msg = '__SKU__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}

	// duplicated titles
		$q = new HC4_Crud_Q;
		$q->where( 'title', '=', $model->title );
		$q->limit( 1 );
		$already = $this->crud->read( $q );
		if( $already ){
			$msg = '__This value is already used__' . ': ' . strip_tags( $model->title );
			throw new HC4_App_Exception_DataError( $msg );
		}

	// duplicated sku
		$q = new HC4_Crud_Q;
		$q->where( 'sku', '=', $model->sku );
		$q->limit( 1 );
		$already = $this->crud->read( $q );
		if( $already ){
			$msg = '__This value is already used__' . ': ' . strip_tags( $model->sku );
			throw new HC4_App_Exception_DataError( $msg );
		}

		$values = $this->_toTable( $model );
		$id = $this->crud->create( $values );

		$model->id = $id;

		return $model;
	}

	public function update( ZI2_11Items_Data_Model $model )
	{
		$id = $model->id;
 
	// required
		if( ! strlen($model->title) ){
			$msg = '__Title__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}
		if( ! strlen($model->sku) ){
			$msg = '__SKU__' . ': ' . '__Required Field__';
			throw new HC4_App_Exception_DataError( $msg );
		}

	// duplicated titles
		$q = new HC4_Crud_Q;
		$q->where( 'title', '=', $model->title );
		$q->where( 'id', '<>', $id );
		$q->limit( 1 );
		$already = $this->crud->read( $q );
		if( $already ){
			$msg = '__This value is already used__' . ': ' . strip_tags( $model->title );
			throw new HC4_App_Exception_DataError( $msg );
		}
	// duplicated sku
		$q = new HC4_Crud_Q;
		$q->where( 'sku', '=', $model->sku );
		$q->where( 'id', '<>', $id );
		$q->limit( 1 );
		$already = $this->crud->read( $q );
		if( $already ){
			$msg = '__This value is already used__' . ': ' . strip_tags( $model->sku );
			throw new HC4_App_Exception_DataError( $msg );
		}

		$current = $this->findById( $id );

		$currentArray = $this->_toTable( $current );
		$array = $this->_toTable( $model );

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

	public function delete( ZI2_11Items_Data_Model $model )
	{
		if( ! $model->id ){
			return $model;
		}
		$this->crud->delete( $model->id );
		return $model;
	}

	public function findAll()
	{
		$this->_load();
		return $this->_loaded;
	}

	public function findById( $id )
	{
		$return = NULL;

		$all = $this->findAll();
		if( ! isset($all[$id]) ){
			return $return;
		}

		return $all[$id];
	}

	protected function _load()
	{
		if( NULL === $this->_loaded ){
			$this->_loaded = array();

			$q = new HC4_Crud_Q;
			$q->sort( 'title' );
			$results = $this->crud->read( $q );

			foreach( $results as $e ){
				$model = $this->_fromTable( $e );
				$this->_loaded[ $model->id ] = $model;
			}
		}
	}
}