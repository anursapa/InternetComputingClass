<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface ZI2_21Purchases_Data_Repo_
{
	public function getNewRefno();
	public function getNewReceiptRefno( ZI2_21Purchases_Data_Model $purchase );

	public function findAll();
	public function findById( $id );
	public function findManyByItem( ZI2_11Items_Data_Model $item );

	public function createReceipt( ZI2_21Purchases_Data_Model $purchase, ZI2_21Purchases_Data_Model_Receipt $receipt );
	public function deleteReceipt( ZI2_21Purchases_Data_Model $purchase, ZI2_21Purchases_Data_Model_Receipt $receipt );
	public function updateReceipt( ZI2_21Purchases_Data_Model $purchase, ZI2_21Purchases_Data_Model_Receipt $receipt );

	public function delete( ZI2_21Purchases_Data_Model $model );
	public function create( ZI2_21Purchases_Data_Model $model );
	public function update( ZI2_21Purchases_Data_Model $model );
}

class ZI2_21Purchases_Data_Repo
	implements ZI2_21Purchases_Data_Repo_
{
	protected $_loaded = array();

	public function __construct(
		ZI2_11Items_Data_Repo $repoItems,

		ZI2_21Purchases_Data_Crud $crud,
		ZI2_21Purchases_Data_Repo_Lines $repoLines,
		ZI2_21Purchases_Data_Repo_Receipts $repoReceipts,

		HC4_Settings_Interface $settings
	)
	{}

	protected function _generateSeqNo()
	{
		$method = $this->settings->get( 'purchases_numbers_auto_method' );
		$seq = ( 'seq' == $method ) ? TRUE : FALSE; 

		$return = 1;
		if( $seq ){
			$q = new HC4_Crud_Q;
			$q->sortDesc( 'id' );
			$q->limit( 1 );
			$rows = $this->crud->read( $q );
			if( $rows ){
				$latest = array_shift( $rows );
				$return = $latest['id'] + 1;
			}
		}
		else {
			$return = rand( 100000, 999999 );
		}

		$length = 6;
		$return = (string) $return;
		$return = str_pad( $return, $length, '0', STR_PAD_LEFT);
		return $return;
	}

	public function getNewRefno()
	{
		$return = NULL;

		$autoGen = $this->settings->get( 'purchases_numbers_auto' );
		if( $autoGen ){
			$prefix = $this->settings->get( 'purchases_numbers_auto_prefix' );

			$exists = TRUE;
			while( $exists ){
				$exists = FALSE;

				$return = $this->_generateSeqNo();
				if( strlen($prefix) ){
					$return = $prefix . $return;
				}

				$q = new HC4_Crud_Q;
				$q->where( 'refno', '=', $return );
				$q->limit( 1 );
				$exists = $this->crud->read( $q );
			} 
		}

		return $return;
	}

	public function getNewReceiptRefno( ZI2_21Purchases_Data_Model $purchase )
	{
		$return = $purchase->refno;
		$newId = count( $purchase->receipts ) + 1;
		$return = $return . '_' . $newId;
		return $return;
	}

	protected function _fromTable( array $array )
	{
		$return = new ZI2_21Purchases_Data_Model;

		$return->id = $array['id'];
		$return->refno = $array['refno'];
		$return->status = $array['status'];
		$return->createdDate = $array['created_date'];
		$return->description = $array['description'];

		return $return;
	}

	protected function _toTable( ZI2_21Purchases_Data_Model $model )
	{
		$return = array();

		$return['refno'] = $model->refno;
		$return['status'] = $model->status;
		$return['created_date'] = $model->createdDate;
		$return['description'] = $model->description;

		return $return;
	}

	protected function _populate( array $return )
	{
		$lines = $this->repoLines->findManyByPurchases( $return );
		foreach( $lines as $id => $thisLines ){
			$return[$id]->lines = $thisLines;
		}

		$receipts = $this->repoReceipts->findManyByPurchases( $return );
		foreach( $receipts as $id => $thisReceipts ){
			$return[$id]->receipts = $thisReceipts;
		}

		return $return;
	}

	public function findAll()
	{
		$return = array();

		$q = new HC4_Crud_Q;
		$q->sortDesc( 'created_date' );
		$q->sortDesc( 'id' );
		$results = $this->crud->read( $q );

		foreach( $results as $e ){
			$model = $this->_fromTable( $e );
			$return[ $model->id ] = $model;
		}

		$return = $this->_populate( $return );
		return $return;
	}

	public function findManyByItem( ZI2_11Items_Data_Model $item )
	{
		$return = array();

		$purchaseLines = array();

		$q = new HC4_Crud_Q;
		$q->sortDesc( 'created_date' );
		$results = $this->crud->read( $q );

		foreach( $results as $e ){
			$model = $this->_fromTable( $e );
			$return[$model->id] = $model;
		}

		$return = $this->_populate( $return );
		return $return;
	}

	public function findById( $id )
	{
		if( array_key_exists($id, $this->_loaded) ){
			return $this->_loaded[$id];
		}

		$return = NULL;

		$q = new HC4_Crud_Q;
		$q->where( 'id', '=', $id );
		$q->limit( 1 );
		$results = $this->crud->read( $q );

		if( $results ){
			$e = array_shift( $results );
			$model = $this->_fromTable( $e );

			$return = array( $id => $model );
			$return = $this->_populate( $return );

			$return = $return[ $id ];
		}

		$this->_loaded[$id] = $return;
		return $return;
	}

	public function createReceipt( ZI2_21Purchases_Data_Model $purchase, ZI2_21Purchases_Data_Model_Receipt $receipt )
	{
		return $this->repoReceipts->create( $purchase, $receipt );
	}

	public function deleteReceipt( ZI2_21Purchases_Data_Model $purchase, ZI2_21Purchases_Data_Model_Receipt $receipt )
	{
		return $this->repoReceipts->delete( $receipt );
	}

	public function updateReceipt( ZI2_21Purchases_Data_Model $purchase, ZI2_21Purchases_Data_Model_Receipt $receipt )
	{
		return $this->repoReceipts->update( $receipt );
	}

	public function create( ZI2_21Purchases_Data_Model $model )
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

		$id = $this->crud->create( $values );
		$model->id = $id;

		foreach( $model->lines as $line ){
			$this->repoLines->create( $model, $line );
		}

		return $model;
	}

	public function delete( ZI2_21Purchases_Data_Model $model )
	{
		$lines = $this->repoLines->findManyByPurchases( array($model->id => $model) );
		if( isset($lines[$model->id]) ){
			foreach( $lines[$model->id] as $line ){
				$this->repoLines->delete( $line );
			}
		}

		$receipts = $this->repoReceipts->findManyByPurchases( array($model->id => $model) );
		if( isset($receipts[$model->id]) ){
			foreach( $receipts[$model->id] as $receipt ){
				$this->repoReceipts->delete( $receipt );
			}
		}

		$this->crud->delete( $model->id );
		return $model;
	}

	public function update( ZI2_21Purchases_Data_Model $model )
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

		$current = $this->findById( $id );
		$currentArray = $this->_toTable( $current );

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

// _print_r( $changes );
// exit;

		if( $array ){
			$this->crud->update( $id, $array );
		}

	// UPDATE LINES
		$toCreate = array();
		$toUpdate = array();
		$toDelete = array();

		foreach( $model->lines as $line ){
			if( ! $line->id ){
				$toCreate[] = $line;
			}
			else {
				if( isset($current->lines[$line->id]) && ($line->qty > 0) ){
					$toUpdate[] = $line;
				}
				else {
					$toDelete[] = $line;
				}
			}
		}

		foreach( $toCreate as $line ){
			$this->repoLines->create( $model, $line );
		}
		foreach( $toDelete as $line ){
			$this->repoLines->delete( $line );
		}
		foreach( $toUpdate as $line ){
			$this->repoLines->update( $line );
		}

		return $model;
	}
}