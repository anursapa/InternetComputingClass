<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Data_Model_Shipment
{
	public $id;
	public $refno;
	public $createdDate;
	public $description;
	public $lines = array();	// ZI2_22Sales_Data_Model_Shipment_Line
}