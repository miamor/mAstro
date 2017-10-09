<?
header('Content-Type: application/json; charset=utf-8');
include_once 'include/config.php';
include 'include/simple_html_dom.php';
include_once 'objects/login.php';
include_once 'objects/chart.php';

$login = new Login();
$chart = new Chart();

$ch = curl_init();

function cURL ($url, $fields) {
	global $ch;

	//set the url
	curl_setopt($ch,CURLOPT_URL, $url);

	if ($fields) {
		$fields_string = '';
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
		// set number of POST vars, POST data
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	}

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset: utf-8','Accept-Language: en-us,en;q=0.7,bn-bd;q=0.3','Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5')); 
	curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd ());
	curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd ());
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, "user_agent");
	curl_setopt($ch, CURLOPT_REFERER, "http://m.facebook.com");

	//execute post
	$result = curl_exec($ch) or die(curl_error($ch));

	return $result;
}


function getData ($_uname, $name, $mes) {
	global $login;
	$_u = $login->create('', $name, $_uname);

	preg_match("/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})/", $mes, $bday);
	preg_match("/([01]?[0-9]|2[0-3])(\:|h)+([0-5][0-9])/", $mes, $bhour);
	preg_match("/(nam|nữ)( |-|,|$)/", $mes, $gender);
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
//	$cname = (isset($cname[1])) ? $cname[1] : $name.' - '.date("d-m-y h:i:s");
	$cname = (isset($cname[1])) ? $cname[1] : null;

	if ($bday[1] && $bhour[1] && $mesPl && $cname && $gender) {
		$bday = strtotime("{$bday[1]} ".date('F', mktime(0, 0, 0, $bday[2], 10))." {$bday[3]}");
		$bhour = (int)$bhour[1].':'.$bhour[3];
		if ($bplace) $bplace = $bplace[2];
		else $bplace = $mesPl;
		$gender = (!isset($gender[1]) || $gender[1] == 'nữ') ? 'f' : 'm';

		$url = MAIN_URL.'/pages/ville.php?city='.urlencode($bplace);
		// get Longtitude/Latitude from birth place
		$data = file_get_contents($url);
		$data = json_decode($data, true);

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
		return $valAr;
	}
	return false;
}


function process ($result) {
	global $chart;
	// use regex to get comments
	//preg_match_all("|<[^>]+>(.*)</[^>]+>|U", $result, $matches);
	
	//echo $result.'~~~~~~~~~~~~~~~~~~~~~~~~~~~';
	preg_match_all("/<div class=\"_55wr\" id=\"(.*?)\"><div><h3><a class=\".*?\" href=\"\/(.*?)\?.*?\">(.*?)<\/a><\/h3><div>(.*?)<\/div><div class=\".*?\">.*?<a href=\"(\/comment\/replies\/\?ctoken=(.*?)_.*?\&amp\;actor_id=(.*?)\&.*?\&amp\;gfid=(.*?)\&.*?)\#comment_form_(.*?)_.*?_reply_.*?_.*?\">.*?<\/a>.*?<\/div><\/div>/s",$result, $matches);
	//print_r($matches);

	$total = count($matches[0]);
	if ($total > 0) {
		$dataAr = array();
		for ($i = 0; $i < $total; $i++) {
			$_uname = $matches[2][$i];
			$name = $matches[3][$i];
			$cmtCont = $matches[4][$i];

			$cmt_id = $matches[1][$i];
			$pid = $matches[6][$i];
			$u_post = $matches[7][$i];
			$gfid = $matches[8][$i];
			$pAu_id = $matches[9][$i];
			$cmtPageUrl = 'https://mobile.facebook.com'.str_replace('&amp;', '&', $matches[5][$i]);
//			$cmtPageUrl = 'https://m.facebook.com/comment/replies/?ctoken=677025992478580_688285194685993&actor_id=100006049054406&ft_ent_identifier=677025992478580&gfid=AQBtU0JILF-XlltK&refid=52&__tn__=R&refsrc=https://m.facebook.com/comment/replies/';

			$data = getData($_uname, $name, $cmtCont);
			/*if ($data == -1) {
				$dataAr[$i]['response'] = 'Báo cáo của bạn không thể tạo. Lỗi có thể do thông tin của bạn chưa đầy đủ hoặc chưa hợp lệ, hoặc hệ thống không thể xử lý thông tin của bạn. Chúng tôi xin lỗi về sự bất tiện này. Chúng tôi sẽ xem xét và phản hồi lại sớm nhất có thể.';
			} else*/ if ($data) {
				$dataAr[$i]['uname'] = $_uname;
				$dataAr[$i]['name'] = $name;
				$dataAr[$i]['cmt'] = $cmtCont;
				$dataAr[$i]['data'] = $data;
				$dataAr[$i]['pAu_id'] = $pAu_id;
				$dataAr[$i]['cmtPageUrl'] = $cmtPageUrl;
				$_u = $data['auid'];
				$cIn = $chart->createChart($data, $_u, true);
				
				$dataAr[$i]['reply']['pid'] = $pid;
				$dataAr[$i]['reply']['cmt_id'] = $cmt_id;
				$dataAr[$i]['reply']['u_post'] = $u_post;
				$dataAr[$i]['reply']['gfid'] = $gfid;
				
//				$dataAr[$i]['reply']['url'] = 'https://m.facebook.com/a/comment.php?parent_comment_id='.$cmt_id.'&parent_redirect_comment_token='.$pid.'_'.$cmt_id.'&fs=0&comment_logging&ft_ent_identifier='.$pid.'&gfid=AQAb1FdraWoA95-G&av='.$u_post;
				if ($cIn) 
					$dataAr[$i]['reply']['response'] = $response = 'Báo cáo của bạn đã được tạo thành công tại link này: '.$cIn['link'].'. Cảm ơn bạn đã sử dụng hệ thống. Chúc mừng năm mới!';
				else $dataAr[$i]['reply']['response'] = $response = 'Báo cáo của bạn không thể tạo. Lỗi có thể do hệ thống không xử lý được thông tin của bạn hoặc hệ thống đang quá tải, chúng tôi xin lỗi về sự bất tiện này. Báo cáo của bạn sẽ được tạo tay trong 24h tới.';

				// get reply page to get form and hidden input (token)
//				echo '<br/>Manual: '.$cmtPageUrl.'<br/>Regex: '.$matches[5][$i];
//				echo '<hr/>'.MAIN_URL.'/auto2.php?url='.urlencode($cmtPageUrl).'<hr/>';
//				$cmtPage = cURL(MAIN_URL.'/auto2.php?url='.urlencode($cmtPageUrl));
				$cmtPage = cURL($cmtPageUrl);
				//echo $cmtPageUrl.'~~~~~~'.$cmtPage;
				
				// check if response is submitted
				preg_match_all('/<div class=\"_55wr\" id=\"(.*?)\">.*?<a.*?href=\"\/(miamor.east).*?\">(Miamor East)<\/a>.*?Báo cáo.*?/', $cmtPage, $report);
				//print_r($report);
				
				// if no response
				if (count($report[0]) <= 0) {
					// get comment form
					preg_match('/<form method=\"post\" action=\"(.*?)\"><input type=\"hidden\" name=\"fb_dtsg\" value=\"(.*?)\".*?>.*?<input.*?name=\"comment_text\".*?<\/form>/', $cmtPage, $formData);
					$cmtFields = array(
						'fb_dtsg' => $formData[2],
						'comment_text' => $response,
					);
					//print_r($formData);

					$cmtUrl = 'https://mobile.facebook.com'.str_replace('&amp;', '&', $formData[1]);
					$reply = cURL($cmtUrl, $cmtFields);
					
					//echo $reply;
				}
			}
		}
		return $dataAr;
	} return -1;
	return 0;
}

