<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_99App_Ui_Promo_Promo
	implements ZI2_99App_Ui_Promo
{
	public function __invoke( $slug )
	{
		if( 'front' == substr( $slug, 0, strlen('front') ) ){
			return;
		}

	// show on homepage only
		// if( $slug ){
			// return;
		// }
		if( 'admin' !== substr($slug, 0, strlen('admin')) ){
			return;
		}

		if( ! is_admin() ){
			return;
		}

		ob_start();
?>

<?php if( is_admin() ) : ?>
	<div class="update-nag hc-block hc-my3">
<?php else : ?>
	<div class="hc-border hc-border-olive hc-rounded hc-p3 hc-block">
<?php endif; ?>
<span class="dashicons dashicons-star-filled hc-olive"></span> <a target="_blank" href="https://www.z-inventory-manager.com/order/"><strong>Z Inventory Manager Pro</strong></a> with nice features like item stats and history, copying sales and purchases, and more!
</div>

<?php 
		return ob_get_clean();
	}
}