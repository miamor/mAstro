<? 
class mData extends Config {

	// database connection and table name
	private $table_name = "astro_data";

	public $id;

	public function __construct() {
		parent::__construct();
	}

	function create ($valAr) {
		global $config;
		$astro_data_id = $valAr['n'];
		
		$strAr = $strAAr = $kAr = $vAr = array();
		foreach ($valAr as $vk => $vv) {
			$strAr[] = "{$vk} = ?";
			if ($vk != 'n') $strAAr[] = "{$vk} = ?";
			$vAr[] = $vv;
			$kAr[] = $vk;
		}
		$strCommas = implode(', ', $strAr);
		$strCommasA = implode(', ', $strAAr);
		
		if ($astro_data_id && $astro_data_id != null) { // update an mAstro_data
			$query = "UPDATE astro_data SET {$strCommasA} WHERE uname = ? AND n = ?";
			$stmt = $this->conn->prepare($query);
			$k = count($vAr); // 17
			for ($i = 1; $i < $k; $i++) $stmt->bindParam($i, $vAr[$i]);
			$stmt->bindParam($k, $valAr['uname']);
			$stmt->bindParam($k+1, $valAr['n']);
			
			if ($stmt->execute()) 
				return array('link' => MAIN_URL.'/profile?mode=mastro_data&m='.$valAr['n']);
			else return false;
		} else { // if not $astro_data_id, create new astro_data 
			// count astro_data of this username to set n
			$adstmt = $this->conn->prepare("SELECT id FROM astro_data WHERE uid = ?");
			$adstmt->bindParam(1, $this->u);
			$adstmt->execute();
			$n = $adstmt->rowCount() + 1;
			// insert
			$query = "INSERT INTO astro_data SET n = ?, {$strCommasA}";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(1, $n);
			for ($i = 1; $i < count($vAr); $i++) $stmt->bindParam($i+1, $vAr[$i]);
			
			if ($stmt->execute()) {
				$ar = array('link' => MAIN_URL.'/profile?mode=mastro_data&m='.$n);
				return $ar;
			} else return false;
		}
		
		return false;
	}

	function readAll ($u = 0, $or = '', $page = '', $from_record_num = '', $records_per_page = '') {
		$lim = $con = '';
		if ($from_record_num) $lim = "LIMIT
					{$from_record_num}, {$records_per_page}";
		if (!$or) $order = "last_updated DESC, time DESC";
		else $order = $or;

		if ($u == 0) $u = $this->u;
			
		if ($u == -1) $query = "SELECT * FROM " . $this->table_name . " ORDER BY {$order} {$lim}";
		else $query = "SELECT * FROM " . $this->table_name . " WHERE uid = ? ORDER BY {$order} {$lim}";

		$stmt = $this->conn->prepare( $query );
		if ($u != -1) $stmt->bindParam(1, $u);
		$stmt->execute();
		$num = 0;
		$cList = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['link'] = MAIN_URL.'/profile?mode=mastro_data&m='.$row['n'];
			$row['author'] = $this->getUserInfo($row['uid']);
			$this->id = $row['id'];
			$row['stt'] = (int)$row['stt'];
			$stt = $row['stt'];
			
			$cList[] = $row;
			
			$num++;
		}

		return $cList;
	}

	function readOne () {
		$query = "SELECT * FROM
					" . $this->table_name . "
				WHERE
					uname = ? AND n = ?
				LIMIT
					0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->uname);
		$stmt->bindParam(2, $this->n);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
//		$row['content'] = content($row['content']);
		$this->id = $row['id'];
		$this->uid = $row['uid'];
		$this->link = $row['link'] = MAIN_URL.'/profile?mode=mastro_data&m='.$row['n'];
		$row['stt'] = (int)$row['stt'];
		$this->author = $row['author'] = $row['au'] = $row['cOwn'] = $this->getUserInfo($this->uid);

		return $row;
	}
	
}