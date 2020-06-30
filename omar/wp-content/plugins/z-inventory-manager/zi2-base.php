<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly

if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
	add_action( 'admin_notices',
		create_function( '',
			"echo '<div class=\"error\"><p>" .
			__('Z Inventory Manager requires PHP 5.3 to function properly. Please upgrade PHP or deactivate Z Inventory Manager.', 'z-inventory-manager') ."</p></div>';"
			)
	);
	return;
}

if( ! class_exists('ZInventoryManager2_Wordpress') ){

class ZInventoryManager2_Wordpress
{
	protected $pluginFile;

	protected $adminMenuLabel = 'Z Inventory Manager';
	protected $myPage = 'z-inventory-manager2';
	protected $myAdminPage = 'z-inventory-manager2';
	protected $myShortPage = 'zi2';

	public function __construct( $pluginFile )
	{
		$pluginDir = dirname( $pluginFile );

	// supplied config
		$configFile = $pluginDir . '/config.php';
		$config = file_exists($configFile) ? require($configFile) : array();

	// hc4 autoload
		$src = isset( $config['autoloader'] ) ? $config['autoloader'] : array();
		$autoloader = require( $pluginDir . '/autoloader.php' );
		spl_autoload_register( $autoloader($src) );

		$this->pluginFile = $pluginFile;
		$pluginDir = dirname( $pluginFile );

		add_action( 'init', array($this, '_init') );
		add_action( 'init', array($this, 'intercept') );
		add_action( 'init', array($this, 'addRoles') );
		add_action( 'admin_init', array($this, 'adminInit') );
		add_action( 'admin_menu', array($this, 'adminMenu') );

	// submenu
		add_action( 'admin_menu', array($this, 'adminSubmenu') );
		add_filter( 'parent_file', array($this, 'setCurrentAppMenu') );

		add_shortcode( 'zi2', array($this, 'shortcode') );

	// hc4 init
		$modulesConfig = $this->getModules();

		foreach( $config as $k => $v ){
			if( isset($modulesConfig[$k]) ){
				$modulesConfig[$k] = array_merge( $modulesConfig[$k], $v );
			}
		}

		$this->app = new HC4_App_Index( $modulesConfig );
	}

	public function getModules()
	{
		$return = require( dirname($this->pluginFile) . '/modules-zim.php' );
		return $return;
	}

	public function adminMenu()
	{
		$mainLabel = get_site_option( $this->myPage . '_menu_title' );
		if( ! strlen($mainLabel) ){
			$mainLabel = $this->adminMenuLabel;
		}

		$menuIcon = isset($this->menuIcon) ? $this->menuIcon : NULL;
		$menuIcon = 'dashicons-clipboard';
		$requireCap = 'read';
		$page = add_menu_page(
			$mainLabel,
			$mainLabel,
			$requireCap,
			$this->myAdminPage,
			array( $this, 'render' ),
			$menuIcon,
			30
			);
	}

	public function _init()
	{
		do_action( 'zi2_init' );
		$this->app->boot();
	}

	public function adminInit()
	{
		if( $this->isMeAdmin() ){
			$this->actionResult = $this->app->handleRequest();
		}
	}

	public function render()
	{
		echo $this->actionResult;
	}

	public function addRoles()
	{
		$myRoles = array(
			'zi2_admin' => array( 
				'label'			=> 'Z Inventory Manager Administrator',
				'capabilities'	=> array('manage_zi2'),
				'assign_to'		=> array('editor', 'administrator')
				),
			);

		foreach( $myRoles as $role => $roleArray ){
			$r = get_role( $role );
			if( $r ){
				continue;
			}

			add_role( $role, $roleArray['label'], array('read' => TRUE) );

			if( $roleArray['capabilities'] ){
				global $wp_roles;
				reset( $roleArray['capabilities'] );
				foreach( $roleArray['capabilities'] as $cap ){
					$wp_roles->add_cap( $role, $cap );
					reset( $roleArray['assign_to'] );
					foreach( $roleArray['assign_to'] as $alsoTo ){
						$wp_roles->add_cap( $alsoTo, $cap );
					}
				}
			}
		}
	}

	public function shortcode( $shortcodeAtts )
	{
		$route = 'front';
		$result = $this->app->handleRequest( $route );
		return $result;
	}

// intercepts if in the front page our slug is given then it's ours
	public function intercept()
	{
		if( ! $this->isIntercepted() ){
			return;
		}

		$result = $this->app->handleRequest();
		echo $result;
		exit;
	}

	public function adminSubmenu()
	{
		global $submenu;
		$menuSlug = $this->myAdminPage;

		$screen = $this->app->factory('HC4_Html_Screen_Config');
		$translate = $this->app->factory('HC4_Translate_Interface');

		$menuItems = $screen->getMenu( '' );
		$mySubmenuCount = 0;

		foreach( $menuItems as $item ){
			list( $slug, $label ) = $item;

			if( ! $this->app->check('get', $slug) ){
				continue;
			}

			$label = $translate->translate( $label );
			$to = get_admin_url() . 'admin.php?page=' . $menuSlug . '&hca=' . $slug;

			remove_submenu_page( $menuSlug, $to );

			$ret = add_submenu_page(
				$menuSlug,					// parent
				$label,						// page_title
				$label,						// menu_title
				'read',						// capability
				$menuSlug . '-' . $slug,	// menu_slug
				'__return_null'
				);

			if( ! array_key_exists($menuSlug, $submenu) ){
				continue;
			}

			$mySubmenu = $submenu[$menuSlug];
			$mySubmenuIds = array_keys( $mySubmenu );
			$mySubmenuId = array_pop( $mySubmenuIds );

			$submenu[$menuSlug][$mySubmenuId][2] = $to;
			$mySubmenuCount++;
		}

		if( isset($submenu[$menuSlug][0]) && ($submenu[$menuSlug][0][2] == $menuSlug) ){
			unset($submenu[$menuSlug][0]);
		}

		if( ! $mySubmenuCount ){
			remove_menu_page( $menuSlug );
		}
	}

	public function setCurrentAppMenu( $parentFile )
	{
		global $submenu_file, $current_screen, $pagenow;
		$menuSlug = $this->myAdminPage;

		$my = FALSE;
		if( $current_screen->base == 'toplevel_page_' . $menuSlug ){
			$my = TRUE;
		}

		if( ! $my ){
			return $parentFile;
		}

		if( 'admin.php' == $pagenow ){
			HC4_App_Uri::currentUrl();
			$currentUrl = HC4_App_Uri::currentUrl();
			// $shortCurrentUrl = basename( $currentUrl );

			global $submenu;
			if( array_key_exists($menuSlug, $submenu) ){
				foreach( $submenu[$menuSlug] as $sbm ){
					if( substr($currentUrl, 0, strlen($sbm[2])) == $sbm[2] ){
						$submenu_file = $sbm[2];
						break;
					}
				}
			}
		}

		$parentFile = $menuSlug;
		return $parentFile;
	}

	public function isIntercepted()
	{
		$return = FALSE;

		$k = 'hcs';
		if( array_key_exists($k, $_GET) ){
			$v = sanitize_text_field( $_GET[$k] );
			if( ($v == $this->myPage) OR ($v == $this->myShortPage) ){
				$return = TRUE;
			}
		}

		return $return;
	}

	public function isMeAdmin()
	{
		$return = FALSE;
		if( ! isset($_REQUEST['page']) ){
			return $return;
		} 

		$page = sanitize_text_field( $_REQUEST['page'] );

		if( $page == $this->myAdminPage ){
			$return = TRUE;
		}

		return $return;
	}
}

}