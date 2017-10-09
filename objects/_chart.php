<?php
class Chart extends Config {

	// database connection and table name
//	private $conn;
	private $table_name = "chart";

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

	function readAll ($u, $or = '', $page, $from_record_num, $records_per_page) {
        $lim = $con = '';
        if ($from_record_num) $lim = "LIMIT
					{$from_record_num}, {$records_per_page}";
		if (!$or) $order = "last_updated DESC, time DESC";
		else $order = $or;

		$query = "SELECT
					id,uid,aid,ucreate,n,uname,name,gender,birthday,birthhour,stt,views,thumb,time,last_updated
				FROM
					" . $this->table_name . "
				WHERE
					uid = ?
				ORDER BY {$order}
				{$lim}";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $u);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['posts'] = $row['replies'] + 1;
			$row['link'] = $this->cLink.'/'.$row['uname'].'/'.$row['n'];
			$row['author'] = $this->getUserInfo($row['uid']);
			$this->id = $row['id'];
/*			if ($row['replies'] > 0) $row['lastpost'] = $this->getLastPost($row['id']);
			else $row['lastpost'] = $row;
*/			$this->cList[] = $row;
			$num++;
		}

		return $stmt;
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
		$this->title = $row['title'];
		$this->code = $row['code'];
		$this->content = htmlentities($row['content']);
		$this->cid = $row['cid'];
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
	
	function getZodiacs ($sunSign) {
		$query = "SELECT * FROM zodiac WHERE
					sign = ? AND vertex = 0
				ORDER BY LENGTH(likes) DESC, LENGTH(dislikes) ASC";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $sunSign);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
			$this->zSigns[] = $row;
		return $stmt;
	}
	function getZodiac ($sunSign, $segment) {
		$query = "SELECT * FROM zodiac WHERE
					sign = ? AND segment = ?
				ORDER BY LENGTH(likes) DESC, LENGTH(dislikes) ASC";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $sunSign);
		$stmt->bindParam(2, $segment);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
		
	function getData ($code, $lg, $sid) {
		if ($sid) $query = "SELECT * FROM data WHERE
					code = ? AND lang = ? AND sid = ?
				ORDER BY LENGTH(likes) DESC, LENGTH(dislikes) ASC 
				LIMIT 0,1";
		else $query = "SELECT * FROM data WHERE
					code = ? AND lang = ? 
				ORDER BY LENGTH(likes) DESC, LENGTH(dislikes) ASC
				LIMIT 0,1";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $code);
		$stmt->bindParam(2, $lg);
		if ($sid) $stmt->bindParam(3, $sid);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	function getSource ($sourceID) {
		$query = "SELECT * FROM source WHERE id = ? LIMIT 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $sourceID);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	function getSources ($lg, $order) {
		if ($order) $order = "ORDER BY {$order}";
		else $order = '';
		$query = "SELECT * FROM source WHERE lang = ? {$order}";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $lg);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$this->sList[] = $row;
			$num++;
		}
		return $stmt;
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
	
	function countTranslate ($did) {
		$query = "SELECT id FROM data WHERE `translate` = '1' AND `did` = ? ";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $did);
		$stmt->execute();
		$num = $stmt->rowCount();
		return $num;
	}
	
	function echoRate () {
		$totalRates = $averageRate = $numRates = 0;
//		$rates = $getRecord -> GET($this->tb.'_ratings', "`iid` = '{$this->id}' ", '', '');
//		$numRates = count($rates);
		$query = "SELECT * FROM ".$this->tb."_ratings WHERE
					iid = ?
				ORDER BY LENGTH(likes) DESC, LENGTH(dislikes) ASC";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$ratesL[] = $row;
			$numRates++;
			$totalRate++;
		}
		foreach ($ratesL as $rates) {
			$averageRate = $averageRate + $rates['rate'];
			$totalRates = $totalRates + $rates['rate']*100/5;
		}
		$percentRate = number_format((100*($averageRate/$numRates)/5), 2);
		$averageRate = $cGrade = number_format(($averageRate/$numRates), 1);
		
		$totalRate = count($ratesL);
		
		if (($averageRate - floor($averageRate)) > 0.5) $averageRate = floor($averageRate) + 0.5;
		else $averageRate = floor($averageRate);
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
					iid = ? AND show = 1
				ORDER BY `rate` DESC, LENGTH(likes) DESC, LENGTH(content) DESC";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

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
	
	function update () {

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
	function delete () {

		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
		
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);

		if ($result = $stmt->execute()) return true;
		else return false;
	}

}


class Validate_fields {
	var $fields = array();
	var $messages = array();
	var $check_4html = false;
	var $language;
	var $time_stamp;
	var $month;
	var $day;
	var $year;

