<?php
class Source extends Config {

	// database connection and table name
//	private $conn;
	private $table_name = "source";

	// object properties
	public $id;
	public $title;
	public $link;
	public $content;
	public $cid;
	public $uid;
	public $views;
	public $author;
	public $sid;

	public function __construct() {
		parent::__construct();
	}

	// create product
	function create () {

		// to get time-stamp for 'created' field
		parent::getTimestamp();

		//write query
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					title = ?, link = ?, content = ?, uid = ?, fid= ?, 
					created = ?";

		$stmt = $this->conn->prepare($query);

		// posted values
		$this->title = htmlspecialchars(strip_tags($this->title));
		$this->link = encodeURL($this->title);
		$this->content = content($this->content);
		$this->timestamp = htmlspecialchars(strip_tags($this->timestamp));

		// bind values
		$stmt->bindParam(1, $this->title);
		$stmt->bindParam(2, $this->link);
		$stmt->bindParam(3, $this->content);
		$stmt->bindParam(4, $this->u);
		$stmt->bindParam(5, $this->fid);
		$stmt->bindParam(6, $this->timestamp);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}

	}

	function readOne () {
		$query = "SELECT * FROM source WHERE id = ? LIMIT 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	function readAll ($lg, $order = null) {
		if ($order) $order = "ORDER BY {$order}";
		else $order = '';
		$query = "SELECT * FROM source WHERE lang = ? {$order}";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $lg);
		$stmt->execute();

		$this->sList = array();
		$num = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$this->sList[] = $row;
			$num++;
		}
		return $this->sList;
	}
	
	public function countAll () {
		$query = "SELECT id FROM " . $this->table_name . "";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		$num = $stmt->rowCount();
		return $num;
	}

	function updateView () {
		// update views
		$this->views++;
		$queryR = "UPDATE " . $this->table_name . " SET views = :views WHERE id = :id";
		$stmt = $this->conn->prepare($queryR);
		$stmt->bindParam(':views', $this->views);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
	}
	
	function update () {

		$query = "UPDATE
					" . $this->table_name . "
				SET
					content = :content
				WHERE
					id = :id";

		$stmt = $this->conn->prepare($query);

		// posted values
		$this->content = content($this->content);

		// bind parameters
		$stmt->bindParam(':content', $this->content);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if ($stmt->execute()) return true; 
		else return false;
	}

	// delete the product
	function delete () {

		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
		
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);

		if ($result = $stmt->execute()) return true;
		else return false;
	}

}
