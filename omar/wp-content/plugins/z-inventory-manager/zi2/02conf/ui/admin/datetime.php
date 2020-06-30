<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_02Conf_Ui_Admin_Datetime
{
	protected $_props = array(
		'datetime_date_format',
		'datetime_time_format',
		'datetime_week_starts'
	);

	private function _import(
		HC4_Settings_Interface $settings,

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

		$return = array( $slug, '__Settings Saved__' );
		return $return;
	}

	public function get( $slug )
	{
		$values = array();
		foreach( $this->_props as $pname ){
			$values[$pname] = $this->settings->get( $pname );
		}

		$return = $this->render( $slug, $values );
		return $return;
	}

	public function render( $slug, array $values )
	{
		ob_start();
?>

<form method="post" action="HREFPOST:<?php echo $slug; ?>">
	<div class="hc4-form-elements">

		<div class="hc4-form-element">
			<?php
			$options = array(
				'j M Y'	=> date('j M Y'),

				'n/j/Y'	=> date('n/j/Y'),
				'm/d/Y'	=> date('m/d/Y'),
				'm-d-Y'	=> date('m-d-Y'),
				'm.d.Y'	=> date('m.d.Y'),

				'j/n/Y'	=> date('j/n/Y'),
				'd/m/Y'	=> date('d/m/Y'),
				'd-m-Y'	=> date('d-m-Y'),
				'd.m.Y'	=> date('d.m.Y'),

				'Y/m/d'	=> date('Y/m/d'),
				'Y-m-d'	=> date('Y-m-d'),
				'Y.m.d'	=> date('Y.m.d'),

				);
			?>
			<label>
				__Date Format__
			</label>
			<?php echo $this->inputRadioSet->renderInline( 'datetime_date_format', $options, $values['datetime_date_format'] ); ?>
		</div>

		<div class="hc4-form-element">
			<?php
			$options = array(
				'g:ia'	=> date('g:ia'),
				'g:i A'	=> date('g:i A'),
				'H:i'	=> date('H:i'),
				);
			?>
			<label>
				__Time Format__
			</label>
			<?php echo $this->inputRadioSet->renderInline( 'datetime_time_format', $options, $values['datetime_time_format'] ); ?>
		</div>

		<?php
		$options = array(
			0	=> '__Sun__',
			1	=> '__Mon__',
			// 2	=> '__Tue__',
			// 3	=> '__Wed__',
			// 4	=> '__Thu__',
			// 5	=> '__Fri__',
			// 6	=> '__Sat__',
			);
		?>
		<div class="hc4-form-element">
			<label>
				__Week Starts On__
			</label>
			<?php echo $this->inputRadioSet->renderInline( 'datetime_week_starts', $options, $values['datetime_week_starts'] ); ?>
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