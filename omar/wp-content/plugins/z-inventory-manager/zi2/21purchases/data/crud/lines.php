<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Data_Crud_Lines
	extends HC4_Crud_Sql_Abstract
{
	public function __construct(
		HC4_Crud_Sql_Table $sqlTable
		)
	{
		$this->table = 'zi2_purchases_lines';
		$this->idField = 'id';
		$this->mapFields = array(
			'id'				=> 'id',
			'purchase_id'	=> 'purchase_id',
			'item_id'		=> 'item_id',
			'qty'				=> 'qty',
			'price'			=> 'price',
		);
	}
}