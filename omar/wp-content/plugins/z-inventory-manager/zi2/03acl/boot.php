<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_03Acl_Boot
{
	public function _import(
		ZI2_03Acl_Data_Repo $repoAcl,

		HC4_Migration_Interface $migration,
		HC4_Settings_Interface $settings,
		HC4_App_Router $router,
		HC4_Html_Screen_Config $screen
	)
	{}

	public function __invoke()
	{
	// DEFAULTS
		$this->settings
			;

		$this->router
			->add( 'GET/notallowed',	'ZI2_03Acl_Ui_NotAllowed@get' )
			;

		$this->screen
			->title( 'notallowed',	'__Not Allowed__' )
			;

	// GENERAL
		$this->router
			->add( 'CHECK:GET/admin',		'ZI2_03Acl_Ui_Check@checkAdmin' )
  			->add( 'CHECK:GET/admin*',		'ZI2_03Acl_Ui_Check@checkAdmin' )
			->add( 'CHECK:POST/admin',		'ZI2_03Acl_Ui_Check@checkAdmin' )
			->add( 'CHECK:POST/admin*',	'ZI2_03Acl_Ui_Check@checkAdmin' )
			->add( 'CHECK:GET/widget/admin',		'ZI2_03Acl_Ui_Check@checkAdmin' )
  			->add( 'CHECK:GET/widget/admin*',		'ZI2_03Acl_Ui_Check@checkAdmin' )
			->add( 'CHECK:POST/widget/admin',		'ZI2_03Acl_Ui_Check@checkAdmin' )
			->add( 'CHECK:POST/widget/admin*',	'ZI2_03Acl_Ui_Check@checkAdmin' )
			;

		$this->router
			->add( 'GET/admin/conf/acl',		'ZI2_03Acl_Ui_Admin_Settings@get' )
			->add( 'POST/admin/conf/acl',		'ZI2_03Acl_Ui_Admin_Settings@post' )
			;

		$this->screen
			->title(	'admin/conf/acl',		'__Access Permissions__' )
			->menu(	'admin/conf',			array('admin/conf/acl',	'__Access Permissions__') )
			;

	// INIT SETTINGS SET ALL CUSTOMERS BY DEFAULT
		global $wp_roles;
		if( ! isset($wp_roles) ){
			$wp_roles = new WP_Roles();
		}
		$wpRoles = array();
		$names = $wp_roles->get_names();
		foreach( $names as $k => $v ){
			$k = str_replace(' ', '_', $k);
			$wpRoles[$k] = $v;
		}

		$defaultAdmins = $this->repoAcl->getDefaultAdminRoles();
		foreach( array_keys($wpRoles) as $wpRoleName ){
			$pName = 'users_wp_' . $wpRoleName . '_' . 'admin';
			$pValue = in_array($wpRoleName, $defaultAdmins) ? 1 : 0;
			$this->settings->init( $pName, $pValue );
		}
	}
}