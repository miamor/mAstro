<?php
class Login extends Config {

	// database connection and table name
	private $table_name = "members";

	// object properties
	public $id;
	public $title;

	public function __construct() {
		parent::__construct();
	}

	function create ($oauth_uid, $name, $uname) {
		// check if user already exists
		$qC = "SELECT oauth_uid,oauth_token,id,username FROM " . $this->table_name . " WHERE (oauth_uid != NULL AND oauth_uid = ?) OR username = ? LIMIT 0, 1";	
		$stmt = $this->conn->prepare($qC);
		$stmt->bindParam(1, $oauth_uid);
		$stmt->bindParam(2, $uname);
		$stmt->execute();
		$num = $stmt->rowCount();

		if ($num > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			//echo $oauth_uid.'~~~~'.$uname.'~~~~';
			//print_r($row);
			return $row['id'];
		} else {
			$query = "INSERT INTO
						members
					SET
						oauth_uid = ?, first_name = ?, last_name = ?, username = ?";

			$stmt = $this->conn->prepare($query);
		
			$name = explode(' ', $name);
			$fname = $name[count($name) - 1];
			$lname = $name[0];
			// bind values
			$stmt->bindParam(1, $oauth_uid);
			$stmt->bindParam(2, $fname);
			$stmt->bindParam(3, $lname);
			$stmt->bindParam(4, $uname);

			// execute the query
			if ($stmt->execute()) {
				// get the new user
				$qC = "SELECT id FROM " . $this->table_name . " WHERE oauth_uid = ? LIMIT 0, 1";	
				$stmt = $this->conn->prepare($qC);
				$stmt->bindParam(1, $oauth_uid);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				return $row['id'];
			} else return 0;
		}
	}
	
	function loginFb () {
		$query = "SELECT oauth_uid,oauth_token,id FROM " . $this->table_name . " WHERE oauth_uid = ? OR username = ? LIMIT 0, 1";	

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->uid);
		$stmt->bindParam(2, $this->username);
		$stmt->execute();
		$num = $stmt->rowCount();

		if ($num > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
//			$this->u = $row['id'];
			if ($row['oauth_uid']) {
				$query = "UPDATE " . $this->table_name . " SET oauth_token = :token WHERE oauth_uid = :uid";

				$stmt = $this->conn->prepare($query);
				
				$stmt->bindParam(':token', $this->token);
				$stmt->bindParam(':uid', $this->uid);
				
				// execute the query
				if ($stmt->execute()) return true;
				else return false;
			} else {
				$query = "UPDATE " . $this->table_name . " SET oauth_token = :token, oauth_uid = :uid WHERE username = :uname";

				$stmt = $this->conn->prepare($query);
				
				$stmt->bindParam(':token', $this->token);
				$stmt->bindParam(':uid', $this->uid);
				$stmt->bindParam(':uname', $this->username);
				
				// execute the query
				if ($stmt->execute()) return true;
				else return false;
			}
		} else {
			$query = "INSERT INTO
						members
					SET
						oauth_uid = ?, oauth_token = ?, first_name = ?, last_name = ?, username = ?, avatar = ?";

			$stmt = $this->conn->prepare($query);
		
			$name = explode(' ', $this->name);
			$fname = $name[count($name) - 1];
			$lname = $name[0];
			// bind values
			$stmt->bindParam(1, $this->uid);
			$stmt->bindParam(2, $this->token);
			$stmt->bindParam(3, $fname);
			$stmt->bindParam(4, $lname);
			$stmt->bindParam(5, $this->username);
			$stmt->bindParam(6, $this->avatar);

			// execute the query
			if ($stmt->execute()) return true;
			else return true;
		}

		return false;
	}

	function login () {
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
					online = 1
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

	function logout () {
		$query = "SELECT id FROM " . $this->table_name . " WHERE id = ? LIMIT 0, 1";	

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->u);
		$stmt->execute();
		$num = $stmt->rowCount();

		if ($num > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			// update online
			$query = "UPDATE
					" . $this->table_name . "
				SET
					online = 0,
				WHERE
					id = :id";

			$stmt = $this->conn->prepare($query);
			
			$stmt->bindParam(':id', $this->u);

			// execute the query
			if ($stmt->execute()) return true;
			else return true;
		} 
		
		return false;
	}

}
