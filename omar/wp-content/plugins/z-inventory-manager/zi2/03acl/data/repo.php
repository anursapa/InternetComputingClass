<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface ZI2_03Acl_Data_Repo_
{
	public function isAdmin( ZI2_01Users_Data_Model $user );
	public function findAdmins();
	public function getDefaultAdminRoles();
	public function getAdminRoles();
	public function getAllRoles();
}

class ZI2_03Acl_Data_Repo
	implements ZI2_03Acl_Data_Repo_
{
	protected $_defaultAdminRoles = array( 'administrator', 'developer', 'zi2_admin' );

	public function __construct(
		HC4_Settings_Interface $settings,
		ZI2_01Users_Data_Repo $repoWpUsers
	)
	{}

	public function getAllRoles()
	{
		global $wp_roles;
		if( ! isset($wp_roles) ){
			$wp_roles = new WP_Roles();
		}

		$return = array();
		$names = $wp_roles->get_names();
		foreach( $names as $k => $v ){
			$k = str_replace(' ', '_', $k);
			$return[ $k ] = $v;
		}

		return $return;
	}

	public function getDefaultAdminRoles()
	{
		return $this->_defaultAdminRoles;
	}

	public function getAdminRoles()
	{
		$return = $this->getDefaultAdminRoles();

		global $wp_roles;
		if( ! isset($wp_roles) ){
			$wp_roles = new WP_Roles();
		}

		$wpRoles = array();
		$names = $wp_roles->get_names();
		foreach( $names as $k => $v ){
			$k = str_replace(' ', '_', $k);
			$wpRoles[ $k ] = $v;
		}

		foreach( array_keys($wpRoles) as $wpRoleName ){
			$pName = 'users_wp_' . $wpRoleName . '_' . 'admin';
			$value = $this->settings->get($pName);
			if( $value ){
				$return[] = $wpRoleName;
			}
		}

		return $return;
	}

	public function isAdmin( ZI2_01Users_Data_Model $user )
	{
		static $results = array();
		if( array_key_exists($user->id, $results) ){
			return $results[ $user->id ];
		}

		$return = FALSE;

		$adminWpRoles = $this->getAdminRoles();

		$userdata = $user->raw;
		$thisWpRoles = $userdata->roles;

		if( array_intersect($adminWpRoles, $thisWpRoles) ){
			$return = TRUE;
		}

		return $return;
	}

	public function findAdmins()
	{
		static $return = NULL;
		if( NULL !== $return ){
			return $return;
		}

		$return = array();

		$q = array();

		$adminWpRoles = $this->getAdminRoles();
		$q['role__in'] = $adminWpRoles;

		$q['orderby'] = 'name';
		$q['order'] = 'ASC';

		$wpUsersQuery = new WP_User_Query( $q );
		$wpUsers = $wpUsersQuery->get_results();

		$return = array();
		$count = count( $wpUsers );
		for( $ii = 0; $ii < $count; $ii++ ){
			$model = $this->repoWpUsers->fromWordPress( $wpUsers[$ii] );
			$return[ $model->id ] = $model;
		}

		return $return;
	}

	public function findCustomers()
	{
		$return = array();

		$q = array();

		$adminWpRoles = $this->getAdminRoles();
		$q['role__not_in'] = $adminWpRoles;

		$q['orderby'] = 'name';
		$q['order'] = 'ASC';

		$wpUsersQuery = new WP_User_Query( $q );
		$wpUsers = $wpUsersQuery->get_results();

		$return = array();
		$count = count( $wpUsers );
		for( $ii = 0; $ii < $count; $ii++ ){
			$model = $this->repoWpUsers->fromWordPress( $wpUsers[$ii] );
			$return[ $model->id ] = $model;
		}

		return $return;
	}
}