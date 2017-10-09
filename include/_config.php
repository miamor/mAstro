<?php
$__pattern = '/astro';

define('MAIN_PATH', './');
define('HOST_URL', '//localhost'.$__pattern);
define('MAIN_URL', 'http:'.HOST_URL);
define('ASSETS', MAIN_URL.'/assets');
define('CSS', ASSETS.'/dist/css');
define('JS', ASSETS.'/dist/js');
define('IMG', ASSETS.'/dist/img');
define('PLUGINS', ASSETS.'/plugins');
define('GG_API_KEY', 'AIzaSyA5xbqBF1tGx96z6-QLhGGmvqIQ5LUrt4s');
define('GG_CX_ID', '014962602028620469778:yf4br-mf6mk');
$__page = str_replace($__pattern.'/', '', $_SERVER['REQUEST_URI']);
define('__HOST', 'ubuntu');
//define('__HOST', 'window');
if (__HOST == 'window') define('MAIN_PATH_EXEC', 'E:/Devs/xampp/htdocs/astro/');
else if (__HOST == 'ubuntu') define('MAIN_PATH_EXEC', MAIN_PATH);
define('__ASTRO', MAIN_PATH.'/include/astro');
define('zBg', MAIN_URL.'/data/zodiac');
define('HTML2PDF', MAIN_PATH.'/lib/html2pdf');
$asLink = MAIN_URL.'/include/astro';
define('SWEPH', MAIN_PATH.'/sweph/');
define('SWETEST', 'swetest');

$lgAr = array(
	'us' => 'English (US)',
	'vn' => 'Tiếng Việt'
);
if (!$_SESSION['lang']) {
	$_SESSION['lang'] = key($lgAr);
}
$lg = $config->lang = $_SESSION['lang'];
require_once 'lang/'.$lg.'.php';

class Config {

	// specify your own database credentials
	private $host = "localhost";
	private $db_name = "astro";
	private $username = "root";
	private $password = "";
	protected $conn;
	public $u;
	public $request;
	public $JS;

	public function __construct () {
		$this->uLink = MAIN_URL.'/u';
		$this->cLink = MAIN_URL.'/chart'; // chart
		$this->tLink = MAIN_URL.'/transit'; // transit
		$this->rLink = MAIN_URL.'/relationship'; // transit
		$this->bLink = MAIN_URL.'/b'; // blog
		$this->hLink = MAIN_URL.'/help';
		$this->aLink = MAIN_URL.'/about';
		$this->JS = '';
		$this->u = $_SESSION['user_id'];
		$this->lang = $_SESSION['lang'];
		if ($this->getConnection()) return true;
		else return false;
	}

	// get the database connection
	public function getConnection() {

		$this->conn = null;

		try {
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->exec("set names utf8");
		} catch (PDOException $exception) {
			echo "Connection error: " . $exception->getMessage();
		}

		return $this->conn;
	}

	// used for the 'created' field when creating a product
	function getTimestamp(){
		date_default_timezone_set('Asia/Manila');
		$this->timestamp = date('Y-m-d H:i:s');
	}

	public function getUserInfo ($u = '', $fields = '') {
		if (!$u) $u = $this->u;
		$defaultFields = 'id,avatar,username,first_name,last_name,online,is_mod,is_admin';
		if (!$fields) $fields = $defaultFields;
		else $fields .= ','.$defaultFields;
		$query = "SELECT
					{$fields}
				FROM
					members
				WHERE
					id = ?
				LIMIT
					0,1";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $u);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$row['name'] = ($row['last_name']) ? ($row['last_name'].' '.$row['first_name']) : $row['first_name'];
		$row['link'] = $this->uLink.'/'.$row['username'];
		return $row;
	}

	function updateLang () {
//		$updateLang = changeValue('members', "`id` = '{$u}' ", "`lang` = '{$do}' ");
		$query = "UPDATE members SET lang = :lang WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		// bind parameters
		$stmt->bindParam(':lang', $this->lang);
		$stmt->bindParam(':id', $this->id);
		// execute the query
		if ($stmt->execute()) return true; 
		else return false;
	}

	function get ($char) {
		$request = $this->request;
		if ($request && check($request, $char) > 0) {
			$c = explode($char.'=', $request)[1];
			$c = explode('&', $c)[0];
			$request = str_replace("{$char}={$c}&", "", $request);
			return $c;
		}
		return null;
	}

	function addJS ($type, $link) {
		if ($type == 'dist') $type = 'dist/js';
		$this->JS .= ASSETS.'/'.$type.'/'.$link.'|';
	}
	
