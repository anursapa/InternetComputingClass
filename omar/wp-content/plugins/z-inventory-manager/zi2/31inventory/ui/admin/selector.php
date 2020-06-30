<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_31Inventory_Ui_Admin_Selector
{
	private function _import(
		ZI2_31Inventory_Data_Repo $repoInventory,
		HC4_Html_Input_Checkbox $inputCheckbox
	)
	{}

	public function __invoke( array $entries )
	{
		if( ! $entries ){
		ob_start();
?>
__No more items__

<?php
		return ob_get_clean();
		}
		ob_start();
?>

<form method="post" action="HREFPOST:..">

<div class="hc4-admin-list-primary hc4-admin-list-striped">

	<div class="hc-xs-hide hc4-list-header">
		<div class="hc-grid hc-mxn2">
			<div class="hc-xs-col hc-col-1 hc-xs-col-2 hc-px2 hc-align-center">
			</div>

			<div class="hc-xs-col hc-col-11 hc-xs-col-10 hc-px2">
				<div class="hc-flex-auto-grid">
					<div>__Title__</div>
					<div>__SKU__</div>
					<div>__In Stock__</div>
				</div>
			</div>
		</div>
	</div>

<?php foreach( $entries as $e ) : ?>
	<?php
	$qty = $this->repoInventory->getQty( $e );
	?>

	<div>
		<label>
		<div class="hc-grid hc-mxn2">
			<div class="hc-xs-col hc-col-1 hc-xs-col-2 hc-px2 hc-align-center">
				<?php echo $this->inputCheckbox->render( 'item[]', $e->id ); ?>
			</div>

			<div class="hc-xs-col hc-col-11 hc-xs-col-10 hc-px2">

				<div class="hc-flex-auto-grid">
					<div>
							<?php echo $e->title; ?>
					</div>
					<div>
						<?php echo $e->sku; ?>
					</div>
					<div>
						<?php echo $qty; ?>
					</div>
				</div>

			</div>
		</div>
		</label>
	</div>
<?php endforeach; ?>
</div>

<div class="hc4-form-buttons">
	<button type="submit" class="hc4-admin-btn-primary">__Add Selected Items__</button>
</div>

</form>

<?php 
		return ob_get_clean();
	}
}