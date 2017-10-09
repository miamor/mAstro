<? 
// include object files
include_once 'objects/report.php';
$report = new Report();
include_once 'objects/source.php';
$source = new Source();

// get ID of the product to be edited
//$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

//$f = ($config->get('f') !== null) ? $config->get('f') : null;
$mode = ($config->get('mode') !== null) ? $config->get('mode') : null;
if (isset($n) && $n) {
	$report->id = $n;
	$dIn = $report->readOne();
	$id = $report->id;
//	$report->link = $link;

	$pageTitle = ucfirst(str_replace('-', ' ', $dIn['code'])).' - '.$dIn['sid'];

	$pLikesAr = $pDislikesAr = array();
	if ($dIn['likes']) $pLikesAr = explode(',', $dIn['likes']);
	$pLikes = count($pLikesAr);
	if ($dIn['dislikes']) $pDislikesAr = explode(',', $dIn['dislikes']);
	$pDislikes = count($pDislikesAr);
	if ($pLikes === 0 && $pDislikes === 0) $pLikesWidth = $pDislikesWidth = 0;
	else {
		$pLikesWidth = round($pLikes/($pLikes + $pDislikes), 4)*100;
		$pDislikesWidth = round($pDislikes/($pLikes + $pDislikes), 4)*100;
	}
	$vote = $pLikes - $pDislikes;
	$pFavAr = $sFavAr = explode(',', $dIn['fav']);
	if ($dIn['fav']) $pFav = count($pFavAr);
	else $pFav = 0;
	$sFav = $pFav;
} else $pageTitle = 'Reports library';

if (!$do && !$v && !$temp) include 'pages/views/_temp/header.php';

if ($id) {
	if ($do) include 'system/'.$page.'/'.$do.'.php';
	else if ($type) include 'views/'.$page.'/v.'.$type.'.php';
	else include 'views/'.$page.'/view.php';
} else include 'views/'.$page.'/list.php';
