<? 	//include MAIN_PATH.'/header.php';
include_once 'objects/login.php';

$login = new Login();
$pageTitle = 'Logout';

if (!$do && !$v && !$temp) include 'pages/views/_temp/header.php';

if (!$config->u) echo '<div class="alerts alert-error">You are not logged in.</div>';
else {
//$act = get('act');
$memFb = 0 ?>

<div class="goodbye">We'll miss you!</div>

<? //if ($memFb == 0 || $act == 'logout') {
//	$useR = $member['id'];
//	changeValue('members', "`id` = '{$u}' ", "`lastlog_time` = '{$current}', `online` = '0' ");

	$login->logout();
	session_destroy();
	echo '<script>window.history.back()</script>';
} ?>
