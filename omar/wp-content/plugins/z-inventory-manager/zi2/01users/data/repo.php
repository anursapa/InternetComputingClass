<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface ZI2_01Users_Data_Repo_
{
	public function findAll();
	public function findById( $id );
}

class ZI2_01Users_Data_Repo
	implements ZI2_01Users_Data_Repo_
{
	public function __construct(
		HC4_Settings_Interface $settings
	)
	{}

	public function fromWordPress( $userdata )
	{
		$return = new ZI2_01Users_Data_Model;
		$return->id = $userdata->ID;
		$return->title = $userdata->display_name;
		$return->email = $userdata->user_email;
		$return->username = $userdata->user_login;
		$return->raw = $userdata;
		return $return;
	}

	public function findAll()
	{
		static $return = NULL;
		if( NULL !== $return ){
			return $return;
		}

		$return = array();

		$q = array();
		$q['orderby'] = 'name';
		$q['order'] = 'ASC';

		$wpUsersQuery = new WP_User_Query( $q );
		$wpUsers = $wpUsersQuery->get_results();

		$return = array();
		$count = count( $wpUsers );
		for( $ii = 0; $ii < $count; $ii++ ){
			$model = $this->fromWordPress( $wpUsers[$ii] );
			$return[ $model->id ] = $model;
		}

		return $return;
	}

	public function findById( $id )
	{
		static $cache = array();
		if( isset($cache[$id]) ){
			return $cache[$id];
		}

		if( $id && ($userdata = get_user_by('id', $id)) ){
			$return = $this->fromWordPress( $userdata );
		}
		else {
			$return = new ZI2_01Users_Data_Model;
		}

		$cache[$id] = $return;
		return $return;
	}
}