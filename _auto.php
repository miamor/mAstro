<?
header('Content-Type: application/json; charset=utf-8');
include_once 'include/config.php';

//
// change Facebook status with curl
// Thanks to Alste (curl stuff inspired by nexdot.net/blog)
function cURL ($url, $fields) {
//	global $ch;
	$ch = curl_init();	

	//set the url
	curl_setopt($ch,CURLOPT_URL, $url);

	if ($fields) {
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

	curl_close($ch);

	return $result;
}

function setFacebookStatus($status, $login_email, $login_pass, $debug=false) {
//	$ch = curl_init();	
	
	//CURL stuff
	//This executes the login procedure
	$url = 'https://m.facebook.com/login.php?m&amp;next=http%3A%2F%2Fm.facebook.com%2Fhome.php';
	$fields = array(
		'charset_test' => '€,´,€,´,水,Д,Є',
		'email' => $login_email,
		'pass' => $login_pass,
		'login' => 'Login'
	);
//	$page = cURL($url, $fields);
	$ch = curl_init();	

	//set the url
	curl_setopt($ch,CURLOPT_URL, $url);

	if ($fields) {
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
	$page = curl_exec($ch) or die(curl_error($ch));

	

	// match post form
	preg_match("/<form method=\"post\" action=\"(.*?)\">(.*?)<\/form>/", $page, $form);
	$urlPost = 'https://m.facebook.com'.$form[1];
	echo $form[2];
	// get input
	preg_match_all("/<input.*?name=\"(.*?)\"((?!\/|value).)\/>/", $form[2], $inputs);
	print_r($inputs);
	$postFields = array();
	foreach ($inputs[1] as $ik => $iv) {
		$iv .= '"';
		$iv = preg_replace("/class=\"(.*?)\"/", '', $iv);
		$iv = preg_replace("/id=\"(.*?)\"/", '', $iv);
		$ia = explode('"', $iv);
		$in = $ia[0];
		$ivl = (isset($ia[2])) ? $ia[2] : null;
		echo $in.'~~~~~'.$ivl.'<br/>';
		$postFields[$in] = $ivl;
	}
	$postFields['xc_message'] = $status;
	
	echo '<br/>'.$urlPost.'<br/>';
	
//	$post = cURL($urlPost, $postFields);

	//set the url
	curl_setopt($ch,CURLOPT_URL, $urlPost);

	if ($fields) {
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
	$post = curl_exec($ch) or die(curl_error($ch));
	
	echo $post.'~~~~~~~~~';
	
/*	for($i=0;$i<count($form_ar[0]);$i++)
		if(stristr($form_ar[0][$i],"post_form_id")) preg_match("/form action=\"(.*?)\"/", $page, $form_num);

	$strpost = 'post_form_id=' . $form_id[1] . '&status=' . urlencode($status) . '&update=' . urlencode($update[1]) . '&charset_test=' . urlencode($charset_test[1]) . '&fb_dtsg=' . urlencode($fb_dtsg[1]);
	if($debug) {
		echo "Parameters sent: ".$strpost."<hr>";
	}
	curl_setopt($ch, CURLOPT_POSTFIELDS, $strpost );

	//set url to form processor page
	curl_setopt($ch, CURLOPT_URL, 'http://m.facebook.com' . $form_num[1]);
	curl_exec($ch);

	if ($debug) {
		//show information regarding the request
		print_r(curl_getinfo($ch));
		echo curl_errno($ch) . '-' . curl_error($ch);
		echo "<br><br>Your Facebook status seems to have been updated.";
	}
*/	
	
	//close the connection
	curl_close($ch);
}


setFacebookStatus('Hello', 'miamorwest@gmail.com', 'westlife297');