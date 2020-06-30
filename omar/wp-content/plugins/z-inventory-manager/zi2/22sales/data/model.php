<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Data_Model
{
	private $_set = array();

	private $id;
	private $refno;
	private $status = 'draft';	// 'draft', 'issued',  calculated: 'partially', 'shipped'
	private $createdDate;
	private $description;

	private $lines = array();	// ZI2_22Sales_Data_Model_Line
	private $shipments = array();	// ZI2_22Sales_Data_Model_Shipment

	public function __clone()
	{
		$this->_set = array();
	}

	public function isDraft()
	{
		return ( 'draft' == $this->status );
	}

	public function getItemsToShip()
	{
		$return = array();

		reset( $this->lines );
		foreach( $this->lines as $e ){
			$return[ $e->item->id ] = $e->qty;
		}

		reset( $this->shipments );
		foreach( $this->shipments as $r ){
			foreach( $r->lines as $e ){
				if( ! isset($return[$e->item->id]) ){
					continue;
				}
				$return[$e->item->id] -= $e->qty;
				if( $return[$e->item->id] <= 0 ){
					unset( $return[$e->item->id] );
				}
			}
		}

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

		if( 'status' == $name ){
			if( 'issued' != $this->{$name} ){
				return $this->{$name};
			}

			if( $this->shipments ){
				$toShip = $this->getItemsToShip();
				$return = $toShip ? 'partially' : 'shipped';
				return $return;
			}
		}

		return $this->{$name};
	}
}