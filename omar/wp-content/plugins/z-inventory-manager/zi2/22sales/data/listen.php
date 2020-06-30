<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_22Sales_Data_Listen
{
	public function __construct(
		ZI2_22Sales_Data_Repo_Lines $repoLines,
		ZI2_22Sales_Data_Repo_Shipments_Lines $repoShipmentsLines
	)
	{}

	public function itemDeleted( ZI2_11Items_Data_Model $item )
	{
		$lines = $this->repoLines->findManyByItem( $item );
		foreach( $lines as $line ){
			$this->repoLines->delete( $line );
		}

		$shipmentsLines = $this->repoShipmentsLines->findManyByItem( $item );
		foreach( $shipmentsLines as $line ){
			$this->repoShipmentsLines->delete( $line );
		}
	}
}