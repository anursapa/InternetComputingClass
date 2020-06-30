<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Ui_Admin_Id_Receipts_Id
{
	private function _import(
		ZI2_21Purchases_Data_Repo $repo,

		HC4_Html_Input_Text $inputText,
		HC4_Html_Input_Textarea $inputTextarea,
		HC4_Html_Input_Date $inputDate,

		ZI2_11Items_Ui_Title $viewItem,

		HC4_Time_Format $tf
	)
	{}

	public function get( $slug, $purchaseId, $id )
	{
		$purchase = $this->repo->findById( $purchaseId );
		if( ! isset($purchase->receipts[$id]) ){
			return;
		}
		$model = $purchase->receipts[$id];

		$return = $this->render( $model );
		return $return;
	}

	public function postDelete( $slug, $post, $purchaseId, $id )
	{
		$purchase = $this->repo->findById( $purchaseId );
		if( ! isset($purchase->receipts[$id]) ){
			return;
		}
		$model = $purchase->receipts[$id];

	// DO
		try {
			$this->repo->deleteReceipt( $purchase, $model );
		}
		catch( HC4_App_Exception_DataError $e ){
			$to = '-referrer-';
			$return = array( $to, NULL, $e->getMessage() );
			return $return;
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -2) );
		$return = array( $to, '__Purchase Updated__' );

		return $return;
	}

	public function post( $slug, $post, $purchaseId, $id )
	{
		$purchase = $this->repo->findById( $purchaseId );
		if( ! isset($purchase->receipts[$id]) ){
			return;
		}
		$model = $purchase->receipts[$id];

		$createdDate = $this->inputDate->grab( 'created_date', $post );
		$description = $post['description'];
		$refno = $post['refno'];

	// DO
		try {
			$model = clone $model;
			$model->createdDate = $createdDate;
			$model->description = $description;
			$model->refno = $refno;

			$model = $this->repo->updateReceipt( $purchase, $model );
		}
		catch( HC4_App_Exception_DataError $e ){
			$to = '-referrer-';
			$return = array( $to, NULL, $e->getMessage() );
			return $return;
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -1) );
		$return = array( $to, '__Purchase Updated__' );

		return $return;
	}

	public function render( ZI2_21Purchases_Data_Model_Receipt $model )
	{
		ob_start();
?>
<form method="post" action="HREFPOST:..">

	<div class="hc4-form-elements">

		<div class="hc-grid hc-mxn2">
			<div class="hc-col hc-col-6 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Purchase Receipt Number__
						<?php echo $this->inputText->render( 'refno', $model->refno ); ?>
					</label>
				</div>
			</div>

			<div class="hc-col hc-col-6 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Date__
					</label>
					<?php echo $this->inputDate->render( 'created_date', $model->createdDate ); ?>
				</div>
			</div>
		</div>

		<div class="hc4-form-element">
			<label>
				__Comments__
				<?php echo $this->inputTextarea->render( 'description', $model->description, 2 ); ?>
			</label>
		</div>

		<div class="hc4-form-element">
			<label>
				__Items__
			</label>
			<div class="hc-p2 hc-border hc-border-gray hc-rounded">
				<?php echo $this->renderLines( $model ); ?>
			</div>
		</div>

	</div>

	<div class="hc4-form-buttons">
		<button type="submit" class="hc4-admin-btn-primary">__Save__</button>
	</div>

</form>

<?php 
		return ob_get_clean();
	}

	public function renderLines( ZI2_21Purchases_Data_Model_Receipt $model )
	{
		ob_start();
?>
<div class="hc4-admin-list-secondary">

<?php if( $model->lines ) : ?>
	<div>
		<div class="hc-flex-auto-grid">
			<div>__Title__</div>
			<div>__Receiving Now__</div>
		</div>
	</div>
<?php endif; ?>

<?php foreach( $model->lines as $e ) : ?>
	<div>
		<div class="hc-flex-auto-grid">
			<div>
				<?php echo $this->viewItem->render( $e->item ); ?>
			</div>
			<div>
				<?php echo $e->qty; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<?php 
		return ob_get_clean();
	}
}