function reply ($repData) {
/*	$url = 'https://m.facebook.com/comment/replies/?ctoken=677025992478580_688284641352715&actor_id=100006049054406&ft_ent_identifier=677025992478580';
	//set POST variables
	$fields = array(
		'comment_text' => 'shit'
	);
	$result = cURL($url, $fields);
	echo $url.'~~~~'.$result;
*/
}


function getPageFB ($url) {
	$url = 'https://mobile.facebook.com/login.php?next='.urlencode($url);
	$fields = array(
		'charset_test' => '€,´,€,´,水,Д,Є',
		'email' => 'miamorwest@gmail.com',
		'pass' => 'westlife297',
		'login' => 'Login'
	);
	$result = cURL($url, $fields);
	if ($result) return $result;
	return false;
}


//set url
$saved_k = (isset($_SESSION['k'])) ? ((int)$_SESSION['k']-1) : 0;
$p = $saved_k*10;
$_SESSION['k'] = $saved_k+1;
echo $saved_k.'~~'.$p;
$url = 'https://mobile.facebook.com/login.php?next=https%3A%2F%2Fmobile.facebook.com%2Fstory.php%3Fstory_fbid%3D677025992478580%26id%3D100005135560209%26p%3D'.$p.'&refsrc=https%3A%2F%2Fmobile.facebook.com%2Fstory.php&refid=52';

//set POST variables
$fields = array(
	'charset_test' => '€,´,€,´,水,Д,Є',
	'email' => 'miamorwest@gmail.com',
	'pass' => 'westlife297',
	'login' => 'Login'
);
$result = cURL($url, $fields);

if ($result) {
	$dataAr = process($result);

	if ($dataAr != -1) {
		reply($dataAr['reply']);
		
		$loop = true;
		$k = $saved_k+1;
		while ($loop == true) {
			$p = $k*10;
			// p=10
			$url = 'https://mobile.facebook.com/story.php?story_fbid=677025992478580&id=100005135560209&p='.$p;
			$result = cURL($url);
			$_dataAr = process($result);
			if ($_dataAr != -1) {
				$dataAr = array_filter(array_values(array_merge($dataAr, $_dataAr)));
				$k++;
				$_SESSION['k'] = $k;
			} else {
				//$k = $saved_k;
				$loop = false;
			}
		}
	}

	// all data
	print_r($dataAr);
}

$_SESSION['k'] = 1;

//close connection
curl_close($ch);