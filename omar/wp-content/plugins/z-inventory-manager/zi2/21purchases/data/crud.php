<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Data_Crud
	extends HC4_Crud_Sql_Abstract
{
	public function __construct(
		HC4_Crud_Sql_Table $sqlTable
		)
	{
		$this->table = 'zi2_purchases';
		$this->idField = 'id';
		$this->mapFields = array(
			'id'				=> 'id',
			'refno'			=> 'refno',
			'status'			=> 'status',
			'created_date'	=> 'created_date',
			'description'	=> 'description',
		);
	}
}