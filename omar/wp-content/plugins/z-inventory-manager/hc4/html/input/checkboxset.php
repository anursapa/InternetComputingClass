<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Input_CheckboxSet
{
	public function __construct(
		HC4_Html_Input_Helper $helper,
		HC4_Html_Input_Checkbox $inputCheckbox
	)
	{}

	public function renderInline( $name, array $options = array(), array $value = array() )
	{
		return $this->render( $name, $options, $value, TRUE );
	}

	public function render( $name, array $options = array(), array $value = array(), $inline = FALSE )
	{
		$value = $this->helper->getValue( $name, $value );

		$out = array();
		$out[] = '<div>';
		foreach( $options as $k => $label ){
			if( $inline ){
				$out[] = '<div class="hc-nowrap hc-inline-block hc-mr1">';
			}
			else {
				$out[] = '<div class="hc-nowrap hc-block hc-my1">';
			}

			$checked = in_array($k, $value) ? TRUE : FALSE;
			$out[] = $this->inputCheckbox->render( $name . '[]', $k, $checked, $label );

			$out[] = '</div>';
		}

		$out[] = '</div>';
		$out = join( '', $out );

		$out = $this->helper->afterRender( $name, $out );

		return $out;
	}
}