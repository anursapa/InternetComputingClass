<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Data_Crud_Lines
	extends HC4_Crud_Sql_Abstract
{
	public function __construct(
		HC4_Crud_Sql_Table $sqlTable
		)
	{
		$this->table = 'zi2_sales_lines';
		$this->idField = 'id';
		$this->mapFields = array(
			'id'			=> 'id',
			'sale_id'	=> 'sale_id',
			'item_id'	=> 'item_id',
			'qty'			=> 'qty',
			'price'		=> 'price',
		);
	}
}