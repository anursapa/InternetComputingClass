<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Ui_Admin_Conf_Purchases
{
	protected $_props = array(
		'purchases_numbers_auto',
		'purchases_numbers_auto_prefix',
		'purchases_numbers_auto_method',
	);

	private function _import(
		HC4_Settings_Interface $settings,

		HC4_Html_Input_Text $inputText,
		HC4_Html_Input_RadioSet $inputRadioSet,
		HC4_Html_Input_CheckboxDetails $inputCheckboxDetails
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
		$viewPurchaseNumberAuto = $this->renderPurchaseNumberAuto( $values );

		ob_start();
?>

<form method="post" action="HREFPOST:..">
	<div class="hc4-form-elements">

		<div class="hc4-form-element">
			<?php echo $this->inputCheckboxDetails->render( 'purchases_numbers_auto', 1, $values['purchases_numbers_auto'], '__Auto-Generate Purchase Numbers__', $viewPurchaseNumberAuto ); ?>
		</div>

	</div>

	<div class="hc4-form-buttons">
		<input type="submit" class="hc4-admin-btn-primary" value="__Save__">
	</div>
</form>

<?php 
		return ob_get_clean();
	}

	public function renderPurchaseNumberAuto( array $values )
	{
		$autoMethodOptions = array(
			'seq'		=> '__Sequential__',
			'random'	=>	'__Random__'
			);
		ob_start();
?>

	<div class="hc-grid hc-mxn2">
		<div class="hc-col hc-col-6 hc-px2">
			<div class="hc4-form-element">
				<label>
					__Prefix__
				<?php echo $this->inputText->render( 'purchases_numbers_auto_prefix', $values['purchases_numbers_auto_prefix'] ); ?>
				</label>
			</div>
		</div>

		<div class="hc-col hc-col-6 hc-px2">
			<div class="hc4-form-element">
				<label>
					__Auto-Generated Numbers__
				</label>
				<?php echo $this->inputRadioSet->renderInline( 'purchases_numbers_auto_method', $autoMethodOptions, $values['purchases_numbers_auto_method'] ); ?>
			</div>
		</div>
	</div>

<?php 
		return ob_get_clean();
	}
}