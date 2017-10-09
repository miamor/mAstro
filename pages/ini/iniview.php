<?
//$sections = array('overview', 'philosophy', 'planets', 'rising', 'sun', 'moon', 'mercury', 'venus', 'mars', 'jupiter', 'saturn', 'uranus', 'neptune', 'house', 'aspects', 'dominant');
if ($page == 'chart') $sections = array('sun', 'love', 'moon', 'rising', 'midheaven', 'planets', 'house', 'aspects');
else if ($page == 'transit') $sections = array('overview', 'transit');
else if ($page == 'relationship') $sections = array('overview', 'simple', 'advanced');

$iid = $chart->id;
$chart->getRates();
echo '<style>.page-chart{padding:0!important;margin:0;*overflow:hidden!important}
::-webkit-scrollbar{display:none}
body div ::-webkit-scrollbar{display:block}
.chart-v > .clearfix{display:none}</style>';

include_once '__initialize.'.$page.'.php';

if (!$_SESSION['show']) $_SESSION['show'] = 'top';
$show = $_SESSION['show'];
$sSelectedID = $_SESSION['source'];
$source->id = $sSelectedID;
$sSelected = $source->readOne();

$config->addJS('dist', 'ratings.min.js');
$config->addJS('dist', 'toc.min.js');
$config->addJS('dist', 'chart/v.chart.js');

// display the products if there are any
include_once 'pages/views/_temp/'.$page.'/view.php'; ?>

<script>var u = <? echo (isset($config->u)) ? $config->u : '0' ?>;
var au = <? echo $cIn['uid'] ?>;
var sources = lng = translators = others = '';
<? foreach ($lgAr as $lK => $lO) {
	if ($lK == $lg) echo "lng += '<option disabled value=\"{$lK}\">{$lO}</option>';";
	else echo "lng += '<option value=\"{$lK}\">{$lO}</option>';";
}
//$sList = $getRecord -> GET('source^id,title', "`lang` = '{$lg}' ");
$source->sList = array();
$source->readAll($lg);
$sList = $source->sList;
foreach ($sList as $sO) echo "sources += '<option value=\"s{$sO['id']}\">{$sO['title']}</option>';";
echo "me = '<option selected value=\"u".$config->me['id']."\">@".$config->me['username']." - Me</option>';";

$chart->tList = array();
$chart->getTranslators();
$tList = $chart->tList[1]; // translator
foreach ($tList as $tO) echo "translators += '<option value=\"u{$tO['id']}\">@{$tO['username']}</option>';";

$_tList = $chart->tList[0]; // !translator
foreach ($tList as $tO) echo "others += '<option value=\"u{$tO['id']}\">@{$tO['username']}</option>';"; ?>
</script>
