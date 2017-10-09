<? 	//include MAIN_PATH.'/header.php';

if (!$config->u) echo '<div class="alerts alert-warning">You are not logged in.</div>';
else {
//$act = get('act');
$memFb = 0 ?>

<div class="goodbye">We'll miss you!</div>

<? //if ($memFb == 0 || $act == 'logout') {
//	$useR = $member['id'];
//	changeValue('members', "`id` = '{$u}' ", "`lastlog_time` = '{$current}', `online` = '0' ");

	$login->logout();
	session_destroy();
//	echo '<script>window.history.back()</script>';
} ?>
