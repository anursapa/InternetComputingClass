<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_01Users_Boot
{
	public function _import(
		HC4_App_Router $router,
		HC4_Html_Screen_Config $screen
	)
	{}

	public function __invoke()
	{
		$this->screen
			->menu( 'admin/users',		array( admin_url('user-new.php'), '+ __Add New__') )
			;
	}
}