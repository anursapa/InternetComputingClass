<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Data_Crud_Shipments_Lines
	extends HC4_Crud_Sql_Abstract
{
	public function __construct(
		HC4_Crud_Sql_Table $sqlTable
		)
	{
		$this->table = 'zi2_shipments_lines';
		$this->idField = 'id';
		$this->mapFields = array(
			'id'				=> 'id',
			'shipment_id'	=> 'shipment_id',
			'item_id'		=> 'item_id',
			'qty'				=> 'qty',
		);
	}
}