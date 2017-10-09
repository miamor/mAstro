<?
function getUserInfo ($uid, $fields) {
	global $uLink;
	$defaultFields = 'id,avatar,username,first_name,last_name,online';
	if (!$fields) $fields = $defaultFields;
	else $fields .= ','.$defaultFields;
	$uIn = getRecord('members^'.$fields, "`id` = '{$uid}' ");
	$uIn['name'] = $uIn['first_name'].' '.$uIn['last_name'];
	$uIn['link'] = $uLink.'/'.$uIn['username'];
	return $uIn;
}

function checkFollow ($uid, $uCheckFollowed) {
	global $u;
	if (!$uCheckFollowed) $uCheckFollowed = $u;
	$uIn = getRecord('members^friends', "`id` = '{$uid}' ");
	$fAr = explode(',', $uIn['friends']);
	if (in_array($uCheckFollowed, $fAr)) return true;
	else return false;
}

function uip () {
	$ipaddress = '';
	if ($_SERVER['HTTP_CLIENT_IP'])
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if ($_SERVER['HTTP_X_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if ($_SERVER['HTTP_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if ($_SERVER['HTTP_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if ($_SERVER['REMOTE_ADDR'])
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}

function geoCheckIP ($ip) {
	//check, if the provided ip is valid
	if (!filter_var($ip, FILTER_VALIDATE_IP)) throw new InvalidArgumentException("IP is not valid");
	//contact ip-server
	$response=file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip);
	if (empty($response)) throw new InvalidArgumentException("Error contacting Geo-IP-Server");
	$sregex = "/s\:\d\:/i";
	$ipInfos = explode(';', str_replace('"', '', preg_replace('/s\:(\d{1,2})\:/i', '', substr($response, 0, -2))));
	unset($ipInfos[0]);
	$ipInfo = array();
	if ($ipInfos[10] == 'geoplugin_areaCode') {
		$ipInfo['country'] = $ipInfos[17];
		$ipInfo['town'] = $ipInfos[9];
		$ipInfo['lat'] = $ipInfos[21];
		$ipInfo['long'] = $ipInfos[23];
	} else {
		$ipInfo['country'] = $ipInfos[18];
		$ipInfo['town'] = $ipInfos[9].$ipInfos[10];
		$ipInfo['lat'] = $ipInfos[22];
		$ipInfo['long'] = $ipInfos[24];
	}
	//Array containing all regex-patterns necessary to extract ip-geoinfo from page
/*	$patterns = array();
	$patterns["domain"] = '#geoplugin_city#i';
	$patterns["country"] = '#Country: (.*?)&nbsp;#i';
	$patterns["state"] = '#State/Region: (.*?)<br#i';
	$patterns["town"] = '#City: (.*?)<br#i';
	//Array where results will be stored
	$ipInfo=array();
	//check response from ipserver for above patterns
	foreach ($patterns as $key => $pattern) {
		//store the result in array
		$ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
	}
	return $ipInfo*/
	return $ipInfo;
}

function get_web_page ($url) {
	$proxies = array(); // Declaring an array to store the proxy list
	 
	// Adding list of proxies to the $proxies array
//	$proxies[] = 'user:password@173.234.11.134:54253';// Some proxies require user, password, IP and port number
//	$proxies[] = 'user:password@173.234.120.69:54253';
//	$proxies[] = 'user:password@173.234.46.176:54253';
//	$proxies[] = '27.72.67.63';// Some proxies only require IP
	$proxies[] = '173.234.93.94';
	$proxies[] = '173.234.94.90:54253'; // Some proxies require IP and port number
	$proxies[] = '69.147.240.61:54253';
	if (isset($proxies)) {// If the $proxies array contains items, then
//		$proxy = $proxies[array_rand($proxies)];// Select a random proxy from the array and assign to $proxy variable
	}
	$options = array(
		CURLOPT_RETURNTRANSFER => true, // return web page
		CURLOPT_HEADER	 => false,// don't return headers
		CURLOPT_FOLLOWLOCATION => true, // follow redirects
		CURLOPT_ENCODING => "", // handle compressed
		CURLOPT_USERAGENT=> "spider", // who am i
		CURLOPT_AUTOREFERER=> true, // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 120,// timeout on connect
		CURLOPT_TIMEOUT	=> 120,// timeout on response
		CURLOPT_MAXREDIRS=> 10, // stop after 10 redirects
	);
	$ch= curl_init($url);
	curl_setopt_array($ch, $options);
	if (isset($proxy)) {// If the $proxy variable is set, then
		curl_setopt($ch, CURLOPT_PROXY, $proxy);// Set CURLOPT_PROXY with proxy in $proxy variable
	}
	$content = curl_exec($ch);
	$err = curl_errno($ch);
	$errmsg= curl_error($ch);
	$header= curl_getinfo($ch);
	curl_close($ch);
	$header['errno'] = $err;
	$header['errmsg']= $errmsg;
	$header['content'] = $content;
	return $header;
}

function getScript ($content) {
	$script = explode('chartData = ', $content);
	$script = explode('; var htmlChart', $script[1]);
	return $script[0];
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

function check_db ($db, $condition) {
	$nums = countRecord($db, $condition);
	if (isset($_SESSION[$db])) {
		if ($_SESSION[$db] == $nums) return $nums;
		else {
			$_SESSION[$db] = $nums;
			changeValue('members', "`id` = '$u' ", "`mes_new` = '$nums' ");
			return 'new~'.$nums;
		}
	} else {
		$_SESSION[$db] = -1;
		return -1;
	}
}

function xml2array ($xmlObject, $out = array ()) {
	foreach ( (array) $xmlObject as $index => $node )
		$out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;
	return $out;
}

function activityAdd ($type, $iid, $stt, $to_uid) {
	global $u, $current, $member, $mysqli;
/*	if (!$stt) {
		if ($member['stt']) $stt = $member['stt'];
		else $stt = -1;
	}
*/	if (!$to_uid) $to_uid = $u;
	if ($iid) $mysqli->query("INSERT INTO `activity` (`type`, `stt`, `uid`, `to_uid`, `iid`, `time`, `last_updated`) VALUES ('{$type}', '{$stt}', '{$u}', '{$to_uid}', '{$iid}', '{$current}', '{$current}') ");
}

function rrmdir ($dir, $except) {
	if (is_dir($dir)) {
		$files = scandir($dir);
		foreach ($files as $file)
			if ($file != "." && $file != ".." && $file != $except) rrmdir("$dir/$file");
		rmdir($dir);
	} else if (file_exists($dir)) unlink($dir);
}

function xcopy ($src, $dest) {
	foreach (scandir($src) as $file) {
		if (!is_readable($src . '/' . $file)) continue;
		if (is_dir($file) && ($file != '.') && ($file != '..') ) {
			mkdir($dest . '/' . $file);
			xcopy($src . '/' . $file, $dest . '/' . $file);
		} else {
			copy($src . '/' . $file, $dest . '/' . $file);
		}
	}
}

function rcopy ($src, $dst) {
	if (is_dir($src)) {
		if (!is_dir($dst)) mkdir($dst);
		$files = scandir($src);
		foreach ($files as $file) {
			if ($file != "." && $file != "..") {
				rcopy ("$src/$file", "$dst/$file");
				chmod ("$dst/$file", 0777);
			}
		}
	} else if (file_exists ($src)) copy($src, $dst);
	rrmdir($src);
}

function is_dir_empty ($dir) {
	if (!is_readable($dir)) return NULL; 
	return (count(scandir($dir)) == 2);
}

function generateRandomString ($length) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) $randomString .= $characters[rand(0, strlen($characters) - 1)];
	return $randomString;
}

function generateCode ($type, $length, $character_in_group) {
	$numbers = '0123456789';
	$letters = 'abcdefghijklmnopqrstuvwxyz';
	$lettersCap = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$characters = $numbers.$letters.$lettersCap;
	$randomString = '';
	if (!$length) $length = 9;
	if (!$character_in_group && $length == 9) $character_in_group = 3;
	switch ($type) {
		case 'numbers':
			for ($i = 0; $i < $length; $i++) $randomString .= $numbers[rand(0, strlen($numbers) - 1)];
			if ($character_in_group) $randomString = substr(chunk_split(rtrim($randomString), 3, '-'), 0, -1);
			break;
		case 'letters':
			for ($i = 0; $i < $length; $i++) $randomString .= $letters[rand(0, strlen($letters) - 1)];
			if ($character_in_group) $randomString = substr(chunk_split(rtrim($randomString), 3, '-'), 0, -1);
			break;
		case 'all':
			for ($i = 0; $i < $length; $i++) $randomString .= $characters[rand(0, strlen($characters) - 1)];
			break;
	}
	return $randomString;
}

function setLang ($lang) {
	global $libPath;
	$langF = $libPath.'/lang/'.$lang.'.php';
//	echo $langF.'~~~~~~~~'.file_get_contents($langF);
	if (file_exists($langF)) include $langF;
	else {
		echo '<div class="alerts alert-error">This language is not available yet. Sorry for this inconvinient.</div>';
		include $libPath.'/lang/en.php';
	}
//	return file_get_contents($langF);
/*	switch ($lang) {
		case 'en' 	:	return file_get_contents($folder);
	}
*/}

function rate ($type, $iid, $star, $title, $content) {
	global $u, $curint, $current, $mysqli;
	$table = $type.'_ratings';
////	$cInfo = getRecord($type.'^uid', "`id` = '{$iid}' ");
	$rated = 0;
	if (countRecord($table, "`uid` = '{$u}' AND `iid` = '{$iid}'") <= 0) {
		$rr = $mysqli->query("INSERT INTO `$table` (`uid`, `iid`, `rate`, `title`, `content`, `time`) VALUES ('$u', '$iid', '$star', '$title', '$content', '$current')");
		if ($rr) $rated = 1;
//		sendNoti($table, '', $iid, $cInfo['uid'], $star);
	}
	return $rated;
}

function friendList ($status) {
	global $u;
	$getRecord = new getRecord();
	$fR = $getRecord -> GET('friend', " (`receive_id` = '$u' OR `uid` = '$u') AND `accept` = 'yes'");
	foreach ($fR as $fR) {
		if ($fR['uid'] == $u) $fRu = $fR['receive_id'];
		else $fRu = $fR['uid'];
		$fRm = getRecord('members', "`id` = '$fRu'");
		$mutualF = 0;
		$lastMes = getRecord('chat', " (`to_uid` = '$fRu' AND `uid` = '$u') OR (`to_uid` = '$u' AND `uid` = '$fRu') ");
		if ($fRm['online'] == $status) {
			echo '<li><a id="'.$fRu.'">
					<span class="user-status'; if ($status == 'online') echo ' success'; else if ($status == 'idle') echo ' warning'; else if ($status == 'offline') echo ' danger'; echo '"></span>
					<img src="'.$fRm['avatar'].'" class="ava-sidebar img-circle" alt="Avatar">
<!--					<i class="fa fa-mobile-phone device-status"></i> -->
					<span class="activity">'.$fRm['username'].'</span>
					<span class="small-caps"> ';
			if ($lastMes['uid'] == $u) echo '<span class="fa fa-mail-forward"></span> ';
			echo $lastMes['content'].'</span>
			</a></li>';
	 	}
	}
}

function encryptIt ($q) {
$cryptKey= 'qJB0rGtIn5UB1xG03efyCp';
$qEncoded= base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
return( $qEncoded );
}

function decryptIt ($q) {
$cryptKey= 'qJB0rGtIn5UB1xG03efyCp';
$qDecoded= rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
return( $qDecoded );
}

function addNumField ($uid, $coin, $field) {
	$uInfo = getRecord('members', "`id` = '$uid'");
	$oldcoin = (int)$uInfo[$field];
	$newcoin = $oldcoin + $coin;
	$cha = changeValue('members', "`id` = '$uid'", "`$field` = '$newcoin'");
}

function subtractNumField ($uid, $coin, $field) {
	$uInfo = getRecord('members', "`id` = '$uid'");
	$oldcoin = (int)$uInfo[$field];
	$newcoin = $oldcoin - $coin;
	changeValue('members', "`id` = '$uid'", "`$field` = '$newcoin'");
}

function addCoin ($u, $coin) {
	addNumField($u, $coin, 'pCoin');
}
function subtractCoin ($u, $coin) {
	subtractNumField($u, $coin, 'pCoin');
}

function addfriend ($u, $to, $time) {
	$uInfo = getRecord('members', "`id` = '$u'");
	$toInfo = getRecord('members', "`id` = '$to'");
	if (countRecord('friend', "(`uid` = '$u' AND `receive_id` = '$to') OR (`uid` = '$to' AND `receive_id` = '$u')") <= 0) {
		$mysqli->query("INSERT INTO `friend` (`uid`, `receive_id`) VALUES ('$u', '$to')");
		sendNoti('friend_request', '', $to);
	}
}
function acceptfriend ($id_send, $u, $to, $current) {
	$m_send = getRecord('members', "`id` = '$id_send'");
	if (countRecord('friend', "`uid` = '$id_send' AND `receive_id` = '$u' AND `accept` == 0 ") > 0) {
		activityAdd('become-friend', $u, '', $id_send);
		sendNoti('accept_friend_request', '', $id_send);
		changeValue('friend', "`uid` = '{$id_send}' AND `receive_id` = '{$u}' ", "`accept` = '1' ");
	}
}

function sendNoti ($type, $iid, $to, $content) {
	global $u, $current, $curint, $social_conf, $libPath;
	return $mysqli->query("INSERT INTO `notification` (`type`, `iid`, `uid`, `to_uid`, `content`, `time`) VALUES ('{$type}', '{$iid}', '{$u}', '{$to}', '{$content}', '{$curint}')");
//	addNoti($to);
/*	$uTo = getRecord('members^oauth_provider,oauth_uid', "`id` = '{$to}' ");
	if ($member['token'] && $member['oauth_provider'] == 'facebook' && $uTo['oauth_provider'] == 'facebook' && $uTo['token']) {
		$href = HOST_URL;
		include MAIN_PATH.'/pages/system/sendNotiFb.php';
		sendNotiFb($notiContent, $uTo['oauth_uid'], $href);
	} */
}

function removeNoti ($type, $from, $to, $iid, $content) {
	$mysqli->query("DELETE FROM `notification` WHERE `type` = '{$type}' AND `uid` = '{$from}' AND `to_uid` = '{$to}' AND `iid` = '{$iid}' AND `content` = '{$content}' ");
//	subtractNoti($to);
}

function content ($content) {
	return html_entity_decode(nl2br($content));
}
function _content ($content) {
	$need = array("\'", "'");
	$replaced = array('', "\'");
	return html_entity_decode(str_replace($need, $replaced, nl2br($content)));
}
function _contents ($content) {
	$need = array("'", '"');
	$replaced = array("&#39;", '&#34;');
	return html_entity_decode(str_replace($need, $replaced, nl2br($content)));
}

function _GET ($string) {
	if (checkURL('#!') > 0) {
		$ar = explode($string.'=', $_SERVER['REQUEST_URI']);
		$ars = explode('&', $ar[1]);
		return $ars[0];
	} else {
		return $_GET[$string];
	}
}

function createDateRangeArray ($strDateFrom, $strDateTo) {
	$aryRange=array();
	$iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	$iDateTo=mktime(1,0,0,substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));
	if ($iDateTo>=$iDateFrom) {
		array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
		while ($iDateFrom<$iDateTo) {
			$iDateFrom+=86400; // add 24 hours
			array_push($aryRange,date('Y-m-d',$iDateFrom));
		}
	}
	return $aryRange;
}

function mb_ucfirst ($str, $encoding = "UTF-8", $lower_str_end = false) {
	$first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
	$str_end = "";
	if ($lower_str_end) $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
	else $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
	$str = $first_letter . $str_end;
	return $str;
}

function HTMLToRGB($htmlCode) {
	if ($htmlCode[0] == '#')
		$htmlCode = substr($htmlCode, 1);
	if (strlen($htmlCode) == 3) {
		$htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
	}
	$r = hexdec($htmlCode[0] . $htmlCode[1]);
	$g = hexdec($htmlCode[2] . $htmlCode[3]);
	$b = hexdec($htmlCode[4] . $htmlCode[5]);
	return $b + ($g << 0x8) + ($r << 0x10);
}

function RGBToHSL($RGB) {
	$r = 0xFF & ($RGB >> 0x10);
	$g = 0xFF & ($RGB >> 0x8);
	$b = 0xFF & $RGB;

	$r = ((float)$r) / 255.0;
	$g = ((float)$g) / 255.0;
	$b = ((float)$b) / 255.0;

	$maxC = max($r, $g, $b);
	$minC = min($r, $g, $b);

	$l = ($maxC + $minC) / 2.0;

	if ($maxC == $minC) $s = $h = 0;
	else {
		if ($l < .5) $s = ($maxC - $minC) / ($maxC + $minC);
		else $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
		if ($r == $maxC)
			$h = ($g - $b) / ($maxC - $minC);
		if ($g == $maxC)
			$h = 2.0 + ($b - $r) / ($maxC - $minC);
		if ($b == $maxC)
			$h = 4.0 + ($r - $g) / ($maxC - $minC);
		$h = $h / 6.0; 
	}

	$h = (int)round(255.0 * $h);
	$s = (int)round(255.0 * $s);
	$l = (int)round(255.0 * $l);

	return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
}

function favList ($sFavAr) {
	global $u, $time;
$sFs = 0;
$sFu = array();
if ($sFavAr) $sFav = count($sFavAr);
else $sFav = 0;
foreach ($sFavAr as $sFo) {
	if (checkFollow($sFo) && $sFs <= 3) {
		$sFs++;
		$sFu[] = getUserInfo($sFo);
	}
}
$sFavLeft = $sFav - $sFs;
if ($sFav > 0) {
	echo '<div class="post-fav-list">';
	if (in_array($u, $sFavAr)) {
		echo 'You';
		if ($sFav == 2) echo ' and ';
		else if ($sFav > 1) echo ', ';
		$sFavLeft--;
	}
	if ($sFavLeft > 0) {
/*		if (in_array($u, $sFavAr)) {
			if (count($sFu) > 0) echo ', ';
			else echo ' ';
		}
*/		foreach ($sFu as $sfk => $sfin) {
			echo '<a href="'.$sfin['link'].'">'.$sfin['name'].'</a>';
			if ($sfk == $sFs - 1) echo ' ';
			else if ($sfk < 2) echo ', ';
			else echo 'and ';
		}
		if (in_array($u, $sFavAr) || count($sFu) > 0) echo 'and ';
		echo '<a class="view-all-fav">'.$sFavLeft.' ';
		if (in_array($u, $sFavAr) || count($sFu) > 0) {
			echo 'other'; if ($sFavLeft > 1) echo 's';
		} else {
			if ($sFavLeft > 1) echo 'people'; else echo 'person';
		}
		echo '</a>';
	} else {
		foreach ($sFu as $sfk => $sfin) {
			echo '<a href="'.$sfin['link'].'">'.$sfin['name'].'</a>';
			if ($sfk == $sFs - 2) echo ' and ';
			else if ($sfk < 1 && $sfk != $sFs - 1) echo ', ';
			else echo ' ';
		}
	}
	echo ' hearted this';
	echo '</div>';
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

function tagsList ($tag) {
	if ($tag) {
		$tagAr = explode(',', $tag);
		for ($i = 0; $i < count($tagAr); $i++)
			$tagShow[] = '<a href="#!tag?i='.$tagAr[$i].'" class="tag">'.$tagAr[$i].'</a>';
		$tagChar = implode(' ', $tagShow);
		return $tagChar;
	}
}

function tag ($content) {
	global $u, $frArN, $member;
	$content = str_replace(array('&nbsp;', '@', '<p><br></p>', '&#39;', '&#34;'), array(' ', '+', '', "'", '"'), _content($content));
	$memTagAr = explode('+', $content);
	for ($j = 1; $j < count($memTagAr); $j++) {
		$thisMem = explode(' ', $memTagAr[$j]);
//		$thisMem = explode('&nbsp;', $thisMem[0]);
		$thisMem = $thisMem[0];
		$thisMemIn = getRecord('members^username', "`username` = '$thisMem' ");
		if (in_array($thisMem, $frArN) || $thisMem == $member['username']) {
			$need[] = '+'.$thisMem.' ';
			$replaced[] = '<a href="#!user?u='.$thisMem.'">+'.$thisMem.'</a> ';
		}
	}
	$displayContent = str_replace($need, $replaced, $content);
	return str_replace(array("\'", '+'), array("'", '@'), $displayContent);
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

function removeSpace ($content) {
	return str_replace(' ', '', $content);
}
	
function emo ($content) {
	$emodir = IMG.'/emo';
	$kitu = array();
	$em = array();
	$mE = $mysqli->query("SELECT * FROM `emo` WHERE type='emo' ORDER BY `order` DESC");
	while ($es = mysqli_fetch_array ($mE)) {
		$eid = $es['id'];
		$eicon = $es['icon'];
		$ename = $es['name'];
		$edot = $es['dot'];
		$eimg = "<img src='$emodir/{$es['cat']}/{$es['img']}.$edot'/>";
		array_push($kitu, $eicon);
		array_push($em, $eimg);
	}
	$content = str_replace( $kitu, $em, nl2br($content) );
	return $content;
}

function encodeURL ($string) {
	$string = str_replace(' ', '-', $string);
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
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

function changeValue ($table, $condition, $value) {
	global $mysqli, $con;
	if ($table == '' || countRecord($table, $condition) <= 0) return false;
	if ($condition == '') $result = $mysqli->query("UPDATE `$table` SET $value");
	else $result = $mysqli->query("UPDATE `$table` SET $value WHERE $condition");
	if ($result === FALSE) die(mysqli_error());
	else return $result;
}

function insert ($tb, $fields, $values) {
	global $mysqli;
	return $mysqli->query("INSERT INTO $tb ($fields) VALUES ($values)");
}
function delete ($tb, $condition) {
	global $mysqli;
	return $mysqli->query("DELETE FROM $tb WHERE $condition");
}

function getFields ($tb) {
	$fields = mysqli_list_fields(DB_NAME, $tb);
	$columns = mysqli_num_fields($fields);
	for ($i = 0; $i < $columns; $i++) $field_array[] = mysqli_field_name($fields, $i);
	return $field_array;
}

function pushToCol ($tb, $rowDefine, $iid, $rowToPush, $uid, $pi) {
	global $u, $member, $bp;
/*	$fields = getFields($tb);
	if (!in_array('uid', $fields)) {
		$rowGet = "$rowDefine,$rowToPush";
		$pIn = getRecord('promise^id,uid', "`id` = '$iid' ");
		$uGet = $pIn['uid'];
		$tbl = 'promise';
	} else {
		$rowGet = "$rowDefine,$rowToPush,uid";
		$tbl = $tb;
	}
*/	if (!$uid) $uid = $u;
	$rowGet = "`{$rowDefine}`,`{$rowToPush}`,`uid`";
	$rowIn = getRecord("$tb^$rowGet", "`$rowDefine` = '{$iid}' ");
	$uGet = $rowIn['uid'];
	if ($rowIn[$rowToPush]) $rowAr = explode(',', $rowIn[$rowToPush]);
	else $rowAr = array();
	if (!in_array($uid, $rowAr)) $rowAr[] = $uid;
	$rowStr = implode(',', $rowAr);
//	echo $rowStr.'<br/>';
//	echo $iid.'<br/>';
//	echo $rowStr.'<br/>';
	$notTbAr = array('campaign', 'data_box_jobs', 'data_box_utask', 'data_box_register_options');
	$notRowAr = array('joined', 'confirmFalse', 'confirmTrue', 'starter');
//	$actTbAr = array('campaign', 'data_box_utask', 'data_box_register_options');
//	if (in_array($tb, $actTbAr)) activityAddCamp($rowToPush.'-'.$tb, $bp['iid'], $iid);
	if (!in_array($tb, $notTbAr) && !in_array($rowToPush, $notRowAr)) {
		if ($uid != $rowIn['uid']) sendNoti($rowToPush.'-'.$tb, $iid, $pi, $rowIn['uid']);
	}
	return $change = changeValue($tb, "`$rowDefine` = '$iid' ", "`$rowToPush` = '$rowStr' ");
}

function rmFromCol ($tb, $rowDefine, $iid, $rowToPush, $uid, $pi) {
	global $u, $member;
	if (!$uid) $uid = $u;
	$rowGet = "`{$rowDefine}`,`{$rowToPush}`,`uid`";
	$rowIn = getRecord("$tb^$rowGet", "`$rowDefine` = '$iid' ");
	if ($rowIn[$rowToPush]) $rowAr = explode(',', $rowIn[$rowToPush]);
	else $rowAr = array();
	if (($key = array_search($uid, $rowAr)) !== false) unset ($rowAr[$key]);
	$rowStr = implode(',', $rowAr);
	removeNoti($rowToPush.'-'.$tb, $uid, $rowIn['uid'], $iid, $pi);
	return $change = changeValue($tb, "`$rowDefine` = '$iid'", "`$rowToPush` = '$rowStr'");
}

function get ($char) {
	global $request;
	$c = explode($char.'=', $request)[1];
	$c = explode('&', $c)[0];
	$request = str_replace("{$char}={$c}&", "", $request);
//	$c = preg_split("/{$char}=|&/", $request)[1];
//	$request = preg_replace("/{$char}={$c}&/", "", $request);
	return $c;
}

class getRecord {
	private function _open_connection() {
		$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
		if (!$con) die('Error Connection:' . mysqli_error());
		$db_select = mysqli_select_db(DB_NAME, $con);
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

	public function GET ($table, $condition, $display, $order) {
		global $mysqli, $con;
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
		if ($display && $display != 0 && check($display, '%') <= 0) {
			if (isset($_GET['page']) && (int)$_GET['page'] >= 0) {
				$page = $_GET['page'];
			} else {
				$result = $mysqli->query($query);
				$rows = mysqli_fetch_array($result);
				$record = countRecord ($table, $condition);
				if($record > $display) $page = ceil($record/$display);
				else $page = 1;
			}
			$start = (isset($_GET['start']) && (int)$_GET['start'] >= 0) ? $_GET['start'] : 0;
			$current = ($start/$display)+1;
			$next = $start + $display;
			$previous = $start - $display;
			$last = ($page - 1)*$display;
			if (check($miis, '^') <= 0) {
				if ($current >= 4) {
					$start_page = $current - 2;
					if ($page > $current + 2) $end_page = $current + 2;
					else if ($current <= $page && $current > $page - 3) {
						$start_page = $page - 3;
						$end_page = $page;
					} else $end_page = $page;
				} else {
					$start_page = 1;
					if ($page > 4) $end_page = 4;
					else $end_page = $page;
				}
			} else {
				$start_page = 1;
				$end_page = $page;
			}

			$pattern = 'astro';
			$flO = $_SERVER['REQUEST_URI'];
			if (checkURL('/'.$pattern.'/') > 0) {
				$flO = explode('/'.$pattern.'/', $_SERVER['REQUEST_URI']);
				$flO = $flO[1];
			}
			if (check($flO, '?start') > 0) $fl = explode('?start', $flO);
			else $fl = explode('&start', $flO);
			$fl = $fl[0];
			$flss = explode("?", $fl);
			if (checkURL('/'.$pattern.'/') > 0) {
				if (check($fl, '?') <= 0) {
					if (check($fl, '/') >= 1) $fls = '/'.$fl;
					else $fls = '/'.$fl.'?';
					$mm = $flss[1].'&';
				} else {
					$fls = '/'.$fl;
					$mm = '&';
				}
			} else {
				if (check($fl, '?') <= 0 && check($fl, '/') <= 1) $fls = $fl.'?';
				else $fls = $fl;
				$mm = '&';
			}
			if ($page > 1) {
				echo '<div class="pagination primary right">';
				//echo '<span class="bold" title="<b>'.$page.'</b> pages available">['.$page.']</span>';
				if ($current > 1) echo "<li><a href='".MAIN_URL.$fls.$mm."start=0&page=$page' data-toggle='tooltip' title='To the first page'><i class='fa fa-chevron-left'></i></a></li>";
				else echo "<li class='disabled'><a data-toggle='tooltip' title='To the first page'><i class='fa fa-chevron-left'></i></a></li>";
				for ($i = $start_page; $i <= $end_page; $i++) {
					if ($current == $i) echo "<li class='active'><a>$i</a></li>";
					else {
						/*if (strlen(strstr($fl, '?')) <= 0) echo "<li class='pageli'><a class='page' href='".MAIN_URL.$fls."start=".($display*($i-1))."&page=$page'>$i</a></li>";
						else */echo "<li class='pageli'><a class='page' href='".MAIN_URL.$fls.$mm."start=".($display*($i-1))."&page=$page'>$i</a></li>";
					}
				}
				if ($current < $page) echo "<li><a data-toggle='tooltip' href='".MAIN_URL.$fls.$mm."start=$last' title='To the last page'><i class='fa fa-chevron-right'></i></a></li>";
				else echo "<li class='disabled'><a data-toggle='tooltip' title='To the last page'><i class='fa fa-chevron-right'></i></a></li>";
				echo '</div><div class="clearfix"></div>';
			}
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

function left ($leftstring, $leftlength) {
	return(substr($leftstring, 0, $leftlength));
}

function Reduce_below_30 ($longitude) {
	$lng = $longitude;
	while ($lng >= 30) $lng = $lng - 30;
	return $lng;
}

function Convert_Longitude ($longitude) {
	$signs = array (0 => 'Ari', 'Tau', 'Gem', 'Can', 'Leo', 'Vir', 'Lib', 'Sco', 'Sag', 'Cap', 'Aqu', 'Pis');

	$sign_num = floor($longitude / 30);
//	echo ($longitude / 30).'<br/>';
	$pos_in_sign = $longitude - ($sign_num * 30);
	$deg = floor($pos_in_sign);
	$full_min = ($pos_in_sign - $deg) * 60;
	$min = floor($full_min);
	$full_sec = round(($full_min - $min) * 60);

	if ($deg < 10) $deg = "0" . $deg;
	if ($min < 10) $min = "0" . $min;

	if ($full_sec < 10) $full_sec = "0" . $full_sec;

	return $deg . " " . $signs[$sign_num] . " " . $min . "' " . $full_sec . chr(34);
}

function mid ($midstring, $midstart, $midlength) {
	return(substr($midstring, $midstart-1, $midlength));
}

function safeEscapeString ($string) {
	// replace HTML tags '<>' with '[]'
	$temp1 = str_replace("<", "[", $string);
	$temp2 = str_replace(">", "]", $temp1);

	// but keep <br> or <br />
	// turn <br> into <br /> so later it will be turned into ""
	// using just <br> will add extra blank lines
	$temp1 = str_replace("[br]", "<br />", $temp2);
	$temp2 = str_replace("[br /]", "<br />", $temp1);

//	if (get_magic_quotes_gpc()) 
		return $temp2;
//	else
//		return mysqli_escape_string($temp2);
}

function Find_Specific_Report_Paragraph ($phrase_to_look_for, $file) {
	$string = "";
	$len = strlen($phrase_to_look_for);

	//put entire file contents into an array, line by line
	$file_array = file($file);

	// look through each line searching for $phrase_to_look_for
	for ($i = 0; $i < count($file_array); $i++) {
		if (left(trim($file_array[$i]), $len) == $phrase_to_look_for) {
			$flag = 0;
			while (trim($file_array[$i]) != "*") {
/*				if ($flag == 0) 
					$string .= "<b>" . $file_array[$i] . "</b>";
				else 
*/				$string .= $file_array[$i];
				$flag = 1;
				$i++;
			}
			break;
		}
	}
	return $string;
}

function Crunch ($x) {
	if ($x >= 0) $y = $x - floor($x / 360) * 360;
	else $y = 360 + ($x - ((1 + floor($x / 360)) * 360));
	return $y;
}

function drawboldtext($image, $size, $angle, $x_cord, $y_cord, $clr_to_use, $fontfile, $text, $boldness) {
	$_x = array(1, 0, 1, 0, -1, -1, 1, 0, -1);
	$_y = array(0, -1, -1, 0, 0, -1, 1, 1, 1);

	for($n = 0; $n <= $boldness; $n++) ImageTTFText($image, $size, $angle, $x_cord+$_x[$n], $y_cord+$_y[$n], $clr_to_use, $fontfile, $text);
}

function DMStoDEC ($deg,$min,$sec) {
	return $deg+((($min*60)+($sec))/3600);
}

function DECtoDMS ($dec) {
	$vars = explode(".",$dec);
	$deg = $vars[0];
	$tempma = "0.".$vars[1];

	$tempma = $tempma * 3600;
	$min = floor($tempma / 60);
	$sec = $tempma - ($min*60);

	return array("deg"=>$deg, "min"=>$min, "sec"=>$sec);
}

function createChart ($tb, $valAr, $valAr_) {
	global $getRecord, $u, $member, $current, $cLink, $tLink, $rLink;
	$strAr = $strAr_ = $strKeyAr = $strValAr = array();
	foreach ($valAr as $vK => $vO) $strAr[] = " `{$vK}` = '{$vO}' ";
	$str = implode('AND', $strAr);
	$valAr['uid'] = $valAr['ucreate'] = $u;
	$valAr['uname'] = $member['username'];
	$valAr['time'] = $valAr['last_updated'] = $current;
	$nn = countRecord($tb, "`uid` = '{$u}' ") + 1;
	$valAr['n'] = $nn;
	foreach ($valAr as $vK => $vO) {
		$strKeyAr[] = "`{$vK}`";
		$strValAr[] = "'{$vO}'";
	}
	$strKey = implode(', ', $strKeyAr);
	$strVal = implode(', ', $strValAr);

	if ($tb == 'chart') $_link = $cLink;
	else if ($tb == 'transit') $_link = $tLink;
	else if ($tb == 'relationship') {
		$_link = $rLink;
		foreach ($valAr_ as $vK => $vO) $strAr_[] = " `{$vK}` = '{$vO}' ";
		$str_ = implode('AND', $strAr_);
		$str = "({$str}) OR ({$str_})";
	}

	$cIn = getRecord($tb, $str);
	if ($cIn['id']) echo $_link.'/'.$cIn['uname'].'/'.$cIn['n'];
	else {
		$ins = insert($tb, $strKey, $strVal);
		$cIn = getRecord($tb, "`uid` = '{$u}' AND `n` = '{$nn}' ");
		activityAdd($tb, $cIn['id'], 0);
		if ($tb == 'relationship') {
			$aIn = getRecord('astro_data^uid', "`id` = '{$valAr['aid']}' ");
			$aIn_ = getRecord('astro_data^uid', "`id` = '{$valAr_['aid']}' ");
			if ($aIn['uid'] != $u) sendNoti('create-relationship', $cIn['id'], $aIn['uid']);
			else if ($aIn_['uid'] != $u) sendNoti('create-relationship', $cIn['id'], $aIn_['uid']);
		}
		if ($ins) echo $_link.'/'.$member['username'].'/'.$nn;
	}
}

function addView ($tb, $cIn) {
	$views = $cIn['views'] + 1;
	changeValue($tb, "`id` = '{$cIn['id']}' ", "`views` = '{$views}' ");
}

function astroAr ($code) {
	global $getRecord, $lg, $sSelectedID;
	if ($sSelectedID) $cond = " AND `sid` = '{$sSelectedID}' ";
	$astro = $getRecord -> GET('data', "`code` = '{$code}' AND `lang` = '{$lg}' {$cond}", '', 'LENGTH(likes) DESC, LENGTH(dislikes) ASC, `time` DESC');
//	foreach ($astro as $at) $at['content'] = ($at[$lang]);
	return $astro;
}
function astro ($code) {
	global $getRecord, $lg, $sLink, $sSelectedID;
	$astro = astroAr($code);
	$astro[0]['content'] = nl2br($astro[0]['content']);
	$aIn = $astro[0];
	$sid = $aIn['sid'];
	$sIn = getRecord('source^url,title,link,avatar,type', "`id` = '{$sid}' ");
	if ($aIn['likes'] || $aIn['dislikes'] || $aIn['sid'] != 0 || $aIn['uid'] != 0) {
		$aIn['content'] .= '<br></div><div class="chart-paragraph-tool"><div class="chart-paragraph-sta col-lg-7">'.staReport($code).'</div>';
		if ($sIn['title']) $aIn['content'] .= '<div class="chart-paragraph-source col-lg-5"><a class="s-info" href="'.$sLink.'/'.$sIn['link'].'" target="_blank"><img title="'.$sIn['title'].'" src="'.$sIn['avatar'].'" class="s-info-thumb"/> <div class="s-info-title">'.$sIn['title'].'</div></a><div class="time"><span class="fa fa-clock-o"></span> '.date('D, d M \'y', $aIn['time']).'</div><div class="clearfix"></div></div>';
		$aIn['content'] .= '<div class="clearfix"></div>';
	}
	return $aIn;
}
function _astro ($code) {
	global $getRecord, $lg, $sLink, $sSelectedID;
	$astro = astroAr($code);
	$astro[0]['content'] = nl2br($astro[0]['content']);
	return $astro[0];
}
function staReport ($code) {
	global $getRecord, $lg, $sLink, $u, $time;
	$astro = astroAr($code);
	$aIn = $astro[0];
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
		if (checkFollow($sFo) && $sFs <= 3) {
			$sFs++;
			$sFu[] = getUserInfo($sFo);
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
	global $getRecord, $lg;
	return countRecord('data', "`code` = '{$code}' AND `translate` = '1' AND `did` = '{$did}' ", '', 'LENGTH(likes) DESC, LENGTH(dislikes) ASC');
}

function chartStt ($cIn, $type) {
	global $cAu, $cOwn, $u, $hour, $minute, $secs, $month, $day, $year, $longAr, $ew_txt, $latAr, $ns_txt, $percentRate, $averageRate, $totalRate, $cGrade;
	$cAu = $cOwn; ?>
	<a class="chart-pdf-download" href="?v=pdf" target="_blank" data-placement="bottom" title="Download pdf"><span class="fa fa-file-pdf-o"></span></a>
	<div class="chart-stt dropdown">
		<div class="chart-current-stt dropdown-toggle" data-toggle="dropdown">
		<? if ($cIn['stt'] == 0) echo '<div class="fa fa-lock" data-placement="bottom" title="Only me"></div>';
		else if ($cIn['stt'] == -1) echo '<div class="fa fa-globe" data-placement="bottom" title="Public"></div>';
		else if ($cIn['stt'] == 1) echo '<div class="fa fa-user" data-placement="bottom" title="Friends"></div>';
		else if ($cIn['stt'] == 2) echo '<div class="fa fa-users" data-placement="bottom" title="Friends of friends"></div>'; ?>
		</div>
<? if ($cAu['id'] == $u) { ?>
		<div class="chart-stt-dropdown dropdown-menu with-triangle primary pull-right">
			<li<? if ($cIn['stt'] == 0) echo ' class="active"' ?>><a id="0"><span class="fa fa-lock" title="Only me"></span> Only me</a></li>
			<li<? if ($cIn['stt'] == -1) echo ' class="active"' ?>><a id="-1"><span class="fa fa-globe" title="Public"></span> Public</a></li>
			<li<? if ($cIn['stt'] == 1) echo ' class="active"' ?>><a id="1"><span class="fa fa-user" title="Friends"></span> Friends</a></li>
			<li<? if ($cIn['stt'] == 2) echo ' class="active"' ?>><a id="2"><span class="fa fa-users" title="Friends of friends"></span> Friends of friends</a></li>
		</div>
<? } ?>
	</div>
	<div class="chart-ratings">
		<div class="chart-grade rate-grade">
			<? echo $cGrade ?>
		</div>
		<div class="chart-star star-info">
<!--		<div class="rating-icons rated left">
			<? for ($z = 1; $z <= 5; $z++) { ?>
				<div class="rating-star-icon v<? echo $z ?>" id="v<? echo $z ?>">&nbsp;</div>
			<? } ?>
			<div class="rate-count" style="width:<? echo $percentRate ?>%"></div>
		</div>-->
			<? for ($z = 1; $z <= 5; $z++) { ?>
				<span class="fa fa-star<? if ($averageRate == $z - 0.5) echo '-half'; else if ($averageRate < $z) echo '-o' ?>"></span>
			<? } ?>
			<div class="gensmall rl-review-count">(<b><? echo $totalRate ?></b>) <a>reviews</a>
			<? //if ($cIn['uid'] != $u && $u && countRecord($tb.'_ratings', "`iid` = '{$iid}' AND `uid` = '{$u}' ") <= 0) echo '<br/><a class="italic write_review">Write a review</a>' ?></div>
		</div>
	</div>
	<div class="chart-private left">
		<? if (!$type && $cIn['uid'] == $u) { ?>
			<div class="chart-born">Born <? echo strftime("%A, %B %d, %Y<br>%X (time zone = GMT $tz hours)", mktime($hour, $minute, $secs, $month, $day, $year)) ?></div>
			<div class="chart-position"><? echo $longAr['deg'] . $ew_txt . $longAr['min'] . ", " . $latAr['deg'] . $ns_txt . $latAr['min']?></div>
		<? } else {
			if ($cAu['id'] != $cOwn['id']) $by = ' by '. $cAu['name'] .' using '. $cOwn['name'] .'\'s data'; ?>
			<div class="chart-owner" title="Data details have been hidden under the mAstro's privacy policy.">
				<div class="gensmall hide">This chart belongs to</div>
				<a data-online="<? echo $cOwn['online'] ?>" href="<? echo $cOwn['link'] ?>">
					<img class="img-rounded chart-owner-avt" src="<? echo $cOwn['avatar'] ?>"/>
				</a>
				<div style="margin-left:50px"><a href="<? echo $cOwn['link'] ?>"><? echo $cOwn['name'] ?></a>
					<div class="gensmall time"><span class="fa fa-clock-o" title="Created at <? echo date('D dS, M', $cIn['time']).$by ?>"></span> <? echo date('D dS, M', $cIn['time']) ?>
					<? if ($cAu['id'] != $cOwn['id']) echo ' - by <a href="'. $cAu['link'] .'">'. $cAu['name'] .'</a>' ?>
					</div>
				</div>
<!--				<div class="gensmall hide">Details have been hidden under the mAstro's privacy policy.</div> -->
				<div class="clearfix"></div>
			</div>
		<? } ?>
	</div>
	<form class="right" action="<? echo $cLink.'?do=caculate' ?>" method="post">
		<select name="h_sys">
<?	echo "<option value='p' ";
		if ($h_sys == "p") echo " selected";
		echo "> Placidus </option>";

		echo "<option value='k' ";
		if ($h_sys == "k") echo " selected";
		echo "> Koch </option>";

		echo "<option value='r' ";
		if ($h_sys == "r") echo " selected";
		echo "> Regiomontanus </option>";

		echo "<option value='c' ";
		if ($h_sys == "c") echo " selected";
		echo "> Campanus </option>";

		echo "<option value='b' ";
		if ($h_sys == "b") echo " selected";
		echo "> Alcabitus </option>";

		echo "<option value='o' ";
		if ($h_sys == "o") echo " selected";
		echo "> Porphyrius </option>";

		echo "<option value='m' ";
		if ($h_sys == "m") echo " selected";
		echo "> Morinus </option>";

		echo "<option value='a' ";
		if ($h_sys == "a") echo " selected";
		echo "> Equal house - Asc </option>";

		echo "<option value='t' ";
		if ($h_sys == "t") echo " selected";
		echo "> Topocentric </option>";

		echo "<option value='v' ";
		if ($h_sys == "v") echo " selected";
		echo "> Vehlow </option>";
?></select>
		<input type="hidden" name="name" value="<?php echo $cIn['name']; ?>">
		<input type="hidden" name="month" value="<?php echo $cIn['month']; ?>">
		<input type="hidden" name="day" value="<?php echo $cIn['day']; ?>">
		<input type="hidden" name="year" value="<?php echo $cIn['year']; ?>">
		<input type="hidden" name="hour" value="<?php echo $cIn['hour']; ?>">
		<input type="hidden" name="minute" value="<?php echo $cIn['minute']; ?>">
		<input type="hidden" name="timezone" value="<?php echo $cIn['timezone']; ?>">
		<input type="hidden" name="long_deg" value="<?php echo $cIn['long_deg']; ?>">
		<input type="hidden" name="long_min" value="<?php echo $cIn['long_min']; ?>">
		<input type="hidden" name="ew" value="<?php echo $cIn['ew']; ?>">
		<input type="hidden" name="lat_deg" value="<?php echo $cIn['lat_deg']; ?>">
		<input type="hidden" name="lat_min" value="<?php echo $cIn['lat_min']; ?>">
		<input type="hidden" name="ns" value="<?php echo $cIn['ns']; ?>">
		<input type="hidden" name="h_sys_submitted" value="TRUE">
	</form>
<? }

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

function hex2rgb ($color, $opacity = false) {
	$default = 'rgb(0,0,0)';
	//Return default if no color provided
	if (empty($color)) return $default; 

	//Sanitize $color if "#" is provided 
	if ($color[0] == '#' ) $color = substr($color, 1);

	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
	else if (strlen($color) == 3) $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
	else return $default;

	//Convert hexadec to rgb
	$rgb = array_map('hexdec', $hex);

	//Return rgb(a) color string
	return $rgb;
}

function hex2rgba ($color, $opacity = false) {
	$default = 'rgb(0,0,0)';
	$rgb = hex2rgba($color);
	//Check if opacity is set(rgba or rgb)
	if ($opacity) {
		if (abs($opacity) > 1) $opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else $output = 'rgb('.implode(",",$rgb).')';
	//Return rgb(a) color string
	return $output;
}

?>
