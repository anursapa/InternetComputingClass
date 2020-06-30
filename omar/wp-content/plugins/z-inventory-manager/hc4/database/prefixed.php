<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Database_Prefixed
	implements HC4_Database_Interface
{
	protected $db = NULL;
	public $prefix = NULL;

	public function __construct(
		HC4_Database_Interface $db,
		$prefix
	)
	{
		$this->db = $db;
		$this->prefix = $prefix;
	}

	public function query( $sql )
	{
		$sql = str_replace( '{PREFIX}', $this->prefix, $sql );
		return $this->db->query( $sql );
	}

	public function insertId()
	{
		return $this->db->insertid();
	}

	public function tableExists( $tableName )
	{
		return $this->db->tableExists( $tableName );
	}

	public function listTables()
	{
		return $this->db->listTables();
	}
}