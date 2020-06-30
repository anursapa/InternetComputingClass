<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_01Users_Data_Model
{
	private $_set = array();

	protected $id;
	protected $title;
	protected $username;
	protected $email;
	protected $raw;

	public function __clone()
	{
		$this->_set = array();
	}

	public function toArray()
	{
		$return = array(
			'id'			=> $this->id,
			'title'		=> $this->title,
			'email'		=> $this->email ? $this->email : static::NO_EMAIL,
			'username'	=> $this->username,
			'status'		=> $this->status,
			);
		return $return;
	}

	public function __set( $name, $value )
	{
		if( ! property_exists($this, $name) ){
			$msg = 'Invalid property: ' . __CLASS__ . ': ' . $name;
			echo $msg;
			return;
		}

		if( array_key_exists($name, $this->_set) ){
			$msg = 'Property already set: ' . __CLASS__ . ': ' . $name;
			echo $msg;
			return;
		}

		$this->{$name} = $value;
		$this->_set[$name] = 1;
	}

	public function __get( $name )
	{
		if( ! property_exists($this, $name) ){
			$msg = 'Invalid property: ' . __CLASS__ . ': ' . $name;
			echo $msg;
		}
		return $this->{$name};
	}
}