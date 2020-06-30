<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_99App_Data_Upgrade
{
	public function __construct(
		ZI2_11Items_Data_Crud $crudItems,

		ZI2_21Purchases_Data_Crud $crudPurchases,
		ZI2_21Purchases_Data_Crud_Lines $crudPurchaseLines,
		ZI2_21Purchases_Data_Crud_Receipts $crudPurchaseReceipts,
		ZI2_21Purchases_Data_Crud_Receipts_Lines $crudPurchaseReceiptsLines,

		ZI2_22Sales_Data_Crud $crudSales,
		ZI2_22Sales_Data_Crud_Lines $crudSaleLines,
		ZI2_22Sales_Data_Crud_Shipments $crudSaleShipments,
		ZI2_22Sales_Data_Crud_Shipments_Lines $crudSaleShipmentLines,

		HC4_Database_Interface $db,
		HC4_Crud_Sql_Table $sqlTable
	)
	{}

	public function run()
	{
	// check if version 1 is present
		// $testTable = 'hcim_v1_conf';
		// if( ! $this->db->table_exists($testTable) ){
			// return;
		// }

	// get items
		$wpQ = array();
		$wpQ['post_type'] = 'hcim-item';
		$wpQ['post_status'] = array( 'any', 'trash' );
		$wpQ['perm'] = 'readable';
		$wpQ['posts_per_page'] = -1;
		$items = get_posts( $wpQ );

		if( ! $items ){
			return;
		}

		$newItems = array();
		foreach( $items as $p ){
			$meta = get_metadata( 'post', $p->ID );
			$meta = array_map( function($n){return $n[0];}, $meta );

			$newE = array(
				'id'					=> $p->ID,
				'title'				=> $p->post_title,
				'description'		=> $p->post_content,
				'status'				=> ( 'publish' == $p->post_status ) ? 'active' : 'archived',
				'sku'					=> isset( $meta['ref'] ) ? $meta['ref'] : '',
				'default_cost'		=> isset( $meta['cost'] ) ? $meta['cost'] : NULL, 
				'default_price'	=> isset( $meta['price'] ) ? $meta['price'] : NULL,
				);

			$newItems[] = $newE;
		}

		$this->sqlTable->deleteAll( 'zi2_items' );
		$this->crudItems->createBatch( $newItems );

	// PURCHASES
		$q = new HC4_Crud_Q;
		$purchases = $this->sqlTable->read( 'hcim_v1_purchases', $q );

		if( $purchases ){
			$newPurchases = array();
			$newPurchaseLines = array();

			foreach( $purchases as $e ){
				$newE = array(
					'id'					=> $e['id'],
					'refno'				=> $e['ref'],
					'status'				=> ( 1 == $e['status'] ) ? 'draft' : 'issued',
					'created_date'		=> $e['date'],
					'description'		=> $e['description'],
					);
				$newPurchases[] = $newE;
			}

			$this->sqlTable->deleteAll( 'zi2_purchases' );
			$this->crudPurchases->createBatch( $newPurchases );

			$q = new HC4_Crud_Q;
			$q->where( 'relation_name', '=', 'item_to_purchase' );
			$raw = $this->sqlTable->read( 'hcim_v1_relations', $q );
			foreach( $raw as $e ){
				$newPurchaseLines[] = array(
					'purchase_id'	=> $e['to_id'],
					'item_id'		=> $e['from_id'],
					'qty'				=> $e['meta1'],
					'price'			=> $e['meta2'],
					);
			}

			$this->sqlTable->deleteAll( 'zi2_purchases_lines' );
			$this->crudPurchaseLines->createBatch( $newPurchaseLines );
		}

	// RECEIPTS
		$q = new HC4_Crud_Q;
		$receives = $this->sqlTable->read( 'hcim_v1_receives', $q );

		if( $receives ){
			$newReceives = array();
			$newReceiveLines = array();

			$receiveToPurchase = array();
			$q = new HC4_Crud_Q;
			$q->where( 'relation_name', '=', 'receive_to_purchase' );
			$raw = $this->sqlTable->read( 'hcim_v1_relations', $q );
			foreach( $raw as $e ){
				$receiveToPurchase[ $e['from_id'] ] = $e['to_id'];
			}

			foreach( $receives as $e ){
				$newE = array(
					'id'					=> $e['id'],
					'refno'				=> $e['ref'],
					'created_date'		=> $e['date'],
					'description'		=> $e['description'],
					'purchase_id'		=> $receiveToPurchase[ $e['id'] ]
					);
				$newReceives[] = $newE;
			}

			$this->sqlTable->deleteAll( 'zi2_receipts' );
			$this->crudPurchaseReceipts->createBatch( $newReceives );

			$q = new HC4_Crud_Q;
			$q->where( 'relation_name', '=', 'item_to_receive' );
			$raw = $this->sqlTable->read( 'hcim_v1_relations', $q );
			foreach( $raw as $e ){
				$newReceiveLines[] = array(
					'receipt_id'	=> $e['to_id'],
					'item_id'		=> $e['from_id'],
					'qty'				=> $e['meta1'],
					);
			}

			$this->sqlTable->deleteAll( 'zi2_receipts_lines' );
			$this->crudPurchaseReceiptsLines->createBatch( $newReceiveLines );
		}

	// SALES
		$q = new HC4_Crud_Q;
		$sales = $this->sqlTable->read( 'hcim_v1_sales', $q );
		if( $sales ){
			$newSales = array();
			$newSaleLines = array();

			foreach( $sales as $e ){
				$newE = array(
					'id'					=> $e['id'],
					'refno'				=> $e['ref'],
					'status'				=> ( 1 == $e['status'] ) ? 'draft' : 'issued',
					'created_date'		=> $e['date'],
					'description'		=> $e['description'],
					);
				$newSales[] = $newE;
			}

			$this->sqlTable->deleteAll( 'zi2_sales' );
			$this->crudSales->createBatch( $newSales );

			$q = new HC4_Crud_Q;
			$q->where( 'relation_name', '=', 'item_to_sale' );
			$raw = $this->sqlTable->read( 'hcim_v1_relations', $q );
			foreach( $raw as $e ){
				$newSaleLines[] = array(
					'sale_id'		=> $e['to_id'],
					'item_id'		=> $e['from_id'],
					'qty'				=> $e['meta1'],
					'price'			=> $e['meta2'],
					);
			}

			$this->sqlTable->deleteAll( 'zi2_sales_lines' );
			$this->crudSaleLines->createBatch( $newSaleLines );
		}

	// SHIPMENTS
		$q = new HC4_Crud_Q;
		$shipments = $this->sqlTable->read( 'hcim_v1_shipments', $q );

		if( $shipments ){
			$newShipments = array();
			$newShipmentLines = array();

			$shipmentToSale = array();
			$q = new HC4_Crud_Q;
			$q->where( 'relation_name', '=', 'shipment_to_sale' );
			$raw = $this->sqlTable->read( 'hcim_v1_relations', $q );
			foreach( $raw as $e ){
				$shipmentToSale[ $e['from_id'] ] = $e['to_id'];
			}

			foreach( $shipments as $e ){
				$newE = array(
					'id'					=> $e['id'],
					'refno'				=> $e['ref'],
					'created_date'		=> $e['date'],
					'description'		=> $e['description'],
					'sale_id'			=> $shipmentToSale[ $e['id'] ]
					);
				$newShipments[] = $newE;
			}

			$this->sqlTable->deleteAll( 'zi2_shipments' );
			$this->crudSaleShipments->createBatch( $newShipments );

			$q = new HC4_Crud_Q;
			$q->where( 'relation_name', '=', 'item_to_shipment' );
			$raw = $this->sqlTable->read( 'hcim_v1_relations', $q );
			foreach( $raw as $e ){
				$newShipmentLines[] = array(
					'shipment_id'	=> $e['to_id'],
					'item_id'		=> $e['from_id'],
					'qty'				=> $e['meta1'],
					);
			}

			$this->sqlTable->deleteAll( 'zi2_shipments_lines' );
			$this->crudSaleShipmentLines->createBatch( $newShipmentLines );
		}
	}
}