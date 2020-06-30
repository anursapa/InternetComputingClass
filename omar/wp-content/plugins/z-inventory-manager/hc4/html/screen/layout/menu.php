<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Screen_Layout_Menu
{
	public function __invoke( array $menu )
	{
		$menuHtmlId = HC4_App_Functions::generateRand( 4 );

		ob_start();
?>

<div class="hc4-submenu">

<!-- MOBILE -->
<div class="hc4-submenu-mobile hc-nowrap hc-lg-hide">
	<div class="hc-collapse-container hc-nowrap">
		<input type="checkbox" id="hc4-submenu-<?php echo $menuHtmlId; ?>" class="hc-collapse-toggler hc-hide">
		<label for="hc4-submenu-<?php echo $menuHtmlId; ?>" class="hc-collapse-burger hc-block hc-border hc-px1 hc-py2 hc-my1">
			<div class="hc-px2" title="__Menu__">&vellip; __Menu__</div>
		</label>

		<div class="hc-collapse-content">
			<div class="hc4-admin-list-secondary">
			<?php foreach( $menu as $menuItem ) : ?>
				<div>
					<?php echo $menuItem; ?>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<!-- END OF MOBILE -->

<!-- DESKTOP -->
<div class="hc4-submenu-desktop hc-xs-hide">
	<div class="hc-inline-flex">
		<?php $ii = 0; ?>
		<?php foreach( $menu as $menuItem ) : ?>
			<?php if( $ii ) : ?>
				<div class="hc-px1">&nbsp;</div>
			<?php endif; ?>
			<div>
				<?php echo $menuItem; ?>
			</div>
			<?php $ii++; ?>
		<?php endforeach; ?>
	</div>
</div>
<!-- END OF DESKTOP -->

</div>
<?php 
		$return = ob_get_clean();
		return $return;
	}
}