<? include_once 'objects/chat.php';
$chat = new Chat();

$params = ($config->get('p')) ? $config->get('p') : null;
if ($params) {
	$paramsD = mc_decrypt($params, ENCRYPTION_KEY);
//	$pAr = explode('&', $pAr);
	$chat->teamID = $tmID = preg_match('/t=|&/', $paramsD);
	$chat->roomID = $tID = preg_match('/r=|&/', $paramsD);
} else $chat->teamID = $chat->roomID = 0;

if ($do) include 'system/chat/'.$do.'.php';
else include 'views/_temp/chat/index.php';
