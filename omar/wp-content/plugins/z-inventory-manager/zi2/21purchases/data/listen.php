<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Data_Listen
{
	public function __construct(
		ZI2_21Purchases_Data_Repo_Lines $repoLines,
		ZI2_21Purchases_Data_Repo_Receipts_Lines $repoReceiptsLines
	)
	{}

	public function itemDeleted( $eventName, ZI2_11Items_Data_Model $item )
	{
		$lines = $this->repoLines->findManyByItem( $item );
		foreach( $lines as $line ){
			$this->repoLines->delete( $line );
		}

		$receiptsLines = $this->repoReceiptsLines->findManyByItem( $item );
		foreach( $receiptsLines as $line ){
			$this->repoReceiptsLines->delete( $line );
		}
	}
}