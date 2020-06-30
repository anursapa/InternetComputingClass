<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_11Items_Ui_Title
{
	public function render( ZI2_11Items_Data_Model $model )
	{
		$return = $model->title;
		return $return;
	}
}