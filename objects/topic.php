<?php
class Topic extends Config {

	// database connection and table name
//	private $conn;
	private $table_name = "topic";

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
	function create(){

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

	function readAll ($all = false, $or = '', $page = '', $from_record_num = '', $records_per_page = '') {
        $lim = $con = '';
        if ($from_record_num) $lim = "LIMIT
					{$from_record_num}, {$records_per_page}";
		if ($all == false) $con = "WHERE 
					fid = {$this->fid}";
		else if (is_array($all)) {
			foreach ($all as $fO) 
				$fcon[] = "fid = {$fO}";
			$con = "WHERE ".implode(' OR ', $fcon);
		}
		if (!$or) $order = "last_post DESC, modified DESC, created DESC";
		else $order = $or;

		$query = "SELECT
					id,type,link,title,uid,fid,views,replies,created,last_post,content
				FROM
					" . $this->table_name . "
				{$con}
				ORDER BY {$order}
				{$lim}";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		$num = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['posts'] = $row['replies'] + 1;
			if (!$or) $row['link'] .= '#'.$row['posts'];
			$row['author'] = $this->getUserInfo($row['uid']);
			$this->id = $row['id'];
			$this->fid = $row['fid'];
/*			if ($row['replies'] > 0) $row['lastpost'] = $this->getLastPost($row['id']);
			else $row['lastpost'] = $row;
*/			$row['cat'] = $this->getForum($row['fid']);
			if ($all == false) $row['link'] = $this->bLink.'/'.$this->forumLink.'/'.$row['link'];
			else $row['link'] = $this->bLink.'/'.$row['cat']['link'].'/'.$row['link'];
			preg_match('/<img(\s|.*)src=[\'"](?P<src>.+?)[\'"].*>/i', $row['content'], $image);
			if ($image) $row['thumb'] = $image['src'];
			else $row['thumb'] = MAIN_URL.'/data/img/'.rand(1,39).'.jpg';
			$row['content'] = substr(strip_tags($row['content']), 0, 220);
			if ($num == 0) $this->topicTop = $row;
			else if ($num < 4) {
				$this->topicsListTop[] = $row;
			} else {
				if ($all == false) $this->topicsList[$row['type']][] = $row;
				else $this->topicsList[] = $row;
			}
			$num++;
		}

		return $stmt;
	}
	function getForum ($f) {
		$query = "SELECT id,title,link FROM forum WHERE id = ? LIMIT 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $f);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	function getLastPost ($id) {
//		if (!$this->id) $this->id = $id;
		
		$query = "SELECT uid,created FROM " . $this->table_name . "_replies WHERE tid = ? AND fid = ? ORDER BY created DESC LIMIT 0,1";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $id);
		$stmt->bindParam(2, $this->fid);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$row['author'] = $this->getUserInfo($row['uid']);
		if ($row) return $row;
		else return false;
	}

	public function getRep () {
		$query = "SELECT * FROM " . $this->table_name . "_replies WHERE tid = ? ORDER BY created ASC";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		$this->repList = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//			$row['content'] = content($row['content']);
			$row['author'] = $this->getUserInfo($row['uid']);
			$this->repList[] = $row;
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

	function readOne() {
		$query = "SELECT
					*
				FROM
					" . $this->table_name . "
				WHERE
					id = ? OR link = ? OR title = ?
				LIMIT
					0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->bindParam(2, $this->id);
		$stmt->bindParam(3, $this->title);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

//		$row['content'] = content($row['content']);
		$this->id = $row['id'];
		$this->title = $row['title'];
		$this->content = $row['content'];
//		$this->content = $row['content'] = str_replace(array('<p>', '</p>'), array('<div>', '</div>'), $row['content']);
		$this->views = $row['views'];
		$this->uid = $row['uid'];
		$this->replies = $row['replies'];
		
		$this->author = $row['author'] = $this->getUserInfo($this->uid);

		return $row;
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
	
	function reply () {
		// to get time-stamp for 'created' field
		parent::getTimestamp();

		//write query
		$query = "INSERT INTO
					" . $this->table_name . "_replies
				SET
					content = ?, tid = ?, fid = ?, uid = ?, created = ?";

		$stmt = $this->conn->prepare($query);

		// posted values
		$this->content= content($this->replycontent);
		$this->timestamp=htmlspecialchars(strip_tags($this->timestamp));

		// bind values
		$stmt->bindParam(1, $this->content);
		$stmt->bindParam(2, $this->id);
		$stmt->bindParam(3, $this->fid);
		$stmt->bindParam(4, $this->u);
		$stmt->bindParam(5, $this->timestamp);

		if ($stmt->execute()) {
			// update replies and last post time
			$this->replies++;
			$queryR = "UPDATE " . $this->table_name . " SET replies = :replies, last_post = :last_post WHERE id = :id";
			$stmt = $this->conn->prepare($queryR);
			$stmt->bindParam(':replies', $this->replies);
			$stmt->bindParam(':last_post', $this->timestamp);
			$stmt->bindParam(':id', $this->id);
			if ($stmt->execute()) return true;
			else return false;
		} else return false;
	}
	

	function update() {

		$query = "UPDATE
					" . $this->table_name . "
				SET
					title = :title,
					content = :content
				WHERE
					id = :id";

		$stmt = $this->conn->prepare($query);

		// posted values
		$this->title = content($this->title);
		$this->content = content($this->content);

		// bind parameters
		$stmt->bindParam(':title', $this->title);
		$stmt->bindParam(':content', $this->content);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if ($stmt->execute()) return true; 
		else return false;
	}

	// delete the product
	function delete() {

		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
		
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);

		if ($result = $stmt->execute()) return true;
		else return false;
	}

}
?>
