<?
include_once 'include/config.php';
header('Content-type: application/json; charset=utf-8');

include_once 'objects/login.php';
$login = new Login();

$accessToken = isset($_SESSION['fb_access_token']) ? $_SESSION['fb_access_token'] : null;

/*$fb = new Facebook\Facebook([
	'app_id' => $fbAppID,
	'app_secret' => $fbAppSecret,
	'default_access_token' => $accessToken,
	'enable_beta_mode' => true,
	'default_graph_version' => 'v2.5',
]);
*/

// Retrieve user info
try {
	// Returns a `Facebook\FacebookResponse` object
	$response = $fb->get('/me?fields=id,name,email', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	$_ar['response']['error'] = 'Graph returned an error: ' . $e->getMessage();
	//exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	$_ar['response']['error'] = 'Facebook SDK returned an error: ' . $e->getMessage();
	//exit;
}
if (isset($response)) {
	$user = $response->getGraphNode();
	/* handle the result */
	// save u session
	$_SESSION['uid'] = $user['id'];

	// Retrive user friends
	/*$request = new Facebook\FacebookRequest($fbApp, $accessToken, 'GET', '/me/friends');
	// Send the request to Graph
	try {
		$response = $fb->getClient()->sendRequest($request);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		$_ar['response']['error'] = 'Graph returned an error: ' . $e->getMessage();
		//exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		$_ar['response']['error'] = 'Facebook SDK returned an error: ' . $e->getMessage();
		//exit;
	}
	$friends = $response->getGraphEdge();
	---*
	$friends = file_get_contents('https://graph.facebook.com/me/friends?access_token='.$accessToken);
	$friends = json_decode($friends, true);
	*/

	// retrieve user avatar
	//$avatar = file_get_contents('https://graph.facebook.com/me/picture?type=large&access_token='.$accessToken);
	$avatar = file_get_contents('https://graph.facebook.com/me/picture?width=74&redirect=false&access_token='.$accessToken);
	/* handle the result */
	$avatar = json_decode($avatar, true);
	$avatar = $avatar['data']['url'];


	// login
	$login->uid = $user['id'];
	$login->token = $accessToken;
	$login->name = $name = $user['name'];
	$login->uname = $uname = trendCode($name);

	$login->avatar = $avatar;
	$login->loginFb();


	// save retrieved data
	/*$_ar = array(
		'c2array' => true,
		'id' => $user['id'],
		'name' => $user['name'],
		'username' => $uname,
		'avatar' => $avatar,
		'friends' => $friends,
	);
	*/

	$_ar = '{
		"c2array": true,
		"size": [4, 1, 1],
		"data": [
			["'.$user['id'].'"],
			["'.$user['name'].'"],
			["'.$uname.'"],
			["'.$avatar.'"]
		]
	}';
	echo $_ar;
} else echo 'No response';

// print retrieved data
//echo json_encode($_ar);
