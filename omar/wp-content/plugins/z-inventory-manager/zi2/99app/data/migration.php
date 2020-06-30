<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_99App_Data_Migration
{
	public function __construct(
		ZI2_99App_Data_Upgrade $upgrade
	)
	{}

	public function version1()
	{
		$this->upgrade->run();
	}
}