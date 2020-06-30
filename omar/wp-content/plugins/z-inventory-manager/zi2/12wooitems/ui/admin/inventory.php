<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_12WooItems_Ui_Admin_Inventory
{
	protected $_props = array(
		'use_woo_inventory',
	);

	private function _import(
		HC4_Settings_Interface $settings,
		HC4_Html_Input_RadioSet $inputRadioSet
		)
	{}

	public function post( $slug, array $post )
	{
		foreach( $this->_props as $pname ){
			$v = isset($post[$pname]) ? $post[$pname] : NULL;
			$this->settings->set( $pname, $v );
		}

		$return = array( $slug, '__Settings Saved__' );
		return $return;
	}

	public function get( $slug )
	{
		$values = array();
		foreach( $this->_props as $pname ){
			$values[$pname] = $this->settings->get( $pname );
		}

		$return = $this->render( $values );
		return $return;
	}

	public function render( array $values )
	{
		ob_start();
?>

<form method="post" action="HREFPOST:..">
	<div class="hc4-form-elements">

		<div class="hc4-form-element">
			<?php
			$options = array(
				'1'	=> '__WooCommerce__',
				'0'	=> '__Own__',
				);
			?>
			<label>
				__Inventory Source__
			</label>
			<?php echo $this->inputRadioSet->renderInline( 'use_woo_inventory', $options, $values['use_woo_inventory'] ); ?>
		</div>

	</div>

	<div class="hc4-form-buttons">
		<input type="submit" class="hc4-admin-btn-primary" value="__Save__">
	</div>
</form>

<?php 
		return ob_get_clean();
	}
}