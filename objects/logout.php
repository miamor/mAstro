<?
class Logout extends Config {

	// database connection and table name
	private $table_name = "members";

	// object properties
	public $id;
	public $title;

	public function __construct() {
		parent::__construct();
	}

	function logout () {
		$query = "SELECT username,password,id FROM " . $this->table_name . " WHERE username = ? AND password = ? LIMIT 0, 1";	

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->username);
		$stmt->bindParam(2, $this->password);
		$stmt->execute();
		$num = $stmt->rowCount();

		if ($num > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->uid = $row['id'];
			
			// update online
			$query = "UPDATE
					" . $this->table_name . "
				SET
					online = 1,
				WHERE
					id = :id";

			$stmt = $this->conn->prepare($query);
			
			$stmt->bindParam(':id', $this->uid);

			// execute the query
			if ($stmt->execute()) return true;
			else return true;
		} 
		
		return false;
	}

	session_destroy();
//}
}
