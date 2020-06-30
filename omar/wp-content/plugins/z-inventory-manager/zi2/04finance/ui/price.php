<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_04Finance_Ui_Price
{
	public function __construct(
		HC4_Settings_Interface $settings
		)
	{}

	public function renderNumber( $amount )
	{
		list( $decPoint, $thousandSep ) = $this->settings->get( 'finance_price_format_number' );

		$amount = floatval( $amount );
		$return = number_format( $amount, 2, $decPoint, $thousandSep );

		return $return;
	}

	public function render( $amount )
	{
		$beforeSign = $this->settings->get( 'finance_price_format_before' );
		$afterSign = $this->settings->get( 'finance_price_format_after' );

		$amount = $this->renderNumber( $amount );
		$return = $beforeSign . $amount . ' ' . $afterSign;

		return $return;
	}
}