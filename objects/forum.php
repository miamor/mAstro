<?php
class Forum extends Config {

	// database connection and table name
//	private $conn;
	private $table_name = "forum";

	// object properties
	public $id;
	public $title;
	public $code;
	public $content;
	public $cid;
	public $uid;
	public $views;
	public $author;

	public function __construct() {
		parent::__construct();
	}

	// create product
	function create(){

		// to get time-stamp for 'created' field
		parent::getTimestamp();

		//write query
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					title = ?, content = ?, fid = ?, 
					created = ?";

		$stmt = $this->conn->prepare($query);

		// posted values
		$this->title=htmlspecialchars(strip_tags($this->title));
		$this->content= content($this->content);
		$this->timestamp=htmlspecialchars(strip_tags($this->timestamp));

		// bind values
		$stmt->bindParam(1, $this->title);
		$stmt->bindParam(2, $this->content);
		$stmt->bindParam(3, $this->fid);
		$stmt->bindParam(4, $this->timestamp);

		if($stmt->execute()){
			return true;
		}else{
			return false;
		}

	}

	function readAll ($fid = 0, $page, $from_record_num, $records_per_page) {
        $lim = '';
        if ($from_record_num) $lim = "LIMIT
					{$from_record_num}, {$records_per_page}";

		$query = "SELECT * FROM " . $this->table_name . "
				WHERE 
					fid = ? AND `show` = 1
				ORDER BY
					pos ASC, modified DESC, created DESC
				{$lim}";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $fid);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['slink'] = $row['link'];
			$row['link'] = $this->bLink.'/'.$row['link'];
			$childForums = $this->readAll($row['id']);
			$row['topics'] = $this->countTopics($row['id']);
			$row['posts'] = $this->countRep($row['id']);
			$row['lastpost'] = $this->getLastPost($row['id']);
/*			while ($cF = $childForums->fetch(PDO::FETCH_ASSOC)) {
				print_r($cF);
				$row['subforums'][] = $cF;
			}
*/			$this->forumsList[$row['fid']][] = $row;
		}

		return $stmt;
	}

	function getLastPost ($fid) {
		$query = "SELECT tid,uid,created FROM topic_replies WHERE fid = {$fid} LIMIT 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $fid);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row) {
			$row['author'] = $this->getUserInfo($row['uid']);
			$row['tIn'] = $this->getTopic($row['tid']);
			$pnum = $row['tIn']['replies'] + 1;
			$row['link'] = $row['tIn']['link'].'#'.$pnum;
			return $row;
		} else return false;
	}
	function getTopic ($tid) {
		$query = "SELECT link,title,replies FROM topic WHERE id = ? LIMIT 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $tid);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row) {
			$row['link'] = $this->bLink.'/'.$this->id.'/'.$row['tIn']['link'];
			return $row;
		} else return false;
	}
	function countRep ($fid) {
		if (!$this->id) $this->id =$fid;
		
		$query = "SELECT id FROM topic WHERE fid = ?";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $fid);
		$stmt->execute();

		$num = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$num++;
			$num += $row['replies'];
		}
		return $num;
	}
	function countTopics ($fid) {
		if (!$this->id) $this->id =$fid;
		
		$query = "SELECT id FROM topic WHERE fid = ?";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $fid);
		$stmt->execute();

		$num = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) $num++;
		return $num;
	}

	function readOne() {
		$query = "SELECT * FROM
					" . $this->table_name . "
				WHERE
					id = ? OR link = ? OR title = ?
				LIMIT 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->bindParam(2, $this->id);
		$stmt->bindParam(3, $this->title);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->id = $row['id'];
		$this->title = $row['title'];
		$this->link = $row['link'];
		$this->content = $row['content'];
		$this->cid = $row['fid'];

		return $row;
	}
	
	function update() {

		$query = "UPDATE
					" . $this->table_name . "
				SET
					name = :name,
					price = :price,
					description = :description,
					category_id  = :category_id
				WHERE
					id = :id";

		$stmt = $this->conn->prepare($query);

		// posted values
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->price=htmlspecialchars(strip_tags($this->price));
		$this->description=htmlspecialchars(strip_tags($this->description));
		$this->category_id=htmlspecialchars(strip_tags($this->category_id));
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind parameters
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':category_id', $this->category_id);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// delete the product
	function delete() {

		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
		
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);

		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

}
?>
