<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Settings_Database_Boot
{
/**
*	$config
*		['table']	string Table name in the database
*
*	@param array $config
*	@return array
*/

	public static function bind( array $config = array() )
	{
		$bind = array();
		$bind['HC4_Settings_Interface'] = 'HC4_Settings_Database_Implementation';

		if( isset($config['table']) ){
			$bind['HC4_Settings_Database_Crud->table'] = $config['table'];
		}

		return $bind;
	}

	public function __invoke()
	{}
}