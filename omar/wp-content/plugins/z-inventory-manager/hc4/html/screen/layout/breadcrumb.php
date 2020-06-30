<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Screen_Layout_Breadcrumb
{
	public function __invoke( array $breadcrumb )
	{
		if( ! $breadcrumb ){
			return;
		}

		ob_start();
?>

<!-- DESKTOP -->
<div class="hc4-breadcrumb-desktop hc-xs-hide hc-fs2">
	<div class="hc-inline-flex">

		<?php $ii = 0; ?>
		<?php foreach( $breadcrumb as $item ) : ?>
			<?php list( $to, $label ) = $item; ?>

			<?php if( $ii ) : ?>
			<div class="hc-px1">
				&raquo;
			</div>
			<?php endif; ?>

			<div>
				<?php if( FALSE === strpos($label, '<') ) : ?>
					<a href="HREFGET:<?php echo $to; ?>" title="<?php echo $label; ?>"><?php echo $label; ?></a>
				<?php else : ?>
					<?php echo $label; ?>
				<?php endif; ?>
			</div>

			<?php $ii++; ?>

		<?php endforeach; ?>
	</div>
</div>
<!-- END OF DESKTOP -->

<!-- MOBILE -->
<div class="hc4-breadcrumb-mobile hc-lg-hide hc-fs2">
	<?php
	$lastItem = $breadcrumb[ count($breadcrumb) - 1 ];
	list( $to, $label ) = $lastItem;
	?>

	<div class="hc-grid">
		<div class="hc-xs-col hc-xs-col-1 hc-valign-middle hc-align-center hc-py1">&laquo;</div>

		<div class="hc-xs-col hc-xs-col-11 hc-valign-middle">
			<?php if( FALSE === strpos($label, '<') ) : ?>
				<a href="HREFGET:<?php echo $to; ?>" title="<?php echo $label; ?>"><?php echo $label; ?></a>
			<?php else : ?>
				<?php echo $label; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- END OF MOBILE -->

<?php
		return ob_get_clean();
	}
}