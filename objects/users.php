<?php
class Users extends Config {

	// database connection and table name
	private $table_name = "members";

	// object properties
	public $id;
	public $title;

	public function __construct() {
		parent::__construct();
	}

	function readAll () {
		$query = "SELECT
					*
				FROM
					" . $this->table_name . "
				ORDER BY
					rank ASC";	

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['link'] = $this->uLink.'/'.$row['username'];
			$row['name'] = ($row['last_name']) ? ($row['last_name'].' '.$row['first_name']) : $row['first_name'];
			$this->uList[] = $row;
		}

		return $stmt;
	}

	function readOne ($withC = false) {
		$cond = '';
		
		$query = "SELECT * FROM " . $this->table_name . " WHERE id = ? OR username = ? limit 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->bindParam(2, $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$this->username = $row['username'];
		$this->id = $row['id'];

		$row['link'] = $this->uLink.'/'.$row['username'];
		$row['name'] = ($row['last_name']) ? ($row['last_name'].' '.$row['first_name']) : $row['first_name'];

		return $row;
	}


}
?>
