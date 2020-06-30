<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Input_DaysOfWeek
{
	public function __construct(
		HC4_Html_Input_Helper $helper,
		HC4_Html_Input_Checkbox $inputCheckbox,
		HC4_Time_Interface $t
	)
	{}

	public function render( $name, array $value = array() )
	{
		$value = $this->helper->getValue( $name, $value );

		$out = array();
		$out[] = '<div>';

		$options = $this->t->getWeekdays();

		foreach( $options as $k => $label ){
			$out[] = '<div class="hc-nowrap hc-inline-block hc-px1 hc-align-center">';

			$out[] = '<label>';
			$checked = in_array($k, $value) ? TRUE : FALSE;
			$out[] = $this->inputCheckbox->render( $name . '[]', $k, $checked );

			$out[] = '<div>';
			$out[] = $label;
			$out[] = '</div>';

			$out[] = '</label>';

			$out[] = '</div>';
		}

		$out[] = '</div>';
		$out = join( '', $out );

		$out = $this->helper->afterRender( $name, $out );

		return $out;
	}
}