	function Validate_fields() {
		$this->language = "us";
		$this->create_msg();
	}

	function validation() {
		$status = 0;
		foreach ($this->fields as $key => $val) {
			$name = $val['name'];
			$length = $val['length'];
			$required = $val['required'];
			$num_decimals = $val['decimals'];
			$ver = $val['version'];
			switch ($val['type']) {
				case "email":
				if (!$this->check_email($name, $key, $required)) {
					$status++;
				}
				break;
				case "number":
				if (!$this->check_num_val($name, $key, $length, $required)) {
					$status++;
				}
				break;
				case "decimal":
				if (!$this->check_decimal($name, $key, $num_decimals, $required)) {
					$status++;
				}
				break;
				case "date":
				if (!$this->check_date($name, $key, $ver, $required)) {
					$status++;
				}
				break;
				case "url":
				if (!$this->check_url($name, $key, $required)) {
					$status++;
				}
				break;
				case "text":
				if (!$this->check_text($name, $key, $length, $required)) {
					$status++;
				}
				break;
			}
			if ($this->check_4html) {
				if (!$this->check_html_tags($name, $key)) {
					$status++;
				}
			}
		}
		if ($status == 0) return true;
		else {
			$this->messages[] = $this->error_text(0);
			return false;
		}
	}

	function add_text_field($name, $val, $type = "text", $required = "y", $length = 0) {
		$this->fields[$name]['name'] = $val;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['required'] = $required;
		$this->fields[$name]['length'] = $length;
	}

	function add_num_field($name, $val, $type = "number", $required = "y", $decimals = 0, $length = 0) {
		$this->fields[$name]['name'] = $val;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['required'] = $required;
		$this->fields[$name]['decimals'] = $decimals;
		$this->fields[$name]['length'] = $length;
	}

	function add_link_field($name, $val, $type = "email", $required = "y") {
		$this->fields[$name]['name'] = $val;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['required'] = $required;
	}

	function add_date_field($name, $val, $type = "date", $version = "us", $required = "y") {
		$this->fields[$name]['name'] = $val;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['version'] = $version;
		$this->fields[$name]['required'] = $required;
	}

	function check_url($url_val, $field, $req = "y") {
		if ($url_val == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else return true;
		} else {
			if ($req == "y") {
				$url_pattern = "http\:\/\/[[:alnum:]\-\.]+(\.[[:alpha:]]{2,4})+";
				$url_pattern .= "(\/[\w\-]+)*"; // folders like /val_1/45/
				$url_pattern .= "((\/[\w\-\.]+\.[[:alnum:]]{2,4})?"; // filename like index.html
				$url_pattern .= "|"; // end with filename or ?
				$url_pattern .= "\/?)"; // trailing slash or not
				$error_count = 0;
				if (strpos($url_val, "?")) {
					$url_parts = explode("?", $url_val);
					if (!preg_match("/^".$url_pattern."$/", $url_parts[0])) 
						$error_count++;
					if (!preg_match("/^(&?[\w\-]+=\w*)+$/", $url_parts[1])) 
						$error_count++;
				} else {
					if (!preg_match("/^".$url_pattern."$/", $url_val)) 
						$error_count++;
				}
				if ($error_count > 0) {
					$this->messages[] = $this->error_text(14, $field);
					return false;
				} else return true;
			} else return true;
		}
	}

	function check_num_val($num_val, $field, $num_len = 0, $req = "n") {
		if ($num_val == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else return true;
		} else {
			$pattern = ($num_len == 0) ? "/^\-?[0-9]*$/" : "/^\-?[0-9]{0,".$num_len."}$/";
			if (preg_match($pattern, $num_val)) 
				return true;
			else {
				$this->messages[] = $this->error_text(12, $field);
				return false;
			}
		}
	}

	function check_text($text_val, $field, $text_len = 0, $req = "y") {
		if ($text_val == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else return true;
		} else {
			if ($text_len > 0) {
				if (strlen($text_val) > $text_len) {
					$this->messages[] = $this->error_text(13, $field);
					return false;
				} else return true;
			} else return true;
		}
	}

	function check_decimal($dec_val, $field, $decimals = 2, $req = "n") {
		if ($dec_val == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else return true;
		} else {
			$pattern = "/^[-]*[0-9][0-9]*\.[0-9]{".$decimals."}$/";
			if (preg_match($pattern, $dec_val)) 
				return true;
			else {
				$this->messages[] = $this->error_text(12, $field);
				return false;
			}
		}
	}

