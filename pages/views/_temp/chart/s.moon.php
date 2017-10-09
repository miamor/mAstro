<? //	$sunSign = $sign_name[floor($longitude1[0] / 30) + 1];
//	$moonSign = $sign_name[floor($longitude1[1] / 30) + 1];
	$mTitle = trendCode('moon-in-'.$moonSign);
	$desMReport = astro('moon');
	$mReport = astro($mTitle);
	$msReport = astro(trendCode('moon-'.$moonSign.'-sun-'.$sunSign)) ?>
<section id="moon" class="hide">
	<div class="chart-report-head htitle"><? echo $lang['Moon sign'] ?></div>
	<div class="chart-report-content">
		<div class="chart-report-des"><? echo $desMReport['content'] ?></div>
	<div class="module parallax">
		<div class="parallax-bg" style="background-image:url(<? echo zBg.'/zodiac-art-'.trendCode($moonSign).'.jpg' ?>)"></div>
		<div class="paragraph" id="<? echo $mTitle ?>" data-rid="<? echo $mReport['id'] ?>" data-trans-num="<? echo countTrans($mReport['id']) ?>">
			<h3><b><? echo $lang[$pl_name[1]].' '.$lang['as^in'].' '.$lang[$moonSign] ?></b></h3>
			<div class="chart-paragraph-content"><? echo $mReport['content'] ?></div>
		</div>
	</div>
		<div class="paragraph" id="<? echo trendCode('moon-'.$moonSign.'-sun-'.$sunSign) ?>" data-rid="<? echo $msReport['id'] ?>" data-trans-num="<? echo countTrans($msReport['id']) ?>">
			<h3><b><? echo $lang['sun'].' '.$lang[$sunSign].' '.$lang['and'].' '.$lang['moon'].' '.$lang[$moonSign] ?></b></h3>
			<div class="chart-paragraph-content"><? echo $msReport['content'] ?></div>
		</div>
	</div>
</section>
