<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_04Finance_Ui_Admin_Conf_Finance
{
	protected $_props = array(
		'finance_price_format_before',
		'finance_price_format_number',
		'finance_price_format_after'
	);

	private function _import(
		HC4_Settings_Interface $settings,

		HC4_Html_Input_Text $inputText,
		HC4_Html_Input_Textarea $inputTextarea,
		HC4_Html_Input_Select $inputSelect,
		HC4_Html_Input_RadioSet $inputRadioSet
		)
	{}

	public function post( $slug, array $post )
	{
		foreach( $this->_props as $pname ){
			$v = isset($post[$pname]) ? $post[$pname] : NULL;
			$this->settings->set( $pname, $v );
		}
		$return = array( '-referrer-', '__Settings Updated__' );
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
			<label>
				__Price Format__
			</label>

			<div class="hc-flex-grid">
				<div class="hc-px2">
					<?php echo $this->inputText->render( 'finance_price_format_before', $values['finance_price_format_before'] ); ?>
				</div>
				<div class="hc-px2">
					<?php
					$demoPrice = 54321;
					$formats = array( array('.', ','), array('.', ''), array(',', ' '), array('.', ''), array(',', ''), array(',', '.') );
					$numberOptions = array();
					foreach( $formats as $f ){
						$numberOptions[ json_encode($f) ] = number_format($demoPrice, 2, $f[0], $f[1]);
					}
					$default = json_encode( $values['finance_price_format_number'] );
					?>
					<?php echo $this->inputSelect->render( 'finance_price_format_number', $numberOptions, $default ); ?>
				</div>
				<div class="hc-px2">
					<?php echo $this->inputText->render( 'finance_price_format_after', $values['finance_price_format_after'] ); ?>
				</div>
			</div>

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