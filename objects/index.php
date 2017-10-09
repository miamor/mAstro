<?
class Index extends Config {

	public function __construct() {
		parent::__construct();
	}

	function readProblems ($page, $from_record_num, $records_per_page) {
		$lim = '';
		if ($from_record_num) $lim = "LIMIT
					{$from_record_num}, {$records_per_page}";

		$query = "SELECT
					*
				FROM
					problems
				ORDER BY
					modified DESC, created DESC
				{$lim}";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['link'] = $this->pLink.'/'.$row['code'];
			$row['author'] = $this->getUserInfo($row['uid']);
			
			$row['scoreTxtCorlor'] = '';
			if ($row['score'] >= 80) $row['scoreTxtCorlor'] = 'success';
			else if ($row['score'] >= 50) $row['scoreTxtCorlor'] = 'warning';
			
			$numSub = $this->getDifficulty($row['id'], $row['tests']);
			$row['totalAC'] = $this->totalAC;
			$row['totalTests'] = $this->totalTests = $row['tests'] * $numSub;
			if ($numSub == 0) $row['per'] = 0;
			else $row['per'] = round($row['totalAC']/$row['totalTests'] * 100, 2);
			
			if ($row['per'] > 80) $row['perCls'] = 'success';
			
			$row['cat'] = $this->getCat($row['cid']);
			
			$this->problemsList[] = $row;
		}

		return $stmt;
	}
	public function getDifficulty ($id, $tests) {
		$query = "SELECT * FROM submissions WHERE iid = ? AND team = 0";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $id);
		$stmt->execute();

		$this->totalAC = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			$this->totalAC += $row['AC'];
		return $stmt->rowCount();
	}
	public function getCat ($id) {
		$query = "SELECT * FROM categories WHERE id = ?";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	
	
	function readCat () {
		//select all data
		$query = "SELECT
					id, title, link
				FROM
					categories
				ORDER BY
					title";	

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['link'] = $this->cLink.'/'.$row['link'];
			$row['num'] = $this->getProbNum($row['id']);
			$this->catList[] = $row;
		}
		return $stmt;
	}
	function getProbNum ($id) {
		$query = "SELECT * FROM problems WHERE cid = ?";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $id);
		$stmt->execute();

		return $stmt->rowCount();
	}


	function topUsers () {
		$query = "SELECT
					id, username, first_name, last_name, avatar, rank, online, score 
				FROM
					members
				ORDER BY 
					rank ASC
				LIMIT 0, 10";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['name'] = $row['first_name'].' '.$row['last_name'];
			$row['link'] = $this->uLink.'/'.$row['username'];
			$row['score'] = $this->getScore($row['id']);
			$this->topUsers[] = $row;
		}

		return $stmt;
	}
	
	function getScore ($u) {
		$query = "SELECT AC,console FROM submissions WHERE uid = ?";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $u);
		$stmt->execute();

		$score = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$console = json_decode($row['console'], true);
			$AC = $row['AC'];
			$score += round($AC/count($console['tests'])*100, 2);
		}
		
		$query = "SELECT id FROM problems";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		$totalProb = $stmt->rowCount();
		
		$score = round($score/$totalProb);
		return $score;
	}

	function topTeams () {
		$query = "SELECT
					id, title, rank, score 
				FROM
					team
				ORDER BY 
					rank ASC
				LIMIT 0, 10";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['link'] = $this->tmLink.'/'.$row['id'];
			$this->topTeams[] = $row;
		}

		return $stmt;
	}
	

	function readTopics ($all = false, $or = '', $page, $from_record_num, $records_per_page) {
        $lim = $con = '';
        if ($from_record_num) $lim = "LIMIT
					{$from_record_num}, {$records_per_page}";
		if ($all == false) $con = "WHERE 
					fid = ?";
		if (!$or) $order = "last_post DESC, modified DESC, created DESC";
		else $order = $or;

		$query = "SELECT
					id,type,link,title,uid,fid,views,replies,created,last_post
				FROM
					topic
				{$con}
				ORDER BY {$order}
				{$lim}";

		$stmt = $this->conn->prepare( $query );
		if ($all == false) $stmt->bindParam(1, $this->fid);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['posts'] = $row['replies'] + 1;
			$row['link'] = $this->fLink.'/'.$row['link'];
			if (!$or) $row['link'] .= '#'.$row['posts'];
			$row['author'] = $this->getUserInfo($row['uid']);
			$this->id = $row['id'];
			$this->fid = $row['fid'];
/*			if ($row['replies'] > 0) $row['lastpost'] = $this->getLastPost($row['id']);
			else $row['lastpost'] = $row;
			$row['cat'] = $this->getForum($row['fid']);
*/			if ($all == false) $this->topicsList[$row['type']][] = $row;
			else $this->topicsList[] = $row;
		}

		return $stmt;
	}
}
