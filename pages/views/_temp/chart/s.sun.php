<? $sigi = $sunSign;
$pTitle = 'Sun In '.$sunSign;
$bd = (int)$month.$day;
//$getSegment = $getRecord -> GET('zodiac', "`sign` = '{$sunSign}' AND `vertex` = 0");
$chart->getZodiac($sunSign);
$getSegment = $chart->zSigns;
foreach ($getSegment as $sO) {
	$ss = (int)(substr($sO['start'], 2, 2).substr($sO['start'], 0, 2));
	$se = (int)(substr($sO['end'], 2, 2).substr($sO['end'], 0, 2));
	if ($bd >= $ss && $bd <= $se) {
		$segment = $sO['segment'];
		break;
	}
}
//$ver = getRecord('zodiac', "`sign` = '{$sigi}' AND `segment` = '{$segment}' ");
$ver = $chart->getZodiac($sigi, $segment);
$vs = (int)(substr($ver['start'], 2, 2).substr($ver['start'], 0, 2));
$ve = (int)(substr($ver['end'], 2, 2).substr($ver['end'], 0, 2));
$vertex = 0;
if ($bd >= $vs && $bd <= $ve) $vertex = $ver['vertex'];
$pTitleReport = astro(trendCode($pTitle));
$segmentReport = astro(trendCode('s'.$segment.'-'.$sigi));
$vertexReport = astro(trendCode('v'.$vertex.'-'.$sigi));
$dmReport = astro($day.$month);
//$desReport  = astro('sun') ?>
<section id="sun" class="hide">
	<div class="chart-report-head htitle"><? echo $lang['Overview your sun sign'] ?></div>
	<div class="chart-report-content">
		<div class="chart-report-des"><? echo $desReport['content'] ?></div>
	<div class="module parallax">
		<div class="parallax-bg" style="background-image:url(<? echo zBg.'/zodiac-art-'.trendCode($sunSign).'.jpg' ?>)"></div>
		<div class="paragraph" id="<? echo trendCode($pTitle) ?>" data-rid="<? echo $pTitleReport['id'] ?>" data-trans-num="<? echo countTrans($pTitleReport['id']) ?>">
			<h3><b><? echo $lang['Sun'].' '.$lang['as^in'].' '.$lang[$sunSign] ?></b></h3>
			<div class="chart-paragraph-content"><? echo $pTitleReport['content'] ?></div>
		</div>
	</div>
		<div class="paragraph" id="<? echo trendCode('s'.$segment.'-'.$sigi) ?>" data-rid="<? echo $segmentReport['id'] ?>" data-trans-num="<? echo countTrans($segmentReport['id']) ?>">
			<h3><b><? echo $lang[$sunSign].' '.$lang['as^in'].' '.$lang['segment'].' '.$segment ?></b></h3>
			<div class="chart-paragraph-content"><? echo $segmentReport['content'] ?></div>
		</div>
	<? if ($vertex != 0) { ?>
		<div class="paragraph" id="<? echo trendCode('v'.$vertex.'-'.$sigi) ?>" data-rid="<? echo $vertexReport['id'] ?>" data-trans-num="<? echo countTrans($vertexReport['id']) ?>">
			<h3><b><? echo $lang[$sunSign].' '.$lang['as^in'].' '.$lang['v'.$vertex] ?></b></h3>
			<div class="chart-paragraph-content"><? echo $vertexReport['content'] ?></div>
		</div>
	<? } ?>
		<div class="paragraph" id="<? echo $day.$month ?>" data-rid="<? echo $dmReport['id'] ?>" data-trans-num="<? echo countTrans($dmReport['id']) ?>">
			<h3><b><? echo $lang[$sunSign].' '.$lang['as^in'].' '.$day.' '.$lang[date('F', $cIn['birthday'])] ?></b></h3>
			<div class="chart-paragraph-content"><? echo $dmReport['content'] ?></div>
		</div>
	</div>
</section>
