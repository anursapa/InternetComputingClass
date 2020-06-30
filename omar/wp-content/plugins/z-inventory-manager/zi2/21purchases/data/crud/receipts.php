<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Data_Crud_Receipts
	extends HC4_Crud_Sql_Abstract
{
	public function __construct(
		HC4_Crud_Sql_Table $sqlTable
		)
	{
		$this->table = 'zi2_receipts';
		$this->idField = 'id';
		$this->mapFields = array(
			'id'				=> 'id',
			'purchase_id'	=> 'purchase_id',
			'refno'			=> 'refno',
			'created_date'	=> 'created_date',
			'description'	=> 'description',
		);
	}
}