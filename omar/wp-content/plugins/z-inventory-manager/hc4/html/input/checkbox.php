<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Input_Checkbox
{
	public function __construct(
		HC4_Html_Input_Helper $helper
	)
	{}

	public function render( $name, $k, $checked = FALSE, $label = NULL )
	{
		$checked = $this->helper->getValue( $name, $checked );

		$out = array();
		if( NULL !== $label ){
			$out[] = '<label class="hc-block hc-xs-py1 hc-magictoggle-container">';
		}

		if( NULL !== $label ){
			$out[] = '<span class="hc-inline-flex">';
		}

		$out[] = '<input type="checkbox" class="hc4-input-checkbox hc-magictoggle-toggler" name="' . $name . '" value="' . $k . '"';
		if( $checked ){
			$out[] = ' checked="checked"';
		}
		$out[] = '>';

		if( NULL !== $label ){
			if( ! is_array($label) ){
				$labelOn = '<span class="">' . $label . '</span>';
				$labelOff = '<span class="hc-muted2">' . $label . '</span>';
				$label = array( $labelOn, $labelOff );
			}

			if( is_array($label) ){
				$labelView = '<span class="hc-magictoggle-on">' . $label[0] . '</span><span class="hc-magictoggle-off">' . $label[1] . '</span>';
			}
			else {
				$labelView = $label;
			}
			// $out[] = $label;
			$out[] = $labelView;
			$out[] = '</span>';
		}

		if( NULL !== $label ){
			$out[] = '</label>';
		}

		$out = join( '', $out );
		$out = $this->helper->afterRender( $name, $out );

		return $out;
	}
}