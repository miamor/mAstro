<section id="planets" class="hide">
	<div class="chart-report-head htitle"><? echo $lang['Sign positions of planets'] ?></div>
	<div class="chart-report-content">
<? for ($i = 2; $i <= 9; $i++) {
	$s_pos = floor($longitude1[$i] / 30) + 1;
	$deg = Reduce_below_30($longitude1[$i]);
	if ($ubt1 == 1 And $i == 1 And ($deg < 7.7 Or $deg > 22.3)) 
		continue;	 //if the Moon is too close to the beginning or the end of a sign, then do not include it
	$sigi = $sign_name[$s_pos];
	$plTitle = $pl_name[$i] . " in ".$sigi;
	$plReport = astro(trendCode($plTitle)) ?>
	<div class="module parallax">
		<div class="parallax-bg" style="background-image:url(<? echo zBg.'/zodiac-art-'.trendCode($sigi).'.jpg' ?>)"></div>
		<div class="paragraph" id="<? echo trendCode($plTitle) ?>" data-rid="<? echo $plReport['id'] ?>" data-trans-num="<? echo countTrans($plReport['id']) ?>">
			<h3><b><? echo $lang[$pl_name[$i]].' '.$lang['as^in'].' '.$lang[$sigi] ?></b></h3>
			<div class="chart-report-des"><? echo astro(trendCode($pl_name[$i]))['content'] ?></div>
			<div class="chart-paragraph-content"><? echo $plReport['content'] ?></div>
		</div>
	</div>
<? } ?>
	</div>
</section>
