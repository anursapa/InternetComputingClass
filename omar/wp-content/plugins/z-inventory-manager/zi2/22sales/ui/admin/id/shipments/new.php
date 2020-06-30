<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Ui_Admin_Id_Shipments_New
{
	private function _import(
		ZI2_22Sales_Data_Repo $repo,

		HC4_Html_Input_Text $inputText,
		HC4_Html_Input_Textarea $inputTextarea,
		HC4_Html_Input_Date $inputDate,

		ZI2_11Items_Ui_Title $viewItem,

		HC4_Finance_Calculator $calculator,
		HC4_Time_Format $tf
	)
	{}

	public function get( $slug, $id )
	{
		$model = $this->repo->findById( $id );
		$return = $this->render( $model );
		return $return;
	}

	public function post( $slug, $post, $id )
	{
		$sale = $this->repo->findById( $id );

		$createdDate = $this->inputDate->grab( 'created_date', $post );
		$description = $post['description'];
		$refno = $post['refno'];

		$shipmentLines = array();
		foreach( $sale->lines as $e ){
			$pname = 'ship_' . $e->item->id;
			if( isset($post[$pname]) && $post[$pname] ){
				$shipmentLine = new ZI2_22Sales_Data_Model_Shipment_Line;
				$shipmentLine->item = $e->item;
				$shipmentLine->qty = $post[$pname];
				$shipmentLines[] = $shipmentLine;
			}
		}

		if( $shipmentLines ){
			$shipment = new ZI2_22Sales_Data_Model_Shipment;
			$shipment->createdDate = $createdDate;
			$shipment->description = $description;
			$shipment->refno = $refno;
			$shipment->lines = $shipmentLines;

			$this->repo->createShipment( $sale, $shipment );
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -1) );
		$return = array( $to, '__Items Shipped__' );

		return $return;
	}

	public function render( ZI2_22Sales_Data_Model $model )
	{
		$refno = $this->repo->getNewShipmentRefno( $model );

		ob_start();
?>
<form method="post" action="HREFPOST:..">

	<div class="hc4-form-elements">

		<div class="hc-grid hc-mxn2">
			<div class="hc-col hc-col-6 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Sale Shipment Number__
						<?php echo $this->inputText->render( 'refno', $refno ); ?>
					</label>
				</div>
			</div>

			<div class="hc-col hc-col-6 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Date__
					</label>
					<?php echo $this->inputDate->render( 'created_date' ); ?>
				</div>
			</div>
		</div>

		<div class="hc4-form-element">
			<label>
				__Comments__
				<?php echo $this->inputTextarea->render( 'description', '', 2 ); ?>
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
		<button type="submit" class="hc4-admin-btn-primary">__Ship Items__</button>
	</div>

</form>

<?php 
		return ob_get_clean();
	}

	public function renderLines( ZI2_22Sales_Data_Model $sale )
	{
		$total = 0;
		$this->calculator->reset();

		$shipped = array();
		foreach( $sale->lines as $e ){
			$this->calculator->add( $e->qty * $e->price );
			$shipped[ $e->item->id ] = 0;
		}
		$total = $this->calculator->get();

		foreach( $sale->shipments as $shipment ){
			foreach( $shipment->lines as $e ){
				$shipped[ $e->item->id ] += $e->qty;
			}
		}

		ob_start();
?>
<div class="hc4-admin-list-secondary">

<?php if( $sale->lines ) : ?>
	<div>
		<div class="hc-flex-auto-grid">
			<div>__Title__</div>
			<div>__Ordered__</div>
			<div>__Already Shipped__</div>
			<div>__Shipping Now__</div>
		</div>
	</div>
<?php endif; ?>

<?php foreach( $sale->lines as $e ) : ?>
	<?php
	$toShip = $e->qty - $shipped[$e->item->id];
	if( $toShip <= 0 ){
		continue;
	}
	?>
	<div>
		<div class="hc-flex-auto-grid">
			<div>
				<?php echo $this->viewItem->render( $e->item ); ?>
			</div>
			<div>
				<?php echo $e->qty; ?>
			</div>
			<div>
				<?php echo $shipped[ $e->item->id ]; ?>
			</div>
			<div>
				<?php if( $toShip ) : ?>
					<?php echo $this->inputText->render( 'ship_' . $e->item->id, $toShip ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<?php 
		return ob_get_clean();
	}
}