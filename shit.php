<?
header('Content-Type: application/json; charset=utf-8');


$ch = curl_init();	

// Get user comments
$url = 'https://m.facebook.com/login.php?next=https%3A%2F%2Fm.facebook.com%2Fstory.php%3Fstory_fbid%3D677025992478580%26id%3D100005135560209%26p%3D'.$p.'&refsrc=https%3A%2F%2Fm.facebook.com%2Fstory.php&refid=52';
// login
	$fields = array(
		'charset_test' => '€,´,€,´,水,Д,Є',
		'email' => 'miamorwest@gmail.com',
		'pass' => 'westlife297',
		'login' => 'Login'
	);
//	$page = cURL($url, $fields);

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
	$page = curl_exec($ch) or die(curl_error($ch));




// get comments
	$url = 'https://mobile.facebook.com/login.php?next=https%3A%2F%2Fmobile.facebook.com%2Fcomment%2Freplies%2F%3Fctoken%3D677025992478580_689974097850436%26actor_id%3D100006049054406%26ft_ent_identifier%3D677025992478580%26gfid%3DAQBtn_sMWyUpMpEu%26_rdr&refsrc=https%3A%2F%2Fmobile.facebook.com%2Fcomment%2Freplies%2F';
	
//	echo $page.'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~';
	preg_match("/<form.*?action=\"(.*?)\"><input type=\"hidden\" name=\"fb_dtsg\" value=\"(.*?)\"(.*?)<\/form>/s", $page, $matches);
	print_r($matches);
	$fb_dtsg = $matches[2];

	
	
//	$cmtUrl = 'https://mobile.facebook.com/a/comment.php?parent_comment_id=689974097850436&parent_redirect_comment_token=677025992478580_689974097850436&fs=0&comment_logging&ft_ent_identifier=677025992478580&gfid=AQB2wZlHgrcVgD0R&amp;av=100006049054406';
	$cmtUrl = 'https://mobile.facebook.com'.str_replace('&amp;', '&', $matches[1]);
	$fields = array (
		'fb_dtsg' => $fb_dtsg,
		'comment_text' => 'Fuck yaaaaaaaa!'
	);
//	echo $cmtUrl.'~~~~';
	curl_setopt($ch,CURLOPT_URL, $cmtUrl);

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
	$post = curl_exec($ch) or die(curl_error($ch));
	
//	echo $post.'~~~~~~~~~';

	
curl_close($ch);
