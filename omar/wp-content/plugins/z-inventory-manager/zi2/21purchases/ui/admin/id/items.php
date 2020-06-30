<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Ui_Admin_Id_Items
{
	private function _import(
		ZI2_11Items_Data_Repo $repoItems,
		ZI2_21Purchases_Data_Repo $repo,

		ZI2_11Items_Ui_Title $viewItem,

		HC4_Html_Input_Text $inputText,
		HC4_Html_Input_Hidden $inputHidden,
		HC4_Time_Format $tf
	)
	{}

	public function get( $slug, $id )
	{
		$model = $this->repo->findById( $id );
		$return = $this->render( $model );
		return $return;
	}

	public function render( ZI2_21Purchases_Data_Model $model )
	{
		ob_start();
?>

<?php if( $model->lines ) : ?>

<form method="post" action="HREFPOST:..">

	<div class="hc4-admin-list-primary hc4-admin-list-striped">

		<div>
			<div class="hc-grid hc-mxn2">
				<div class="hc-col hc-col-6 hc-px2">
					__Title__
				</div>
				<div class="hc-col hc-col-2 hc-px2">
					__Quantity__
				</div>
				<div class="hc-col hc-col-4 hc-px2">
					__Price__
				</div>
			</div>
		</div>

		<?php foreach( $model->lines as $line ) : ?>
			<div>
				<div class="hc-grid hc-mxn2">
					<div class="hc-col hc-col-6 hc-px2">
						<?php echo $this->viewItem->render( $line->item ); ?>
						<?php echo $this->inputHidden->render( 'item_' . $line->id, $line->item->id ); ?>
					</div>
					<div class="hc-col hc-col-2 hc-px2">
						<?php echo $this->inputText->render( 'qty_' . $line->id, $line->qty ); ?>
					</div>
					<div class="hc-col hc-col-4 hc-px2">
						<?php echo $this->inputText->render( 'price_' . $line->id, $line->price ); ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="hc4-form-buttons">
		<button type="submit" class="hc4-admin-btn-primary">__Save__</button>
	</div>

</form>

<?php endif; ?>

<script>
(function(){
	var rootTarget = document.getElementsByClassName( 'hc4-page' )[0];

	var submenu = document.getElementsByClassName( 'hc4-submenu' )[0];
	var links = submenu.getElementsByTagName( 'a' );
	for( ii = 0; ii < links.length; ii++ ){
		hc4AjaxModalLink( links[ii], rootTarget );
	}
}());
</script>

<?php 
		return ob_get_clean();
	}

	public function post( $slug, $post, $id )
	{
		$lines = array();
		foreach( $post as $k => $v ){
			if( 'qty_' == substr($k, 0, strlen('qty_')) ){
				$lineId = substr($k, strlen('qty_'));
				$itemId = $post['item_' . $lineId];

				$item = $this->repoItems->findById( $itemId );

				$line = new ZI2_21Purchases_Data_Model_Line;
				$line->id = $lineId;
				$line->qty = $post[$k];
				$line->price = $post['price_' . $lineId];
				$line->item = $item;

				$lines[] = $line;
			}
		}

	// DO
		try {
			$purchase = $this->repo->findById( $id );

			$purchase = clone $purchase;
			$purchase->lines = $lines;

			$purchase = $this->repo->update( $purchase );
		}
		catch( HC4_App_Exception_DataError $e ){
			$to = '-referrer-';
			$return = array( $to, NULL, $e->getMessage() );
			return $return;
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -1) );

		$return = array( $to, '__Purchase Saved__' );
		return $return;
	}
}