	function echoJS () {
		$exJS = explode('|', $this->JS);
		foreach ($exJS as $exjs) {
			if ($exjs) echo '	<script src="'.$exjs.'"></script>
	';
		}
	}

}


function timeFormat ($time) {
	global $lang;
	$timediff = time() - $time;
	$days = intval($timediff/86400);
	$months = intval($days/31);
	$years = intval($months/12);
	$daysLeft = $days - $months*31;
	$remain = $timediff%86400;
	$hours = intval($remain/3600);
	$remain = $remain%3600;
	$mins = intval($remain/60);
	$secs = $remain%60;
	if ($days > 1) $dtxt = $lang['days'];
	else $dtxt = $lang['day'];
	if ($hours > 1) $htxt = $lang['hrs'];
	else $htxt = $lang['hr'];
	if ($mins > 1) $mtxt = $lang['mins'];
	else $mtxt = $lang['min'];
	if ($secs > 1) $stxt = $lang['secs'];
	else $stxt = $lang['sec'];

	$diff = abs(time() - $time);

	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/(60*60*24));
	if ($months > 1) $mntxt = $lang['months'];
	else $mntxt = $lang['month'];

	if ($years > 1) $timestring = date('M, Y', $time);
	else if ($years == 1 || $months >= 4) $timestring = date('d, M', $time);
	else if ($months < 4 && $months > 0) $timestring = $lang['About']." {$months} {$mntxt} ago";
	else if ($days <= 30 && $days > 0) $timestring = $lang['About']." {$days} {$dtxt} ago";
	else if ($hours > 0) $timestring = "{$lang['About']} {$hours} {$htxt} {$lang['ago']}";
	else if ($mins > 0) $timestring = "{$lang['About']} {$mins} {$mtxt} {$lang['ago']}";
	else if ($secs >= 0) $timestring = "{$lang['About']} {$secs} {$stxt} {$lang['ago']}";
	else echo $lang['Just now'];
	return $timestring; 
}

function sanitize_output ($buffer) {
	$search = array(
		'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
		'/[^\S ]+\</s',  // strip whitespaces before tags, except space
		'/(\s)+/s'	   // shorten multiple whitespace sequences
	);
	$replace = array(
		'>',
		'<',
		'\\1'
	);
	$buffer = preg_replace($search, $replace, $buffer);
	return $buffer;
}

function trendCodeAn ($string) {
	$string = strtolower(vn_str_filter($string));
	$string = preg_replace('/[^A-Za-z0-9\-.|]/', ' ', $string);
	$string = str_replace(array('.', ' - '), array(' ', ' '), $string);
	$string = preg_replace('#\s+#', '.', $string);
	return $string;
}

function trendCode ($string) {
	$string = strtolower(vn_str_filter($string));
	$string = preg_replace('/[^A-Za-z0-9\-.]/', ' ', $string);
//	$string = str_replace('.', ' ', $string);
	$string = str_replace(array('.', ' - '), array(' ', ' '), $string);
	$string = preg_replace('#\s+#', '-', $string);
	return $string;
}
//echo trendCode('bÔok .... ....Campaign').'~~~~~~~~~~'.trendCode('Alice & You');

	function check ($haystack, $needle) {
	//	return strlen(strstr($string, $word)); // Find $word in $string
		return substr_count($haystack, $needle); // Find $word in $string
	}

	function checkURL ($word) {
		return check($_SERVER['REQUEST_URI'], $word);
	}

	function strip_comments ($str) {
		$str = preg_replace('!/\*.*?\*/!s', '', $str);
		$str = preg_replace('/\n\s*\n/', "\n", $str);
		$str = preg_replace('![ \t]*//.*[ \t]*[\r\n]!', '', $str);
		return $str;
	}

function str_insert_after ($str, $search, $insert) {
    $index = strpos($str, $search);
    if ($index === false) {
        return $str;
    }
    return substr_replace($str, $search.$insert, $index, strlen($search));
}

function str_insert_before ($str, $search, $insert) {
    $index = strpos($str, $search);
    if ($index === false) {
        return $str;
    }
    return substr_replace($str, $insert.$search, $index, strlen($search));
}

function content ($content) {
	return nl2br($content);
}

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

