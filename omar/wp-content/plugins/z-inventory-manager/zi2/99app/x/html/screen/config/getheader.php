<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_99App_X_Html_Screen_Config_GetHeader
{
	private function _import(
		ZI2_99App_Ui_Promo $promo = NULL
	)
	{}

	public function __invoke( $eventName, $return, $slug )
	{
		if( $this->promo ){
			$thisReturn = call_user_func( $this->promo, $slug );
			if( strlen($thisReturn) ){
				$return = $thisReturn . $return;
			}
		}

		return $return;
	}
}