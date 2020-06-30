<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Ui_Admin_Id_Receipts_New
{
	private function _import(
		ZI2_21Purchases_Data_Repo $repo,

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
		$purchase = $this->repo->findById( $id );

		$createdDate = $this->inputDate->grab( 'created_date', $post );
		$description = $post['description'];
		$refno = $post['refno'];

		$receiptLines = array();
		foreach( $purchase->lines as $e ){
			$pname = 'receive_' . $e->item->id;
			if( isset($post[$pname]) && $post[$pname] ){
				$receiptLine = new ZI2_21Purchases_Data_Model_Receipt_Line;
				$receiptLine->item = $e->item;
				$receiptLine->qty = $post[$pname];
				$receiptLines[] = $receiptLine;
			}
		}

		if( $receiptLines ){
			$receipt = new ZI2_21Purchases_Data_Model_Receipt;
			$receipt->createdDate = $createdDate;
			$receipt->description = $description;
			$receipt->refno = $refno;
			$receipt->lines = $receiptLines;

			$this->repo->createReceipt( $purchase, $receipt );
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -1) );
		$return = array( $to, '__Items Received__' );

		return $return;
	}

	public function render( ZI2_21Purchases_Data_Model $purchase )
	{
		$refno = $this->repo->getNewReceiptRefno( $purchase );

		ob_start();
?>
<form method="post" action="HREFPOST:..">

	<div class="hc4-form-elements">

		<div class="hc-grid hc-mxn2">
			<div class="hc-col hc-col-6 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Purchase Receipt Number__
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
				<?php echo $this->renderLines( $purchase ); ?>
			</div>
		</div>

	</div>

	<div class="hc4-form-buttons">
		<button type="submit" class="hc4-admin-btn-primary">__Receive Items__</button>
	</div>

</form>

<?php 
		return ob_get_clean();
	}

	public function renderLines( ZI2_21Purchases_Data_Model $purchase )
	{
		$total = 0;
		$this->calculator->reset();

		$received = array();
		foreach( $purchase->lines as $e ){
			$this->calculator->add( $e->qty * $e->price );
			$received[ $e->item->id ] = 0;
		}
		$total = $this->calculator->get();

		foreach( $purchase->receipts as $receipt ){
			foreach( $receipt->lines as $e ){
				$received[ $e->item->id ] += $e->qty;
			}
		}

		ob_start();
?>
<div class="hc4-admin-list-secondary">

<?php if( $purchase->lines ) : ?>
	<div>
		<div class="hc-flex-auto-grid">
			<div>__Title__</div>
			<div>__Ordered__</div>
			<div>__Already Received__</div>
			<div>__Receiving Now__</div>
		</div>
	</div>
<?php endif; ?>

<?php foreach( $purchase->lines as $e ) : ?>
	<?php
	$toReceive = $e->qty - $received[$e->item->id];
	if( $toReceive <= 0 ){
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
				<?php echo $received[ $e->item->id ]; ?>
			</div>
			<div>
				<?php if( $toReceive ) : ?>
					<?php echo $this->inputText->render( 'receive_' . $e->item->id, $toReceive ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<?php 
		return ob_get_clean();
	}
}