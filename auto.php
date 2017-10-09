<?
include_once 'include/config.php';
include_once 'objects/login.php';
include_once 'objects/chart.php';
//header('Content-type: application/json; charset=utf-8');

$login = new Login();
$chart = new Chart();
$accessToken = $_SESSION['fb_access_token'];
$config->u = $u = $_SESSION['uid'];
$config->token = $accessToken;

//$accessToken = 'EAACEdEose0cBADyVeVmpoizPqmJ97dXtPcCwycFJAkLLnStXOuoSEofojmoqOwUS6edZBfwyP8c4ZCy8bWAvAYYrWTZAXioQeBztM0Q7KYUbdQxoIKRZC5j12TK338HQlwTz3TVvmEIYNkgnUpkR79F6hbnFyDCGZB3hyN3klpwZDZD';

// token created using tools
//EAACEdEose0cBADyVeVmpoizPqmJ97dXtPcCwycFJAkLLnStXOuoSEofojmoqOwUS6edZBfwyP8c4ZCy8bWAvAYYrWTZAXioQeBztM0Q7KYUbdQxoIKRZC5j12TK338HQlwTz3TVvmEIYNkgnUpkR79F6hbnFyDCGZB3hyN3klpwZDZD

//echo "Access token: ".$accessToken."<br/>";

// get page info
// page-id: 140015579664087
//$pageInfo = file_get_contents('https://graph.facebook.com/140015579664087?access_token='.$accessToken);

// get comments 
//$cmt = file_get_contents('https://graph.facebook.com/100005135560209_677025992478580/comments?access_token='.$accessToken);
$cmt = '{
  "data": [
    {
      "created_time": "2016-12-30T02:30:20+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "hello~",
      "id": "677025992478580_688282711352908"
    },
    {
      "created_time": "2016-12-30T02:32:08+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "[ng minh tú] - nữ - 29/7/1997 - 1h10 - hà nội",
      "id": "677025992478580_688283248019521"
    }
  ],
  "paging": {
    "cursors": {
      "before": "WTI5dGJXVnVkRjlqZAFhKemIzSTZAOamc0TWpneU56RXhNelV5T1RBNE9qRTBPRE13TmpVd01qQT0ZD",
      "after": "WTI5dGJXVnVkRjlqZAFhKemIzSTZAOamc0TWpnMU5qQTRNREU1TWpnMU9qRTBPRE13TmpVMk1qaz0ZD"
    }
  }
}';
//echo $cmt.'~~~~~';
$cmtAr = json_decode($cmt, true);

    switch (json_last_error()) {
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
    }

$cmtDataAr = $cmtAr['data'];
$cmtPages = $cmtAr['paging']['cursors'];

foreach ($cmtDataAr as $oneData) {
	$name = $oneData['from']['name'];
	$oauth_uid = $oneData['from']['id'];
	$_uname = trendCode($name);
	// create user with this id
	$_u = $login->create($oauth_uid, $name, $_uname);
	
	$mes = $oneData['message'];
	preg_match("/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})/", $mes, $bday);
	preg_match("/([01]?[0-9]|2[0-3])(\:|h)+([0-5][0-9])/", $mes, $bhour);
	preg_match("/(nam|nữ)( |-|,)/", $mes, $gender);
	// replace bday bhour from message
	$mess = preg_replace("/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})/", '', $mes);
	$mess = preg_replace("/([01]?[0-9]|2[0-3])(\:|h)+([0-5][0-9])/", '', $mess);
	$mess = preg_replace("/(nam|nữ)( |-|,)/", '', $mess);
	if (substr_count($mess, '-') > 0) {
		$mesAr = explode('-', $mess);
		$mesPl = $mesAr[count($mesAr)-1];
	} else $mesPl = $mess;
	// match birth-place
	preg_match("/(ở|nơi sinh)(.*)/", $mesPl, $bplace);
	// name of the chart
	preg_match("/\[(.*)\]/", $mess, $cname);
	$cname = $cname[1];
	echo $oauth_uid.'~~~'.$_u.'~~'.$name.'~~'.$cname.'<br/>';

	if ($bday[1] && $bhour[1] && $mesPl) {
		$bday = strtotime("{$bday[1]} ".date('F', mktime(0, 0, 0, $bday[2], 10))." {$bday[3]}");
		$bhour = (int)$bhour[1].':'.$bhour[3];
		if ($bplace) $bplace = $bplace[2];
		else $bplace = $mesPl;
		$gender = $gender[1];

		$url = MAIN_URL.'/pages/ville.php?city='.urlencode($bplace);
//		echo $bday.'~~~'.$bhour.'~~~~'.$gender.'~~~~~'.$bplace.'~~~'.$url.'<br/>';
		// get Longtitude/Latitude from birth place
		$data = file_get_contents($url);
//		echo $data.'~~~<br/>';
		$data = json_decode($data, true);
//		print_r($data);

		$valAr = 
			array(
				'aid' => null,
				'auid' => $_u,
				'uname' => $_uname,
				'uid' => $_u,
				'name' => $cname,
				'gender' => $gender,
				'birthday' => $bday,
				'birthhour' => $bhour,
				'timezone' 	=> $data['timezone'],
				'country' 	=> $data['country'],
				'town'	 	=> $data['city'],
				'long_deg' 	=> $data['long_deg'],
				'lat_deg' 	=> $data['lat_deg'],
				'long_min' 	=> $data['long_min'],
				'lat_min' 	=> $data['lat_min'],
				'ew' 		=> $data['ew_txt'],
				'ns' 		=> $data['ns_txt'],
			);
		print_r($valAr);
		$cIn = $chart->createChart($valAr, $_u);
		//print_r($cIn);
		if ($cIn) echo $cIn['link'];

	}
	echo '<br/><b>'.$mes.'</b><hr/>';
}