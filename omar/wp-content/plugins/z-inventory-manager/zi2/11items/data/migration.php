<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_11Items_Data_Migration
{
	public function __construct(
		HC4_Database_Forge $dbForge,
		ZI2_11Items_Data_Crud $crud
	)
	{}

	public function version1()
	{
		$this->dbForge->add_field(
			array(
				'id' => array(
					'type' => 'INTEGER',
					'null' => FALSE,
					'auto_increment' => TRUE
					),
				'title' => array(
					'type' => 'VARCHAR(255)',
					'null' => FALSE,
					),
				'description' => array(
					'type' => 'TEXT',
					'null' => TRUE,
					),
				'status' => array(
					'type' => 'VARCHAR(16)',
					'null' => TRUE,
					'default' => 'active',
					),

				'sku' => array(
					'type' => 'VARCHAR(255)',
					'null' => TRUE,
					),
				'default_cost' => array(
					'type'	=> 'FLOAT',
					'null' => TRUE,
					),
				'default_price' => array(
					'type'	=> 'FLOAT',
					'null' => TRUE,
					),
				)
			);

		$this->dbForge->add_key( 'id', TRUE );
		$this->dbForge->create_table( 'zi2_items' );

		$sample = array(
			'id'					=> 1,
			'title'				=> 'My Item',
			'status'				=> 'active',
			'sku'					=> 'MI-123',
			'default_cost'		=> 22,
			'default_price'	=> 29,
			);
		$this->crud->create( $sample );
	}
}