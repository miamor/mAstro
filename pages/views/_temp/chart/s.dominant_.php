<? //$chartRuler = $crAr[$rising];
$plRising = $crAr[$rising];
$plRar = explode('|', $plRising);
$chartRuler = $plRar[0];

$longitude[LAST_PLANET + 1] = $hc1[1];
$longitude[LAST_PLANET + 2] = $hc1[10];
foreach ($plRar as $plr) $plAr[$plr]++;
for ($i = 0; $i <= LAST_PLANET + 1; $i++) {
	$s_pos = floor($longitude1[$i] / 30) + 1;
	$sigi = $sign_name[$s_pos];
	$pln = $pl_name[$i];
	$j = LAST_PLANET + 1;
		$q = 0;
		$da = Abs($longitude1[$i] - $longitude1[$j]);

		if ($da > 180) $da = 360 - $da;

		// set orb - 8 if Sun or Moon, 6 if not Sun or Moon
		if ($i == 0 Or $i == 1 Or $j == 0 Or $j == 1) $orb = 8;
		else $orb = 6;

		// is there an aspect within orb?
		if ($da <= $orb) $q = 1;
		elseif (($da <= (60 + $orb)) And ($da >= (60 - $orb))) $q = 6;
		elseif (($da <= (90 + $orb)) And ($da >= (90 - $orb))) $q = 4;
		elseif (($da <= (120 + $orb)) And ($da >= (120 - $orb))) $q = 3;
		elseif (($da <= (150 + $orb)) And ($da >= (150 - $orb))) $q = 5;
		elseif ($da >= (180 - $orb)) $q = 2;
		if ($q > 0) $plAr[$plr]++;
}

arsort($hsAr);
$hAr = array_keys($hsAr);
$dominant_house = $hAr[0];

arsort($plAr);
$pAr = array_keys($plAr);
$dominant_planet = $pAr[0];

$sigAr[$rising]++;
arsort($sigAr);
$siAr = array_keys($sigAr);
$dominant_sign = $siAr[0];
//print_r($sigAr);
//print_r($plAr);
//print_r($hsAr);

foreach ($trinityHse as $tk => $tAr) {
	if (in_array($dominant_house, $tAr)) $tHse = $tk;
}
foreach ($nameHse as $nk => $nAr) {
	if (in_array($dominant_house, $nAr)) $nHse = $nk;
}

$crTitle = trendCode('chart-ruler-'.$chartRuler);
$sTitle = trendCode('dominant-sign-'.$dominant_sign);
$pTitle = trendCode('dominant-planet-'.$dominant_planet);
$hTitle = trendCode('dominant-house-'.$dominant_house);
$hTitleT = trendCode('dominant-house-'.$tHse);
$hTitleN = trendCode('dominant-house-'.$nHse); ?>
<section id="dominant" class="hide">
	<div class="chart-report-head htitle"><? echo $lang['Dominants'] ?></div>
	<div class="chart-report-content">
		<div class="alerts alert-warning"><b>Note</b> This section is being under experiment, calculation might be incorrect. If you're willing to help us improve this, please see <a href="">this</a>.</div>
		<div class="paragraph" id="<? echo $crTitle ?>" data-rid="<? echo astro($crTitle)['id'] ?>" data-trans-num="<? echo countTrans(astro($crTitle)['id']) ?>">
			<h3><b><? echo 'Chart ruler: '.$lang[$chartRuler] ?></b></h3>
			<div class="chart-paragraph-content"><? echo astro($crTitle)['content'] ?></div>
		</div>
	<div class="module parallax">
		<div class="parallax-bg" style="background-image:url(<? echo zBg.'/zodiac-art-'.trendCode($dominant_sign).'.jpg' ?>)"></div>
		<div class="paragraph" id="<? echo $sTitle ?>" data-rid="<? echo astro($sTitle)['id'] ?>" data-trans-num="<? echo countTrans(astro($sTitle)['id']) ?>">
			<h3><b><? echo 'Domiant sign: '.$lang[$dominant_sign] ?></b></h3>
			<div class="chart-paragraph-content"><? echo astro($sTitle)['content'] ?></div>
		</div>
	</div>
		<div class="paragraph" id="<? echo $pTitle ?>" data-rid="<? echo astro($pTitle)['id'] ?>" data-trans-num="<? echo countTrans(astro($pTitle)['id']) ?>">
			<h3><b><? echo 'Domiant planet: '.$lang[$dominant_planet] ?></b></h3>
			<div class="chart-paragraph-content"><? echo astro($pTitle)['content'] ?></div>
		</div>

		<div class="paragraph" id="<? echo $hTitle ?>" data-rid="<? echo astro($hTitle)['id'] ?>" data-trans-num="<? echo countTrans(astro($hTitle)['id']) ?>">
			<h3><b><? echo 'Domiant house: '.$lang['house'].' '.$dominant_house ?></b></h3>
			<div class="chart-paragraph-content"><? echo astro($hTitle)['content'] ?></div>
		<div class="chart-report-des" id="<? echo $hTitleT ?>" data-rid="<? echo astro($hTitleT)['id'] ?>" data-trans-num="<? echo countTrans(astro($hTitleT)['id']) ?>">
			<h4><b><? echo 'Domiant house belongs to '.$tHse.' house' ?></b></h4>
			<? echo astro($hTitleT)['content'] ?>
		</div>
		<div class="chart-report-des" id="<? echo $hTitleN ?>" data-rid="<? echo astro($hTitleN)['id'] ?>" data-trans-num="<? echo countTrans(astro($hTitleN)['id']) ?>">
			<h4><b><? echo 'Domiant house belongs to '.$nHse.' house' ?></b></h4>
			<? echo astro($hTitleN)['content'] ?>
		</div>
		</div>
	</div>
</section>
