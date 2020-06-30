<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_31Inventory_Ui_Admin_Index
{
	private function _import(
		ZI2_11Items_Data_Repo $repoItems,
		ZI2_11Items_Ui_Status $viewStatus,

		ZI2_31Inventory_Data_Repo $repoInventory
	)
	{}

	public function titleStatus( $status )
	{
		$return = $this->viewStatus->render($status);
		return $return;
	}

	public function menu( $slug )
	{
		$return = array();

		$entries = $this->repo->findAll();

		$count = array(
			// 'active'	=> 0,
			'archived'	=> 0,
			);
		$statuses = array_keys( $count );

		reset( $entries );
		foreach( $entries as $e ){
			if( ! isset($e->status) ){
				continue;
			}
			if( ! isset($count[$e->status]) ){
				continue;
			}
			$count[$e['status']]++;
		}

		foreach( $count as $status => $statusCount ){
			if( ! $statusCount ){
				continue;
			}

			$label = array();
			$label[] = $this->viewStatus->render($status);
			$label[] = ' [' . $statusCount . ']';

			$return[] = array( '../status/' . $status, $label );
		}

		return $return;
	}

	public function get( $slug, $status = 'active' )
	{
		$entries = $this->repoItems->findAll();

		// $entries = array_filter( $entries, function($e) use ($status){
			// return ( $e->status == $status );
		// });

		$return = $this->render( $entries );
		return $return;
	}

	public function render( array $entries )
	{
		ob_start();
?>

<div class="hc4-admin-list-primary hc4-admin-list-striped">

<?php if( $entries ) : ?>
	<div class="hc-xs-hide hc4-table-header">
		<div class="hc-flex-auto-grid">
			<div>__Title__</div>
			<div>__SKU__</div>
			<div>__In Stock__</div>
		</div>
	</div>
<?php endif; ?>

<?php foreach( $entries as $e ) : ?>
	<?php
	$qty = $this->repoInventory->getQty( $e );
	?>

	<div>
		<div class="hc-flex-auto-grid">
			<div>
				<a class="hc4-admin-title-link hc-xs-block" href="HREFGET:../<?php echo $e->id; ?>"><?php echo $e->title; ?></a>
			</div>

			<div>
				<?php echo $e->sku; ?>
			</div>

			<div>
				<?php echo $qty; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>

</div>

<?php 
		return ob_get_clean();
	}
}