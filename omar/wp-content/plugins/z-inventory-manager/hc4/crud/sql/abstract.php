<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Crud_Sql_Abstract
{
	protected $table;
	protected $idField = 'id';
	protected $mapFields = array();

	public function __construct(
		HC4_Crud_SqlTable $sqlTable
	)
	{}

	public function read( HC4_Crud_Q $q )
	{
		return $this->sqlTable->read( $this->table, $q, $this->mapFields );
	}

	public function update( $id, array $array )
	{
		return $this->sqlTable->update( $this->table, $id, $array, $this->mapFields, $this->idField );
	}

	public function updateByQ( HC4_Crud_Q $q, array $array )
	{
		return $this->sqlTable->updateByQ( $this->table, $q, $array, $this->mapFields );
	}

	public function create( $array )
	{
		return $this->sqlTable->create( $this->table, $array, $this->mapFields );
	}

	public function createBatch( $array )
	{
		return $this->sqlTable->createBatch( $this->table, $array, $this->mapFields );
	}

	public function delete( $id )
	{
		return $this->sqlTable->delete( $this->table, $id, $this->idField );
	}

	public function deleteByQ( HC4_Crud_Q $q )
	{
		return $this->sqlTable->deleteByQ( $this->table, $q, $this->mapFields );
	}
}