	function check_date($date, $field, $version = "us", $req = "n") {
		if ($date == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else return true;
		} else {
			if ($version == "us") {
				// european = $pattern = "/^(0[1-9]|[1-2][0-9]|3[0-1])[-](0[1-9]|1[0-2])[-](19|20)[0-9]{2}$/";
				//format = mm-dd-yyyy
				$pattern = "/^(0[1-9]|1[0-2])[-](0[1-9]|[1-2][0-9]|3[0-1])[-](19|20)[0-9]{2}$/";
			} else {
				//format = dd-mm-yyyy
				$pattern = "/^(19|20)[0-9]{2}[-](0[1-9]|1[0-2])[-](0[1-9]|[1-2][0-9]|3[0-1])$/";
			}
			if (preg_match($pattern, $date)) 
				return true;
			else {
				if ($version == "us") {
					// european = $pattern = "/^(0[1-9]|[1-2][0-9]|3[0-1])[-](0[1-9]|1[0-2])[-](19|20)[0-9]{2}$/";
					//format = mm/dd/yyyy
					$pattern = "/^(0[1-9]|1[0-2])[\/](0[1-9]|[1-2][0-9]|3[0-1])[\/](19|20)[0-9]{2}$/";
				} else {
					//format = dd/mm/yyyy
					$pattern = "/^(19|20)[0-9]{2}[\/](0[1-9]|1[0-2])[\/](0[1-9]|[1-2][0-9]|3[0-1])$/";
				}
				if (preg_match($pattern, $date)) 
					return true;
				else {
					//added by Allen on 18 Jan 2006
					//format = yyyy-mm-dd
					$time_stamp = strtotime($date); //convert user-entered date into a UNIX timestamp
					$month = date('m', $time_stamp);//get month, day, and year of this entered date
					$day = date('d', $time_stamp);
					$year = date('Y', $time_stamp);

					//debug only
					//echo $date . " is timestamp " . $time_stamp . " and that equals " . $month . "/" . $day . "/" . $year . "<br><br>";

					//is entered date a valid date?
					if (($time_stamp < 0) or (!checkdate($month,$day,$year)) or ($this->mid($date, 5, 1) != "-") or ($this->mid($date, 8, 1) != "-")) {
						$this->messages[] = $this->error_text(10, $field);
						return false;
					} else {
						//debug
						//echo $month . "" . $day;
						if (($month > 12) OR ($month < 1) OR ($day > 31) OR ($day < 1) OR $month != $this->mid($date, 6, 2) OR $day != $this->mid($date, 9, 2)) {
							$this->messages[] = $this->error_text(10, $field);
							return false;
						}
						else return true;
					}
				}
			}
		}
	}

	function check_email($mail_address, $field, $req = "y") {
		if ($mail_address == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else return true;
		} else {
			if (preg_match("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,4}$/i", strtolower($mail_address))) 
				return true;
			else {
				$this->messages[] = $this->error_text(11, $field);
				return false;
			}
		}
	}

	function check_html_tags($value, $field) {
		if (preg_match("/[<](\w+)((\s+)(\w+)[=]((\w+)|(\"\.\")|('\.')))*[>]/", $value)) {
			$this->messages[] = $this->error_text(15, $field);
			return false;
		} else return true;
	}

	function create_msg() {
		$the_msg = "";
		asort($this->messages);
		reset($this->messages);
		foreach ($this->messages as $value) 
			$the_msg .= $value."<br>\n";
		return $the_msg;
	}

	function mid($midstring, $midstart, $midlength) {
	return(substr($midstring, $midstart-1, $midlength));
	}

	function error_text($num, $fieldname = "") {
		$fieldname = str_replace("_", " ", $fieldname);
		switch ($this->language) {
			case "dk":
			break;
			default:
			$msg[0] = "<b>Please correct the following error(s) in the listed fields:</b><br>";
			$msg[1] = "the " . $fieldname . " field is empty.";
			$msg[10] = "the date in the " . $fieldname . " field is invalid.";
			$msg[11] = "the " . $fieldname . " is invalid.";
			$msg[12] = "the value in the " . $fieldname . " field is invalid.";
			$msg[13] = "the entry in the " . $fieldname . " field is too long.";
			$msg[14] = "the URL in the " . $fieldname . " field is invalid.";
			$msg[15] = "there is HTML code in the " . $fieldname . " field - this is not allowed.";
		}
		return $msg[$num];
	}
}


