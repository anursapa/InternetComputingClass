<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Ui_Admin_Index
{
	private function _import(
		ZI2_21Purchases_Data_Repo $repo,

		ZI2_04Finance_Ui_Price $viewPrice,
		ZI2_21Purchases_Ui_Status $viewStatus,

		HC4_Finance_Calculator $calculator,
		HC4_Time_Format $tf
	)
	{}

	public function get( $slug, $status = 'active' )
	{
		$entries = $this->repo->findAll();
		$return = $this->render( $slug, $entries );
		return $return;
	}

	public function render( $slug, array $entries )
	{
		ob_start();
?>

<div class="hc4-admin-list-primary hc4-admin-list-striped">

<?php if( $entries ) : ?>
	<div>
		<div class="hc-flex-auto-grid">
			<div>__Purchase Number__</div>
			<div>__Date__</div>
			<div>__Status__</div>
			<div>__Total__</div>
		</div>
	</div>
<?php endif; ?>

<?php foreach( $entries as $e ) : ?>
	<div>
		<div class="hc-flex-auto-grid">
			<div>
				<a class="hc4-admin-title-link hc-xs-block" href="HREFGET:<?php echo $slug; ?>/<?php echo $e->id; ?>"><?php echo $e->refno; ?></a>
			</div>
			<div>
				<?php echo $this->tf->formatDateWithWeekDay( $e->createdDate ); ?>
			</div>
			<div>
				<?php echo $this->viewStatus->render( $e->status ); ?>
			</div>
			<div>
				<?php
					$total = 0;
					$this->calculator->reset();
					foreach( $e->lines as $line ){
						$this->calculator->add( $line->qty * $line->price );
					}
					$total = $this->calculator->get();
				?>
				<?php echo $this->viewPrice->render( $total ); ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>

</div>

<?php 
		return ob_get_clean();
	}
}