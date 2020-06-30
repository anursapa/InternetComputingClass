<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_99App_Ui_Index
{
	private function _import(
		HC4_Auth_Interface $auth,
		ZI2_01Users_Data_Repo $repoUsers
	)
	{}

	public function get( $slug )
	{
		$return = '';
		return $return;
	}

	public function title( $slug )
	{
		$return = NULL;

		$currentUserId = $this->auth->getCurrentUserId();
		if( ! $currentUserId ){
			return;
		}

		$return = '__Menu__';
		return $return;
	}
}