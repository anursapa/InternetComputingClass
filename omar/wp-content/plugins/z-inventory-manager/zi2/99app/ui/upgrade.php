<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_99App_Ui_Upgrade
{
	private function _import(
		ZI2_99App_Data_Upgrade $upgrade
	)
	{}

	public function get( $slug )
	{
		$this->upgrade->run();
		$return = '';
		return $return;
	}
}