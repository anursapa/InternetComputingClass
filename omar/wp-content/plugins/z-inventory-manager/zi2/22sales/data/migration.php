<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Data_Migration
{
	public function __construct(
		HC4_Database_Forge $dbForge
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
				'refno' => array(
					'type' => 'VARCHAR(255)',
					'null' => FALSE,
					),
				'status' => array(
					'type' => 'VARCHAR(16)',
					'null' => TRUE,
					'default' => 'draft',
					),
				'created_date' => array(
					'type' => 'INTEGER',
					'null' => FALSE,
					),
				'description' => array(
					'type' => 'TEXT',
					'null' => TRUE,
					),
				)
			);
		$this->dbForge->add_key( 'id', TRUE );
		$this->dbForge->create_table( 'zi2_sales' );

		$this->dbForge->add_field(
			array(
				'id' => array(
					'type' => 'INTEGER',
					'null' => FALSE,
					'auto_increment' => TRUE
					),
				'sale_id' => array(
					'type' => 'INTEGER',
					'null' => FALSE,
					),
				'item_id' => array(
					'type' => 'INTEGER',
					'null' => FALSE,
					),
				'qty' => array(
					'type' => 'FLOAT',
					'null' => FALSE,
					),
				'price' => array(
					'type' => 'FLOAT',
					'null' => false,
					),
				)
			);
		$this->dbForge->add_key( 'id', TRUE );
		$this->dbForge->create_table( 'zi2_sales_lines' );

		$this->dbForge->add_field(
			array(
				'id' => array(
					'type' => 'INTEGER',
					'null' => FALSE,
					'auto_increment' => TRUE
					),
				'sale_id' => array(
					'type' => 'INTEGER',
					'null' => FALSE,
					),
				'refno' => array(
					'type' => 'VARCHAR(255)',
					'null' => FALSE,
					),
				'created_date' => array(
					'type' => 'INTEGER',
					'null' => FALSE,
					),
				'description' => array(
					'type' => 'TEXT',
					'null' => TRUE,
					),
				)
			);
		$this->dbForge->add_key( 'id', TRUE );
		$this->dbForge->create_table( 'zi2_shipments' );

		$this->dbForge->add_field(
			array(
				'id' => array(
					'type' => 'INTEGER',
					'null' => FALSE,
					'auto_increment' => TRUE
					),
				'shipment_id' => array(
					'type' => 'INTEGER',
					'null' => FALSE,
					),
				'item_id' => array(
					'type' => 'INTEGER',
					'null' => FALSE,
					),
				'qty' => array(
					'type' => 'FLOAT',
					'null' => FALSE,
					),
				)
			);
		$this->dbForge->add_key( 'id', TRUE );
		$this->dbForge->create_table( 'zi2_shipments_lines' );
	}
}