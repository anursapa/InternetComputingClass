<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Input_Radio
{
	public function __construct(
		HC4_Html_Input_Helper $helper
	)
	{}

	public function render( $name, $value, $checked = FALSE, $label = NULL, $moreClass = '' )
	{
		// $checked = $this->helper->getValue( $name, $checked );

		$out = array();

		$out[] = '<label class="hc-block hc-xs-py1">';

		if( NULL !== $label ){
			$out[] = '<span class="hc-inline-flex">';
		}

		$class = 'hc4-input-radio';
		if( $moreClass ){
			$class .= ' ' . $moreClass;
		}

		$out[] = '<input type="radio" class="' . $class . '" name="' . $name . '" value="' . $value . '"';
		if( $checked ){
			$out[] = ' checked="checked"';
		}
		$out[] = '>';

		if( NULL !== $label ){
			$out[] = $label;
		}

		if( NULL !== $label ){
			$out[] = '</span>';
		}

		$out[] = '</label>';

		$out = join( '', $out );
		// $out = $this->helper->afterRender( $name, $out );

		return $out;
	}
}