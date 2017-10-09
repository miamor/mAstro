<? if ($m) {
	$mData->uname = $config->me['username'];
	$mData->n = $m;
	$aIn = $mData->readOne();
	if ($aIn['id']) $_DATA = $aIn;
}
$config->addJS('dist', 'form.js');
$config->addJS('dist', 'profile/mastro_data.js');

$dList = $mData->readAll();

include 'pages/views/_temp/'.$page.'/v.'.$mode.'.php';