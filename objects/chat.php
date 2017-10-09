<?php
class Chat extends Config {

	// database connection and table name
//	private $conn;
	private $table_name = "chat";

	// object properties
	public $id;
	public $content;
	public $uid;
	public $author;

	public function __construct() {
		parent::__construct();
	}

	// create product
	function send () {

		// to get time-stamp for 'created' field
		parent::getTimestamp();

		//write query
		$query = "INSERT INTO " . $this->table_name . " SET
					content = ?, uid = ?, created = ?, tid = ?, tmid = ?";

		$stmt = $this->conn->prepare($query);

		// posted values
		$this->content = content($this->content);
		$this->timestamp = htmlspecialchars(strip_tags($this->timestamp));

		// bind values
		$stmt->bindParam(1, $this->content);
		$stmt->bindParam(2, $this->u);
		$stmt->bindParam(3, $this->timestamp);
		$stmt->bindParam(4, $this->roomID);
		$stmt->bindParam(5, $this->teamID);

		if ($stmt->execute()) return true;
		else return false;

	}

	function readAll ($page, $from_record_num, $records_per_page) {
        $lim = '';
        if ($from_record_num) $lim = "LIMIT
					{$from_record_num}, {$records_per_page}";

		$query = "SELECT
					*
				FROM
					" . $this->table_name . "
				WHERE 
					tid = ? AND tmid = ?
				ORDER BY
					modified ASC, created ASC
				{$lim}";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->roomID);
		$stmt->bindParam(2, $this->teamID);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['author'] = $this->getUserInfo($row['uid']);
			$row['createDateAr'] = explode(' ', $row['created']);
			$row['createDate'] = $row['createDateAr'][0];
			$row['createTime'] = $row['createDateAr'][1];
			$row['content'] = str_replace("'", "\'", $row['content']);

			$this->cList[] = $row;
		}

		return $stmt;
	}
	public function countAll(){

		$query = "SELECT id FROM " . $this->table_name . "";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		$num = $stmt->rowCount();

		return $num;
	}

	function getMemberlist ($page, $from_record_num, $records_per_page) {
        $lim = '';
        if ($from_record_num) $lim = "LIMIT
					{$from_record_num}, {$records_per_page}";

		$query = "SELECT * FROM
					members
				ORDER BY
					modified DESC, created DESC
				{$lim}";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['link'] = $this->uLink.'/'.$row['username'];
			$row['name'] = ($row['last_name']) ? ($row['last_name'].' '.$row['first_name']) : $row['first_name'];
			$this->mList[$row['online']][] = $row;
		}

		return $stmt;
	}

}
?>
