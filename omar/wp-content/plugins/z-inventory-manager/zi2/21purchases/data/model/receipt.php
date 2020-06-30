<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Data_Model_Receipt
{
	public $id;
	public $refno;
	public $createdDate;
	public $description;
	public $lines = array();	// ZI2_21Purchases_Data_Model_Receipt_Line
}