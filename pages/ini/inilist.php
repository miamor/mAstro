<?
//$config->addJS('plugins', 'DataTables/datatables.min.js');
$config->addJS('dist', 'chart/list.js');
$config->addJS('dist', 'form.js');

$cListMy = $chart->readAll($config->u);
$cListOthers = $chart->readAll(-1);

// display the products if there are any
include_once 'pages/views/_temp/'.$page.'/list.php';
