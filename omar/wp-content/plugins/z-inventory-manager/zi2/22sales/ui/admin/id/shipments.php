<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Ui_Admin_Id_Shipments
{
	private function _import(
		ZI2_22Sales_Data_Repo $repo,
		ZI2_11Items_Ui_Title $viewItem,
		HC4_Time_Format $tf
	)
	{}

	public function get( $slug, $id )
	{
		$model = $this->repo->findById( $id );
		$return = $this->render( $model );
		return $return;
	}

	public function render( ZI2_22Sales_Data_Model $model )
	{
		$shipped = array();
		$toShip = array();

		foreach( $model->lines as $e ){
			$shipped[ $e->item->id ] = 0;
			$toShip[ $e->item->id ] = $e->qty;
		}

		foreach( $model->shipments as $r ){
			foreach( $r->lines as $e ){
				$shipped[ $e->item->id ] += $e->qty;
				$toShip[ $e->item->id ] -= $e->qty;
			}
		}

		ob_start();
?>

	<?php if( $model->lines ) : ?>
		<div>
			<div class="hc-flex-auto-grid">
				<div>__Title__</div>
				<div>__Ordered__</div>
				<div>__Shipped__</div>
				<div>__To Ship__</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="hc4-admin-list-primary hc4-admin-list-striped">
	<?php foreach( $model->lines as $e ) : ?>
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
					<?php echo $toShip[ $e->item->id ]; ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>

	<?php if( $model->shipments ) : ?>
		<h2>__Sale Shipments__</h2>
	<?php endif; ?>

	<?php foreach( $model->shipments as $e ) : ?>
		<div class="hc-mb3">
			<div class="hc-my1">
				<a class="hc4-admin-title-link" href="HREFGET:../<?php echo $e->id; ?>"><?php echo $e->refno; ?></a>
				<?php echo $this->tf->formatDateWithWeekDay( $e->createdDate ); ?>
			</div>

			<div class="hc4-admin-list-primary hc4-admin-list-striped">
				<?php foreach( $e->lines as $l ) : ?>
					<div class="hc-flex-auto-grid">
						<div>
							<?php echo $this->viewItem->render( $l->item ); ?>
						</div>
						<div>
							<?php echo $l->qty; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if( strlen($e->description) ) : ?>
				<div class="hc-fs2">
				<em><?php echo $e->description; ?></em>
				</div>
			<?php endif; ?>

		</div>
	<?php endforeach; ?>

<?php 
		return ob_get_clean();
	}
}