function astroAr ($code) {
	global $chart, $lg, $sSelectedID;
//	if ($sSelectedID) $cond = " AND `sid` = '{$sSelectedID}' ";
//	$astro = $getRecord -> GET('data', "`code` = '{$code}' AND `lang` = '{$lg}' {$cond}", '', 'LENGTH(likes) DESC, LENGTH(dislikes) ASC, `time` DESC');
	$astro = $chart->getData($code, $lg, $sSelectedID);
//	$astro = $chart->astroList;
//	foreach ($astro as $at) $at['content'] = ($at[$lang]);
	return $astro;
}
function astro ($code) {
	global $chart, $lg, $sLink, $sSelectedID;
	$astro = astroAr($code);
	$astro['content'] = nl2br($astro['content']);
	$aIn = $astro;
	$sid = $aIn['sid'];
	$sIn = $chart->getSource($sid);
//	$sIn = getRecord('source^url,title,link,avatar,type', "`id` = '{$sid}' ");
	if ($aIn['likes'] || $aIn['dislikes'] || $aIn['sid'] != 0 || $aIn['uid'] != 0) {
		$aIn['content'] .= '<br></div><div class="chart-paragraph-tool"><div class="chart-paragraph-sta col-lg-7">'.staReport($code).'</div>';
		if ($sIn['title']) $aIn['content'] .= '<div class="chart-paragraph-source col-lg-5"><a class="s-info" href="'.$sLink.'/'.$sIn['link'].'" target="_blank"><img title="'.$sIn['title'].'" src="'.$sIn['avatar'].'" class="s-info-thumb"/> <div class="s-info-title">'.$sIn['title'].'</div></a><div class="time"><span class="fa fa-clock-o"></span> '.$aIn['time'].'</div><div class="clearfix"></div></div>';
		$aIn['content'] .= '<div class="clearfix"></div>';
	}
	return $aIn;
}

function _astro ($code) {
	global $chart, $lg, $sLink, $sSelectedID;
	$astro = astroAr($code);
	$astro['content'] = nl2br($astro['content']);
	return $astro;
}
function staReport ($code) {
	global $config, $lg, $sLink, $u, $time;
	$u = $config->u;
	$astro = astroAr($code);
	$aIn = $astro;
	$sFavAr = $pLikesAr = $pDislikesAr = array();
	if ($aIn['likes']) $sFavAr = $pLikesAr = explode(',', $aIn['likes']);
/*	if ($aIn['dislikes']) $pDislikesAr = explode(',', $aIn['dislikes']);
	$pLikes = count($pLikesAr);
	$pDislikes = count($pDislikesAr);
*/
	$sFs = 0;
	$sFu = array();
	$cont = '';
	if ($sFavAr) $sFav = count($sFavAr);
	else $sFav = 0;

	foreach ($sFavAr as $sFo) {
		if (/*checkFollow($sFo) &&*/ $sFo != $config->u && $sFs <= 2) {
			$sFs++;
			$sFu[] = $config->getUserInfo($sFo);
		}
	}
	$sFavLeft = $sFav - $sFs;

	if ($sFav > 0) {
		$cont .= '<div class="post-fav-list">';
		if (in_array($u, $sFavAr)) {
			$cont .= 'You';
			$sFavLeft--;
		}
	
		if ($sFavLeft > 0) {
			if (in_array($u, $sFavAr)) {
				if (count($sFu) > 0) $cont .= ', ';
				else $cont .= ' ';
			}
			foreach ($sFu as $sfk => $sfin) {
				$cont .= '<a href="'.$sfin['link'].'">'.$sfin['name'].'</a>';
				if ($sfk == $sFs - 1) $cont .= ' ';
				else if ($sfk < 2) $cont .= ', ';
				else $cont .= 'and ';
			}
			if (in_array($u, $sFavAr) || count($sFu) > 0) $cont .= ' and ';
			$cont .= '<a class="view-all-fav">'.$sFavLeft.' ';
			if (in_array($u, $sFavAr) || count($sFu) > 0) {
				$cont .= 'other'; if ($sFavLeft > 1) $cont .= 's';
			} else {
				if ($sFavLeft > 1) $cont .= 'people'; else $cont .= 'person';
			}
			$cont .= '</a>';
		} else {
			foreach ($sFu as $sfk => $sfin) {
				$cont .= '<a href="'.$sfin['link'].'">'.$sfin['name'].'</a>';
				if ($sfk == $sFs - 2) $cont .= ' and ';
				else if ($sfk < 1 && $sfk != $sFs - 1) $cont .= ', ';
				else $cont .= ' ';
			}
		}
		$cont .= ' liked this';
		$cont .= '</div>';
	}
	return $cont;
}

function countTrans ($did) {
	global $chart;
	return $chart->countTranslate($did);
//	return countRecord('data', "`code` = '{$code}' AND `translate` = '1' AND `did` = '{$did}' ", '', 'LENGTH(likes) DESC, LENGTH(dislikes) ASC');
}

function chartStt ($cIn, $type) {
	global $cAu, $cOwn, $u, $hour, $minute, $secs, $month, $day, $year, $longAr, $ew_txt, $latAr, $ns_txt, $percentRate, $averageRate, $totalRate, $cGrade;
	$cAu = $cOwn; ?>
<? }

