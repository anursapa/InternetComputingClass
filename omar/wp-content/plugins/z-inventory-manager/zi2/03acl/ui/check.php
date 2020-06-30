<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_03Acl_Ui_Check
{
	public function __construct(
		ZI2_01Users_Data_Repo $repoUsers,
		ZI2_03Acl_Data_Repo $repoAcl,
		HC4_Auth_Interface $auth
	)
	{}

	public function checkAdmin( $slug )
	{
		$return = FALSE;

		$currentUserId = $this->auth->getCurrentUserId();
		if( ! $currentUserId ){
			return $return;
		}

		$user = $this->repoUsers->findById( $currentUserId );
		if( ! $user ){
			return $return;
		}

		if( ! $this->repoAcl->isAdmin($user) ){
			return $return;
		}

		$return = TRUE;
		return $return;
	}
}