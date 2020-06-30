<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Auth_Wordpress_Implementation
	implements HC4_Auth_Interface
{
	public function getCurrentUserId()
	{
		$return = get_current_user_id();
		return $return;
	}
}