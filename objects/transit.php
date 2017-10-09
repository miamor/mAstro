<?php
class Transit extends Config {

	// database connection and table name
//	private $conn;
	private $table_name = "transit";

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

	function createChart ($valAr) {
		global $config;
		$astro_data_id = $valAr['aid'];
		
		$strAr = $strAAr = $kAr = $vAr = array();
		foreach ($valAr as $vk => $vv) {
			if ($vk != 'aid') {
				$strAr[] = "{$vk} = ?";
				$dis[] = "`{$vk}` = '{$vv}'";
				if ($vk != 'auid') $strAAr[] = "{$vk} = ?";
			}
			$vAr[] = $vv;
			$kAr[] = $vk;
		}
		$strCommas = implode(', ', $strAr);
		$strCommasA = implode(', ', $strAAr);
		$strAnd = implode(' AND ', $strAr);
		$strd = implode(', ', $dis);
		
		if (!$astro_data_id) { // if not $astro_data_id, create astro_data then use it
			// count astro_data of this username to set n
			$adstmt = $this->conn->prepare("SELECT id FROM astro_data WHERE uid = ?");
			$adstmt->bindParam(1, $this->u);
			$adstmt->execute();
			$n = $adstmt->rowCount() + 1;
			// insert
			$query = "INSERT INTO astro_data SET n = ?, {$strCommasA}";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(1, $n);
			for ($i = 2; $i < count($vAr); $i++) $stmt->bindParam($i, $vAr[$i]);
			$stmt->execute();
		}

		// check if the chart is already available
		if ($astro_data_id) {
			$query = "SELECT * FROM " . $this->table_name . " WHERE aid = ? LIMIT 0,1";	
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(1, $astro_data_id);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			// if available, access it
			if ($row['id']) { 
				$this->id = $row['id'];
				$this->link = $row['link'] = $this->cLink.'/'.$row['uname'].'/'.$row['n'];
				$row['stt'] = (int)$row['stt'];
				$this->author = $row['author'] = $row['au'] = $row['cOwn'] = $config->me;
				$cIn = $row;
				return $cIn;
			}
		}

		// if not, create new chart

		// count chart rows of this username to set n
		$adstmt = $this->conn->prepare("SELECT id FROM " . $this->table_name . " WHERE uid = ".$this->u);
		$adstmt->execute();
		$nc = $adstmt->rowCount() + 1;
		// insert into table
		$query = "INSERT INTO " . $this->table_name . " SET n = ?, {$strCommas}";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $nc);
		for ($i = 1; $i < count($vAr); $i++) $stmt->bindParam($i+1, $vAr[$i]);