function generateRandomString ($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function vn_str_filter ($str) {
	$unicode = array(
		'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
		'd'=>'đ',
		'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		'i'=>'í|ì|ỉ|ĩ|ị',
		'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		'D'=>'Đ',
		'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
		'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
	);
	foreach ($unicode as $nonUnicode=>$uni) {
		$str = preg_replace("/($uni)/i", $nonUnicode, $str);
	}
	return $str;
}
function encodeURL ($string) {
	$string = strtolower(str_replace(' ', '-', vn_str_filter($string)));
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}


define('ENCRYPTION_KEY', 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282');
// Encrypt Function
function mc_encrypt ($encrypt, $key) {
    $encrypt = serialize($encrypt);
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
    $key = pack('H*', $key);
    $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
    $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
    $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
    return $encoded;
}
// Decrypt Function
function mc_decrypt ($decrypt, $key) {
    $decrypt = explode('|', $decrypt.'|');
    $decoded = base64_decode($decrypt[0]);
    $iv = base64_decode($decrypt[1]);
    if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
    $key = pack('H*', $key);
    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
    $mac = substr($decrypted, -64);
    $decrypted = substr($decrypted, 0, -64);
    $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
    if($calcmac!==$mac){ return false; }
    $decrypted = unserialize($decrypted);
    return $decrypted;
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
	global $chart, $report, $source, $lg, $sSelectedID;
//	if ($sSelectedID) $cond = " AND `sid` = '{$sSelectedID}' ";
//	$astro = $getRecord -> GET('data', "`code` = '{$code}' AND `lang` = '{$lg}' {$cond}", '', 'LENGTH(likes) DESC, LENGTH(dislikes) ASC, `time` DESC');
//	$astro = $chart->astroList;
//	foreach ($astro as $at) $at['content'] = ($at[$lang]);
	$astroAr = array();
	if ($_SESSION['show'] == 'all') {
		$astroAr = $report->readAll($code, $lg);
	} else $astroAr[0] = $report->getData($code, $lg, $sSelectedID);

	foreach ($astroAr as $aK => $aIn) {
	$aIn['content'] = nl2br($aIn['content']);
	$sid = $aIn['sid'];
	$source->id = $sid;
	$sIn = $source->readOne();
//	$sIn = getRecord('source^url,title,link,avatar,type', "`id` = '{$sid}' ");
	if ($aIn['likes'] || $aIn['dislikes'] || $aIn['sid'] != 0 || $aIn['uid'] != 0) {
		$aIn['content'] .= '<br></div>';
		$aIn['content'] .= '<div class="chart-paragraph-tool">'.staReport($code, $aIn);
		if ($sIn['title']) $aIn['content'] .= '<div class="chart-paragraph-source col-lg-5"><a class="s-info" href="'.$sLink.'/'.$sIn['link'].'" target="_blank"><img title="'.$sIn['title'].'" src="'.$sIn['avatar'].'" class="s-info-thumb"/> <div class="s-info-title">'.$sIn['title'].'</div></a><div class="time"><span class="fa fa-clock-o"></span> '.$aIn['time'].'</div><div class="clearfix"></div></div>';
	}
	$astroAr[$aK] = $aIn;
	}

	return $astroAr;
}
function astro ($code) {
	global $chart, $source, $lg, $sLink, $sSelectedID;
	$astroAr = astroAr($code);
	$astro = $astroAr[0];

		if ($_SESSION['show'] == 'all' && count($astroAr) > 0) {
			$astro['content'] .= '<div class="chart-select">
				<select name="select-report" class="form-control">';
				foreach ($astroAr as $oneA) {
					$astro['content'] .= '<option value="'.$oneA['id'].'">'.substr(htmlentities(preg_split('/<br[^>]*>/i', $oneA['content'])[0]), 0, 100).'</option>';
				}
			$astro['content'] .= '</select>
			</div>';
		}
		$astro['content'] .= '<div class="clearfix"></div>';
	return $astro;
}

function _astro ($code) {
	global $chart, $lg, $sLink, $sSelectedID;
	$astro = astroAr($code);
	$astro['content'] = nl2br($astro['content']);
	return $astro;
}
function staReport ($code, $aIn) {
	global $config, $lg, $sLink, $u, $time;
	$u = $config->u;
//	$aIn = $astro;
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
	if ($cont) $cont = '<div class="chart-paragraph-sta col-lg-7">'.$cont.'</div>';
	return $cont;
}

function countTrans ($did) {
	global $report;
	return $report->countTranslate($did);
//	return countRecord('data', "`code` = '{$code}' AND `translate` = '1' AND `did` = '{$did}' ", '', 'LENGTH(likes) DESC, LENGTH(dislikes) ASC');
}
