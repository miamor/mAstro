<? if ($ubt1 == 0) {
//	$s_pos = floor($hc1[10] / 30) + 1;
//	$mc = $sign_name[$s_pos];
	$mcCode = 'mc-'.trendCode($mc);
	$mcSunCode = $mcCode.'-sun-'.trendCode($sunSign);
	$desMCReport = astro('mc');
	$mcsReport = astro(trendCode($mcSunCode));
	$mcReport = astro($mcCode) ?>
<section id="midheaven" class="hide">
	<div class="chart-report-head htitle"><? echo $lang['Midheaven'] ?></div>
	<div class="chart-report-content">
		<div class="chart-report-des"><? echo $desMCReport['content'] ?></div>
	<div class="module parallax">
		<div class="parallax-bg" style="background-image:url(<? echo zBg.'/zodiac-art-'.trendCode($mc).'.jpg' ?>)"></div>
		<div class="paragraph" id="<? echo $mcCode ?>" data-rid="<? echo $mcReport['id'] ?>" data-trans-num="<? echo countTrans($mcReport['id']) ?>">
			<h3><b><? echo $lang['mc-before'] ?> <? echo $lang[$mc] ?> <? echo $lang['mc'] ?></b></h3>
			<div class="chart-paragraph-content"><? echo $mcReport['content'] ?></div>
		</div>
	</div>
		<div class="paragraph" id="<? echo trendCode($mcSunCode) ?>" data-rid="<? echo $mcsReport['id'] ?>" data-trans-num="<? echo countTrans($mcsReport['id']) ?>">
			<h3><b><? echo $lang['mc_before'].' '.$lang[$mc].$lang['mc_after'].' '.$lang['and'].' '.$lang['sun'].' '.$lang[$sunSign] ?></b></h3>
			<div class="chart-paragraph-content"><? echo $mcsReport['content'] ?></div>
		</div>
	</div>
</section>
<? } ?>
