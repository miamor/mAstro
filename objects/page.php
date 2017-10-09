<?
abstract class Page extends Config {

	// database connection and table name
//	protected $conn;
	
	protected $uid;

	public function __construct() {
		$this->conn = parent::__construct();
	}

}
