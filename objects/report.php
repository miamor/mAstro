<?php
class Report extends Config {

	// database connection and table name
//	private $conn;
	private $table_name = "data";

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

	function add () {
		parent::getTimestamp();

		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					uid = ?, code = ?, sid = ?, content = ?, lang= ?, time = ?";

		$stmt = $this->conn->prepare($query);

		$this->code = trendCode($this->code);
		$this->content = content($this->content);
		$this->timestamp = htmlspecialchars(strip_tags($this->timestamp));

		// bind values
		$stmt->bindParam(1, $this->u);
		$stmt->bindParam(2, $this->code);
		$stmt->bindParam(3, $this->sid);
		$stmt->bindParam(4, $this->content);
		$stmt->bindParam(5, $this->lang);
		$stmt->bindParam(6, $this->timestamp);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}

	}
	function addTrans () {
		parent::getTimestamp();

		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					uid = ?, code = ?, content = ?, lang= ?, translates = ?, untrans = ?, time = ?";

		$stmt = $this->conn->prepare($query);

		$this->code = trendCode($this->code);
		$this->content = content($this->content);
		$this->timestamp = htmlspecialchars(strip_tags($this->timestamp));

		// bind values
		$stmt->bindParam(1, $this->u);
		$stmt->bindParam(2, $this->code);
		$stmt->bindParam(3, $this->content);
		$stmt->bindParam(4, $this->lang);
		$stmt->bindParam(5, $this->translate);
		$stmt->bindParam(6, $this->u);
		$stmt->bindParam(7, $this->timestamp);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}

	}

	function readAll ($code, $lang, $trans = 0, $order) {
		if ($order) $order = "ORDER BY {$order}";
		else $order = '';
		$query = "SELECT * FROM data WHERE code = ? AND lang = ? AND translate = ? {$order}";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $code);
		$stmt->bindParam(2, $lang);
		$stmt->bindParam(3, $trans);
		$stmt->execute();
		$this->rList = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
			$this->rList[] = $row;
		return $this->rList;
	}
	
	function getData ($code, $lg = null, $sid = null) {
		if (!$lg) $query = "SELECT * FROM data WHERE
					code = ? 
				ORDER BY LENGTH(likes) DESC, LENGTH(dislikes) ASC, `id` DESC 
				LIMIT 0,1";
		else if ($sid) $query = "SELECT * FROM data WHERE
					code = ? AND lang = ? AND sid = ?
				ORDER BY LENGTH(likes) DESC, LENGTH(dislikes) ASC, `id` DESC 
				LIMIT 0,1";
		else $query = "SELECT * FROM data WHERE
					code = ? AND lang = ? 
				ORDER BY LENGTH(likes) DESC, LENGTH(dislikes) ASC, `id` DESC
				LIMIT 0,1";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $code);
		if ($lg) {
			$stmt->bindParam(2, $lg);
			if ($sid) $stmt->bindParam(3, $sid);
		}
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	
	public function countAll () {
		$query = "SELECT id FROM " . $this->table_name . "";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		$num = $stmt->rowCount();
		return $num;
	}

	public function check () {
		$query = "SELECT id FROM " . $this->table_name . " WHERE code = ? AND content = ?";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->code);
		$stmt->bindParam(2, $this->content);
		$stmt->execute();
		$num = $stmt->rowCount();
		return $num;
	}

	function readOne () {
		$query = "SELECT * FROM
					" . $this->table_name . "
				WHERE
					id = ?
				LIMIT
					0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

//		$row['content'] = content($row['content']);
		$this->id = $row['id'];
		$this->code = $row['code'];
		$this->content = htmlentities($row['content']);
		$this->lang = $row['lang'];
//		$this->views = $row['views'];
		$this->uid = $row['uid'];
		$this->translate = $row['translate'];
		$this->link = $row['link'] = $this->reLink.'/'.$row['id'];
		
		$this->author = $row['author'] = $this->getUserInfo($this->uid);

		return $row;
	}
	
	function vote ($type) {
//		$this->likesAr = $this->voteAr['likes'];
//		$this->dislikesAr = $this->voteAr['dislikes'];
		if (!$this->u) return false;
		else {
		$rtype = ($type == 'like') ? 'dislike' : 'like';
		if (in_array($this->u, $this->voteAr[$rtype])) $this->voteAr[$rtype] = array_diff($this->voteAr[$rtype], array($this->u));
		if (in_array($this->u, $this->voteAr[$type])) $this->voteAr[$type] = array_diff($this->voteAr[$type], array($this->u));
		else $this->voteAr[$type][] = $this->u;
		$vStr = implode(',', $this->voteAr[$type]);
		$rvStr = implode(',', $this->voteAr[$rtype]);
		$queryR = "UPDATE " . $this->table_name . " SET {$type}s = :vStr, {$rtype}s = :rvStr WHERE id = :id";
		$stmt = $this->conn->prepare($queryR);
		$stmt->bindParam(':vStr', $vStr);
		$stmt->bindParam(':rvStr', $rvStr);
		$stmt->bindParam(':id', $this->id);
		return $stmt->execute();
		}
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
	
	function countTranslate ($did) {
		$query = "SELECT id FROM data WHERE `translate` = '1' AND `did` = ? ";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $did);
		$stmt->execute();
		$num = $stmt->rowCount();
		return $num;
	}
	
	function update () {

		$query = "UPDATE " . $this->table_name . " SET content = :content WHERE id = :id";

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
