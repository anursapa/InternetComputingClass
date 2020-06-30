<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_11Items_Boot
{
	public static function bind()
	{
		$return = array();
		$return['ZI2_11Items_Data_Repo'] = 'ZI2_11Items_Data_Repo_Builtin';
		return $return;
	}

	public function _import(
		HC4_Migration_Interface $migration,
		HC4_App_Router $router,
		HC4_Html_Screen_Config $screen
	)
	{}

	public function __invoke()
	{
		$this->migration
			->register( 'items', 1, 'ZI2_11Items_Data_Migration@version1' )
			;
	}
}