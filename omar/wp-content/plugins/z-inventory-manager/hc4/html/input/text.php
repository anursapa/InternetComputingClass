<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Input_Text
{
	public function __construct(
		HC4_Html_Input_Helper $helper
	)
	{}

	public function render( $name, $value = NULL, $size = NULL )
	{
		$value = $this->helper->getValue( $name, $value );
		$out = '<input type="text" name="' . $name . '" value="' . $value . '" class="hc4-form-input"';
		if( NULL !== $size ){
			$out .= ' size="' . $size . '" style="width: ' .  ($size + 1) . 'em;"';
		}
		$out .= '>';
		$out = $this->helper->afterRender( $name, $out );
		return $out;
	}
}