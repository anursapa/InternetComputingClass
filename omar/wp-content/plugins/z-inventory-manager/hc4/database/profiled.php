<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Database_Profiled
	implements HC4_Database_Interface
{
	protected $db = NULL;
	protected $profiler = NULL;

	public function __construct(
		HC4_Database_Interface $db,
		HC4_App_Profiler $profiler = NULL
	)
	{
		$this->db = $db;
		$this->profiler = $profiler;
	}

	public function query( $sql )
	{
		if( $this->profiler ){
			$this->profiler->markQueryStart( $sql );
		}

		$return = $this->db->query( $sql );

		if( $this->profiler ){
			$this->profiler->markQueryEnd();
		}

		return $return;
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