		if ($stmt->execute()) {
			$ar = array('link' => $this->tLink.'/'.$valAr['uname'].'/'.$nc);
			return $ar;
		} else return false;
		
	}

	function showForm () {
		global $lang, $page, $_COOKIE;
		//$page = $this->page;
		$dList = $this->getMyAstroData();
		$total_dList = count($dList);
		$dOList = $this->getOtherAstroData();
		if ($total_dList <= 0) echo '<div class="alerts alert-warning">You have no mAstro data in database.<br/>We highly recommend you save at least one data. <a>Read more</a></div>';
		if ($total_dList > 0 || count($dOList) > 0) { ?>
	<div class="form-group apply-data">
		<div class="col-lg-5 no-padding control-label"><? echo $lang['Apply an available mAstro data'] ?></div>
		<div class="col-lg-7 no-padding-right">
			<select class="chosen-select form-control" name="aid" id="apply_data">
				<optgroup label="My mAstro data">
		<? 	foreach ($dList as $dK => $dO) {
				if ($dK == 0) $seclected = ' selected';
				else $seclected = '';
				echo '<option'.$seclected.' value="'.$dO['id'].'">'.$dO['name'].'</option>';
			} ?>
				</optgroup>
				<optgroup label="Other available mAstro data">
		<? 	foreach ($dOList as $dK => $dO) {
				echo '<option value="'.$dO['id'].'">'.$dO['name'].' - @'.$dO['uname'].'</option>';
			} ?>
				</optgroup>
			</select>
		</div>
		<div class="clearfix"></div>
	</div>
	<? 	} ?>
	<div class="txt-with-line">
		<span class="txt generate-new-button"><? echo $lang['Or generate new'] ?> <span class="fa fa-caret-down"></span></span>
	</div>
	<div class="generate-data <? if ($this->u && $total_dList > 0) echo 'hide' ?>">
		<? include MAIN_PATH.'/pages/ini/iniform.php' ?>
	</div>	
<? }

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

	function readAll ($u, $or = '', $page = '', $from_record_num = '', $records_per_page = '') {
		$lim = $con = '';
		if ($from_record_num) $lim = "LIMIT
					{$from_record_num}, {$records_per_page}";
		if (!$or) $order = "last_updated DESC, time DESC";
		else $order = $or;

		if ($u != -1) $query = "SELECT
					id,uid,aid,ucreate,n,uname,name,gender,birthday,birthhour,stt,views,thumb,time,last_updated,start
				FROM " . $this->table_name . " WHERE uid = ? ORDER BY {$order} {$lim}";
		else $query = "SELECT
					id,uid,aid,ucreate,n,uname,name,gender,birthday,birthhour,stt,views,thumb,time,last_updated,start
				FROM " . $this->table_name . " WHERE uid != ? ORDER BY {$order} {$lim}";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $u);
		$stmt->execute();
		$num = 0;
		$cList = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['link'] = $this->tLink.'/'.$row['uname'].'/'.$row['n'];
			$row['author'] = $this->getUserInfo($row['uid']);
			$this->id = $row['id'];
			$row['stt'] = (int)$row['stt'];
			$stt = $row['stt'];
			if ($u != -1 || 
				( $row['uid'] != $this->u &&
					( $stt === -1 || ( $stt === 1 && in_array($this->u, $row['author']['friends'])) )
				)
			   ) 
				{
					$cList[] = $row;
				}
			$num++;
		}
		return $cList;
	}

	public function countAll () {
		$query = "SELECT id FROM " . $this->table_name . "";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		$num = $stmt->rowCount();
		return $num;
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
		$this->views = $row['views'];
		$this->uid = $row['uid'];
		$this->link = $row['link'] = $this->tLink.'/'.$row['uname'].'/'.$row['n'];
		$row['stt'] = (int)$row['stt'];
		$this->author = $row['author'] = $row['au'] = $row['cOwn'] = $this->getUserInfo($this->uid);

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
	
	function getTranslators () {
		$query = "SELECT id,username,first_name,last_name FROM members";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->u);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($row['type'] == 'translator') $this->tList[1][] = $row;
			else $this->tList[0][] = $row;
			$num++;
		}
		return $stmt;
	}
	
	function echoRate () {
		$totalRates = $averageRate = $numRates = 0;
		$ratesL = $this->rList;
		foreach ($ratesL as $rates) {
			$numRates++;
			$totalRate++;
			$averageRate = $averageRate + $rates['rate'];
			$totalRates = $totalRates + $rates['rate']*100/5;
		}
		
		if ($numRates > 0) {
			$percentRate = number_format((100*($averageRate/$numRates)/5), 2);
			$averageRate = $cGrade = number_format(($averageRate/$numRates), 1);
		} else $percentRate = $cGrade = $averageRate = 0;
		
		$totalRate = count($ratesL);
		
		if (($averageRate - floor($averageRate)) > 0.5) $averageRate = floor($averageRate) + 0.5;
		else $averageRate = floor($averageRate);
		if ($cGrade == 0) $cGrade = '0.0';

		echo '		<div class="chart-grade rate-grade">
			'.$cGrade.'
		</div>
		<div class="chart-star star-info">';
			for ($z = 1; $z <= 5; $z++) { ?>
				<span class="fa fa-star<? if ($averageRate == $z - 0.5) echo '-half'; else if ($averageRate < $z) echo '-o' ?>"></span>
			<? }
			echo '<div class="gensmall rl-review-count">(<b>'.$totalRate.'</b>) <a>reviews</a></div>
		</div>';
	}
	function getRates () {
		$query = "SELECT * FROM
					".$this->tb."_ratings
				WHERE
					iid = ? 
				ORDER BY `rate` DESC, LENGTH(likes) DESC";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		$stmt->execute();
		$this->rList = array();
		$num = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['au'] = $this->getUserInfo($row['uid']);
			$this->rList[] = $row;
			$num++;
		}
		return $stmt;
	}
	function checkMyRate () {
		$query = "SELECT id FROM ".$this->tb."_ratings WHERE `iid` = ? AND `uid` = ? ";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->bindParam(2, $this->u);
		$stmt->execute();
		$num = $stmt->rowCount();
		return $num;
	}
	function rate () {
		parent::getTimestamp();

		$query = "INSERT INTO " . $this->table_name . "_ratings SET
					uid = ?, iid = ?, title = ?, content= ?, rate = ?, time = ?";

		$stmt = $this->conn->prepare($query);

		$this->title = content($this->title);
		$this->content = content($this->content);
		$this->timestamp = htmlspecialchars(strip_tags($this->timestamp));

		// bind values
		$stmt->bindParam(1, $this->u);
		$stmt->bindParam(2, $this->id);
		$stmt->bindParam(3, $this->title);
		$stmt->bindParam(4, $this->content);
		$stmt->bindParam(5, $this->star);
		$stmt->bindParam(6, $this->timestamp);

		if ($stmt->execute()) return true;
		else return false;
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
	function changeStt () {
		$query = "UPDATE " . $this->table_name . " SET stt = :stt WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		// bind parameters
		$stmt->bindParam(':stt', $this->stt);
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
