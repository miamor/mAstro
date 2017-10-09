http://www.geonames.org/export/
namecheap
<?
$string = "this is my lower sting";
$str = preg_replace('/^(.*)/', 'strtoupper(\\1)', $string);
echo $str.'~~~~';

/*function check ($haystack, $needle) {
//	return strlen(strstr($string, $word)); // Find $word in $string
	return substr_count($haystack, $needle); // Find $word in $string
}
class getRecord {
	private function _open_connection() {
		$host = "localhost";
		$db_name = "astro";
		$username = "root";
		$password = "";
		$con = mysqli_connect($host, $username, $password);
		if (!$con) die('Error Connection:' . mysqli_error());
		$db_select = mysqli_select_db($db_name, $con);
		if (!$db_select) die('Error Selection: ' . mysqli_error());
		return $con;
	}
	
	private function _confirm_query($result) {
		if(!$result) die('Error Query: ' . mysqli_error());
		return $result;
	}

	function countRecord ($table, $condition) {
		global $mysqli, $con;
		if ($table == '') return false;

		if (!$condition) $getResult = $mysqli->query("SELECT * FROM `$table`");
		else $getResult = $mysqli->query("SELECT * FROM `$table` WHERE $condition");

		if ($getResult === FALSE) die(mysqli_error());
		else return mysqli_num_rows($getResult);
	}

	public function GET ($table, $condition, $display = '', $order = '') {
		global $mysqli, $con, $pattern;
		$mysqli->set_charset('utf8');
		$pattern = str_replace('/', '', $pattern);
		$query = "SELECT COUNT(id) FROM `$table`";

		if (check($table, '^') > 0) {
			$tableSpl = explode('^', $table);
			$table = $tableSpl[0];
			$col = $tableSpl[1];
		} else $col = '*';

		$miis = $display;
		if (check($display, '^') > 0) {
			$display = explode('^', $display);
			$display = $display[1];
		}
		if (!$condition) {
			if (check($display, '%') > 0) {
				$dis = explode('%', $display);
				if ($order) $sql = "SELECT $col FROM `$table` ORDER BY $order LIMIT ".$dis[1];
				else $sql = "SELECT $col FROM `$table` ORDER BY `id` DESC LIMIT ".$dis[1];
			} else if ($display == 0 || !$display) {
				if ($order) $sql = "SELECT $col FROM `$table` ORDER BY $order";
				else $sql = "SELECT $col FROM `$table` ORDER BY `id` DESC";
			} else {
				if ($order) $sql = "SELECT $col FROM `$table` ORDER BY $order LIMIT $start, $display";
				else $sql = "SELECT $col FROM `$table` ORDER BY `id` DESC LIMIT $start, $display";
			}
		} else {
			if (check($display, '%') > 0) {
				$dis = explode('%', $display);
				if ($order) $sql = "SELECT $col FROM `$table` WHERE $condition ORDER BY $order LIMIT ".$dis[1];
				else $sql = "SELECT $col FROM `$table` WHERE $condition ORDER BY `id` DESC LIMIT ".$dis[1];
			} else if ($display == 0 || !$display) {
				if ($order) $sql = "SELECT $col FROM `$table` WHERE $condition ORDER BY $order";
				else $sql = "SELECT $col FROM `$table` WHERE $condition ORDER BY `id` DESC";
			} else {
				if ($order) $sql = "SELECT $col FROM `$table` WHERE $condition ORDER BY $order LIMIT $start, $display";
				else $sql = "SELECT $col FROM `$table` WHERE $condition ORDER BY `id` DESC LIMIT $start, $display";
			}
		}

//		$db = $this -> _open_connection();
		$result = $mysqli->query($sql);
		$Array = array();
		
		if ($this -> _confirm_query($result)) {
			while ($r = mysqli_fetch_array($result)) {
				$row = array();
				foreach ($r as $k=>$v){
					$row[$k] = $v;
				}
				array_push($Array, $row);
				unset($row);
			}
		}
		return $Array;
	}
}

$getRecord = new getRecord();

function changeValue ($table, $condition, $value) {
	global $mysqli, $con;
	if ($table == '' || countRecord($table, $condition) <= 0) return false;
	if ($condition == '') $result = $mysqli->query("UPDATE `$table` SET $value");
	else $result = $mysqli->query("UPDATE `$table` SET $value WHERE $condition");
	if ($result === FALSE) die(mysqli_error());
	else return $result;
}

function insert ($tb, $fields, $values) {
	global $mysqli, $con;
	return $mysqli->query("INSERT INTO $tb ($fields) VALUES ($values)");
}
function delete ($tb, $condition) {
	global $mysqli, $con;
	return $mysqli->query("DELETE FROM $tb WHERE $condition");
}

function getRecord ($table, $condition, $first = 0) {
	global $mysqli, $con;
	if ($table == '') return false;
	if (check($table, '^') > 0) {
		$tableSpl = explode('^', $table);
		$table = $tableSpl[0];
		$col = $tableSpl[1];
	} else $col = '*';
	if ($condition == '' || !$condition) $sql = "SELECT $col FROM `$table` ORDER BY `id` DESC";
	else $sql = "SELECT $col FROM `$table` WHERE $condition ORDER BY `id` DESC";
	if ($first == 1) {
		if ($condition == '' || !$condition) $sql = "SELECT $col FROM `$table` ORDER BY `id` ASC";
		else $sql = "SELECT $col FROM `$table` WHERE $condition ORDER BY `id` ASC";
	}
	$getResult = $mysqli->query($sql, $con);
	if ($getResult === FALSE) die(mysqli_error());
	else return mysqli_fetch_array($getResult);
}

function countRecord ($table, $condition) {
	global $mysqli, $con;
	if ($table == '') return false;
	if (!$condition) $getResult = $mysqli->query("SELECT `id` FROM `$table`");
	else $getResult = $mysqli->query("SELECT `id` FROM `$table` WHERE $condition");
	if ($getResult === FALSE) die(mysqli_error());
	else return mysqli_num_rows($getResult);
}

	// connect to database
	$host = "localhost";
	$db_name = "astro";
	$username = "root";
	$password = "";
	$mysqli = new mysqli($host, $username, $password, $db_name);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
	$mysqli->set_charset("utf8");

// change to transit
$rows = $getRecord->GET('data', "`id` >= 1152 AND `id` <= 1218");
foreach ($rows as $row) {
	$cont = str_replace(array('<br />', "\n", "'", '    '), array('', '', "\'", ' '), $row['content']);
	echo "<b>{$row['code']}</b><br/>{$cont}<hr/>";
	changeValue('data', "`id` = '{$row['id']}' ", "`content` = '{$cont}' ");
}
/*
if ($select->num_rows < 1 && $content != 'Planet Aspects/')
	$mysqli->query("INSERT INTO `data` (`sid`, `lang`, `code`, `content`) VALUES ('7', 'us', '{$code}', '{$content}') ");
*/
