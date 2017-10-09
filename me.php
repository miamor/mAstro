<?
include_once 'include/config.php';
header('Content-type: application/json; charset=utf-8');

include_once MAIN_PATH.'/objects/login.php';
$login = new Login();

$accessToken = $_SESSION['fb_access_token'];
$config->u = $u = $_SESSION['uid'];
$config->token = $accessToken;
$meInfo = $config->getUserInfo();

$_ar = '{
    "c2array": true,
    "size": [5, 1, 1],
    "data": [
		[
			["'.$u.'"]
		],
		[
			["'.$accessToken.'"]
		],
		[
			["'.$meInfo['name'].'"]
		],
		[
			["'.$meInfo['username'].'"]
		],
		[
			["'.$meInfo['avatar'].'"]
		]
	]
}';
echo $_ar;

// print retrieved data
//echo json_encode($_ar);
