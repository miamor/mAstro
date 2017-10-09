<?
include_once 'include/config.php';
$config = new Config();

if (isset($_SESSION['fb_access_token']) && $_SESSION['fb_access_token']) {
	$accessToken = $_SESSION['fb_access_token'];
	include 'mee.php';
} else {
	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['public_profile,user_friends,email']; // Optional permissions
	$loginUrl = $helper->getLoginUrl('http://localhost/astro/fb-callback.php', $permissions);

	echo '<a href="' . htmlspecialchars($loginUrl) . '">'.$loginUrl.'</a>';

	echo 'Logging in...<script>window.location.href = "' . $loginUrl . '";</script>';

//	include 'fb-callback.php';
}