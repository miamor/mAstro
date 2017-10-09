<?
//header('Content-Type: application/json; charset=utf-8');
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

//set url
//echo urldecode('https%3A%2F%2Fm.facebook.com%2Fcomment%2Freplies%2F%3Fctoken%3D677025992478580_688285194685993%26actor_id%3D100006049054406%26ft_ent_identifier%3D677025992478580%26gfid%3DAQBtU0JILF-XlltK%26refid%3D52%26__tn__%3DR&refsrc=https%3A%2F%2Fm.facebook.com%2Fcomment%2Freplies%2F').'<hr/>';

$url = $_GET['url'];
$url = 'https://m.facebook.com/login.php?next='.urlencode($url);
//echo $url.'<hr/>';
//$url = 'https://m.facebook.com/login.php?next=https%3A%2F%2Fm.facebook.com%2Fstory.php%3Fstory_fbid%3D677025992478580%26id%3D100005135560209%26p%3D'.$p.'&refsrc=https%3A%2F%2Fm.facebook.com%2Fstory.php&refid=52';

//set POST variables
$fields = array(
	'charset_test' => '€,´,€,´,水,Д,Є',
	'email' => 'miamorwest@gmail.com',
	'pass' => 'westlife297',
	'login' => 'Login'
);
$result = cURL($url, $fields);
echo $result;


//close connection
//curl_close($ch);