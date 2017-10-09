<?
include_once 'include/config.php';
header('Content-type: application/json; charset=utf-8');

include_once 'objects/login.php';
$login = new Login();

$helper = $fb->getRedirectLoginHelper();

try {
	$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

if (! isset($accessToken)) {
	if ($helper->getError()) {
		header('HTTP/1.0 401 Unauthorized');
		echo "Error: " . $helper->getError() . "\n";
		echo "Error Code: " . $helper->getErrorCode() . "\n";
		echo "Error Reason: " . $helper->getErrorReason() . "\n";
		echo "Error Description: " . $helper->getErrorDescription() . "\n";
	} else {
		header('HTTP/1.0 400 Bad Request');
		echo 'Bad request';
	}
	exit;
}

// Logged in
$_ar['status'] = 'success';
$_ar['token'] = $accessToken->getValue();

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
/*echo '<h3>Metadata</h3>';
var_dump($tokenMetadata);
*/
//print_r($tokenMetadata);

//$_ar['data'] = $tokenMetadata;


// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId($fbAppID); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
	// Exchanges a short-lived access token for a long-lived one
	try {
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		$_ar['response']['error'] = "Error getting long-lived access token: " . $helper->getMessage();
		exit;
	}

	$_ar['token'] = $accessToken->getValue();
}

$_SESSION['fb_access_token'] = (string) $accessToken;

if ($accessToken) {
	//redirect to retrieving data page

	// Retrieve user info
	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->get('/me?fields=id,name,email', $accessToken);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		$_ar['response']['error'] = 'Graph returned an error: ' . $e->getMessage();
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		$_ar['response']['error'] = 'Facebook SDK returned an error: ' . $e->getMessage();
	}
	$user = $response->getGraphNode();
	// save u session
	$_SESSION['uid'] = $user['id'];


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
	$login->login();

	header('location: '.MAIN_PATH.'/mee.php');
	//include 'me.php';
}

//echo json_encode($_ar);
