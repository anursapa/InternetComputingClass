<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Input_WordPress_RichTextarea
	implements HC4_Html_Input_RichTextarea
{
	public function __construct(
		HC4_Html_Input_Helper $helper
	)
	{}

	public function render( $name, $value = NULL, $rows = 6 )
	{
		$value = $this->helper->getValue( $name, $value );

		$wpEditorSettings = array();
		$wpEditorSettings['textarea_name'] = $name;

		if( $rows ){
			$wpEditorSettings['textarea_rows'] = $rows;
		}

	// stupid wp, it outputs it right away
		ob_start();

		$editorId = $name;
		wp_editor(
			$value,
			$editorId,
			$wpEditorSettings
			);

		// _WP_Editors::enqueue_scripts();
		// _WP_Editors::editor_js();

		$out = ob_get_clean();

		$out = $this->helper->afterRender( $name, $out );

		return $out;
	}
}