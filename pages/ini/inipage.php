<?
$chart->tb = $page;

// get ID of the product to be edited
//$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

//$f = ($config->get('f') !== null) ? $config->get('f') : null;
$mode = ($config->get('mode') !== null) ? $config->get('mode') : null;
if (isset($n) && $n) {
	$chart->uname = $n;
	$chart->n = ($__pageAr[2] !== null) ? $__pageAr[2] : null;
	$cIn = $chart->readOne();
	extract($cIn);
	// Reset $id to ID property of product
	$chart->id = isset($id) ? $id : null;
	$chart->link = isset($link) ? $link : null;
	if ($chart->id) {
		if (     ($cIn['stt'] === 0 && $config->me['username'] === $chart->uname) // only me
			||  $cIn['stt'] === -1 // Public
			||  ($cIn['stt'] === 1 && in_array($config->u, $chart->author['friends'])) // Friends
		   ) {
			$allowView = true;
			$pageTitle = $cIn['name'].' - '.$chart->uname.'\'s '.$page;
		} else {
			$allowView = false;
			$pageTitle = 'Access restricted';
		}
	} else {
		$pageTitle = 'Error';
	}
	
	include_once 'objects/report.php';
	$report = new Report();
	
	include_once 'objects/source.php';
	$source = new Source();
} else $pageTitle = ucfirst($page);

if (!$do && !$v && !$temp) include 'pages/views/_temp/header.php';

if ($do) include 'pages/system/'.$page.'/'.$do.'.php';
else if (!$temp) {
	if ($n) {
		if (isset($id) && $id) {
			if ($v == 'pdf') include 'pages/ini/pdf.chart.php';
			else if ($v == 'pdf_data') include 'pages/ini/pdf.chart.html_data.php';
			else if ($mode == 'edit') {
				if ($config->u) include 'pages/views/'.$page.'/'.$mode.'.php';
				else echo '<div class="alerts alert-warning">You have no permisson to access this page.</div>';
			} else {
				if ($allowView === true) {
					$chart->updateView();
					include 'pages/ini/iniview.php';
				} else echo '<div class="alerts alert-warning">You have no permisson to access this data.</div>';
			} 
		} else include 'pages/views/_temp/error.php';
	} else if ($mode == 'new' /*&& $config->u*/) include 'pages/views/'.$page.'/new.php';
	else include 'pages/ini/inilist.php';
//	else if (!$config->u) echo '<div class="alerts alert-warning">You have no permisson to access this page.</div>';
}
