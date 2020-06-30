<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
return array(
'_version'	=> '2.0.4',
'hc4_app'	=> array(),
'hc4_assets'	=> array(),
'hc4_database_wordpress'	=> array(),
'hc4_crud_sql'	=> array(),
'hc4_settings_database'	=> array(
	'table'	=> 'zi2_conf',
	),
'hc4_csrf_wordpress'	=> array(),
'hc4_migration'	=> array(),
'hc4_redirect_wordpress'	=> array(),
'hc4_session'	=> array(
	'prefix'	=> 'zi2',
	),
'hc4_auth_wordpress'	=> array(),
'hc4_translate_wordpress'	=> array(
	'domain'			=> 'z-inventory-manager2',
	'plugin_dir'	=> __DIR__
	),
'hc4_time'	=> array(),
'hc4_finance'	=> array(),
'hc4_email_wordpress'	=> array(
	'logFile' => NULL,
	),
'hc4_ui'	=> array(),
'hc4_html_href_wordpress'	=> array(
	'app_short_name'	=> 'zi2',
	'plugin_file'		=> __DIR__ . '/z-inventory-manager2.php',
	),
'hc4_html_input'	=> array(),
'hc4_html_input_wordpress'	=> array(),
'hc4_html_screen_wordpress'	=> array(),
'hc4_html_widget'	=> array(),

'zi2_01users'		=> array(),
'zi2_02conf'		=> array(),
'zi2_03acl'			=> array(),
'zi2_04finance'	=> array(),
'zi2_11items'		=> array(),
'zi2_12wooitems'	=> array(),
'zi2_21purchases'	=> array(),
'zi2_22sales'		=> array(),
'zi2_31inventory'	=> array(),
'zi2_99app'			=> array(),
);