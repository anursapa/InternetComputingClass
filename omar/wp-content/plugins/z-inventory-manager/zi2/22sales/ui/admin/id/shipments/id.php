<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Ui_Admin_Id_Shipments_Id
{
	private function _import(
		ZI2_22Sales_Data_Repo $repo,

		HC4_Html_Input_Text $inputText,
		HC4_Html_Input_Textarea $inputTextarea,
		HC4_Html_Input_Date $inputDate,

		ZI2_11Items_Ui_Title $viewItem,

		HC4_Time_Format $tf
	)
	{}

	public function get( $slug, $saleId, $id )
	{
		$sale = $this->repo->findById( $saleId );
		if( ! isset($sale->shipments[$id]) ){
			return;
		}
		$model = $sale->shipments[$id];

		$return = $this->render( $model );
		return $return;
	}

	public function postDelete( $slug, $post, $saleId, $id )
	{
		$sale = $this->repo->findById( $saleId );
		if( ! isset($sale->shipments[$id]) ){
			return;
		}
		$model = $sale->shipments[$id];

	// DO
		try {
			$this->repo->deleteShipment( $sale, $model );
		}
		catch( HC4_App_Exception_DataError $e ){
			$to = '-referrer-';
			$return = array( $to, NULL, $e->getMessage() );
			return $return;
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -2) );
		$return = array( $to, '__Sale Updated__' );

		return $return;
	}

	public function post( $slug, $post, $saleId, $id )
	{
		$sale = $this->repo->findById( $saleId );
		if( ! isset($sale->shipments[$id]) ){
			return;
		}
		$model = $sale->shipments[$id];

		$createdDate = $this->inputDate->grab( 'created_date', $post );
		$description = $post['description'];
		$refno = $post['refno'];

	// DO
		try {
			$model = clone $model;
			$model->createdDate = $createdDate;
			$model->description = $description;
			$model->refno = $refno;

			$model = $this->repo->updateShipment( $sale, $model );
		}
		catch( HC4_App_Exception_DataError $e ){
			$to = '-referrer-';
			$return = array( $to, NULL, $e->getMessage() );
			return $return;
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -1) );
		$return = array( $to, '__Sale Updated__' );

		return $return;
	}

	public function render( ZI2_22Sales_Data_Model_Shipment $model )
	{
		ob_start();
?>
<form method="post" action="HREFPOST:..">

	<div class="hc4-form-elements">

		<div class="hc-grid hc-mxn2">
			<div class="hc-col hc-col-6 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Sale Shipment Number__
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

	public function renderLines( ZI2_22Sales_Data_Model_Shipment $model )
	{
		ob_start();
?>
<div class="hc4-admin-list-secondary">

<?php if( $model->lines ) : ?>
	<div>
		<div class="hc-flex-auto-grid">
			<div>__Title__</div>
			<div>__Shipping Now__</div>
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