<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Ui_Status
{
	public function render( $status )
	{
		$labels = $this->getAllOptions();
		$return = isset( $labels[$status] ) ? $labels[$status] : $status;
		return $return;
	}

	public function getAllOptions()
	{
		$return = array(
			'draft'		=> '<div class="hc-inline-block hc-px1 hc-rounded hc-white hc-bg-gray">__Draft__</div>',
			'issued'		=> '<div class="hc-inline-block hc-px1 hc-rounded hc-white hc-bg-aqua">__Issued__</div>',
			'partially'	=> '<div class="hc-inline-block hc-px1 hc-rounded hc-white hc-bg-olive">__Partially Shipped__</div>',
			'shipped'	=> '<div class="hc-inline-block hc-px1 hc-rounded hc-white hc-bg-green">__Shipped__</div>',
			);
		return $return;
	}
}