<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_11Items_Data_Crud
	extends HC4_Crud_Sql_Abstract
{
	public function __construct(
		HC4_Crud_Sql_Table $sqlTable
		)
	{
		$this->table = 'zi2_items';
		$this->idField = 'id';
		$this->mapFields = array(
			'id'			=> 'id',
			'title'		=> 'title',
			'status'		=> 'status',
			'description'	=> 'description',
			'sku'		=> 'sku',
			'default_cost'		=> 'default_cost',
			'default_price'	=> 'default_price',
		);
	}
}