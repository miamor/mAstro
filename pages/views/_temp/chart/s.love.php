<section id="love" class="hide">
	<div class="chart-report-head htitle"><? echo $lang['Sun'].' '.$lang[$sunSign].' '.$lang['and'].' '.$lang['love'] ?></div>
	<div class="chart-report-content">
	<div class="module parallax">
		<div class="parallax-bg" style="background-image:url(<? echo zBg.'/zodiac-art-'.trendCode($sunSign).'.jpg' ?>)"></div>
		<div class="paragraph" id="<? echo trendCode('love-'.$sunSign) ?>" data-rid="<? echo astro(trendCode('love-'.$sunSign))['id'] ?>" data-trans-num="<? echo countTrans(astro(trendCode('love-'.$sunSign))['id']) ?>">
			<h3><b>* <? echo $lang[$sunSign].' '.$lang['and'].' '.$lang['love'] ?></b></h3>
			<div class="chart-paragraph-content"><? echo astro(trendCode('love-'.$sunSign))['content'] ?></div>
		</div>
	</div>
<? $signAr = array('ARIES', 'TAURUS', 'GEMINI', 'CANCER', 'LEO', 'VIRGO', 'LIBRA', 'SCORPIO', 'SAGITTARIUS', 'CAPRICORN', 'AQUARIUS', 'PISCES');
for ($i = 0; $i < 12; $i++) {
	$sigi = $signAr[$i]; ?>
	<div class="module parallax">
		<div class="parallax-bg" style="background-image:url(<? echo zBg.'/zodiac-art-'.trendCode($sigi).'.jpg' ?>)"></div>
		<div class="paragraph" id="<? echo 'love-sun-'.$sigi ?>" data-rid="<? echo astro(trendCode('love-'.$sunSign.'-'.$sigi))['id'] ?>" data-trans-num="<? echo countTrans(astro('love-'.$sunSign.'-'.$sigi)['id']) ?>">
			<h3><b><? echo $lang[$sunSign].' '.$lang['and'].' '.$lang[$sigi] ?></b></h3>
			<div class="chart-paragraph-content"><? echo astro('love-'.$sunSign.'-'.$sigi)['content'] ?></div>
		</div>
	</div>
<? } ?>
	</div>
</section>
