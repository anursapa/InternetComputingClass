<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_11Items_Data_Model
{
	private $_set = array();

	private $id;
	private $title;
	private $description;
	private $status = 'active';	// 'active', 'archived'
	private $sku = 'SPR-123';
	private $defaultCost;
	private $defaultPrice;

	public function __clone()
	{
		$this->_set = array();
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