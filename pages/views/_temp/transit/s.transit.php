<section class="hide" id="transit">
	<div class="chart-report-head htitle"><? echo $lang['Planetary transit aspects'] ?></div>
	<div class="chart-report-content">

<? if ($no_interps !== true) {
	// loop through each planet
	for ($i = 0; $i <= 5; $i++) {
		for ($j = 0; $j <= 9; $j++) {
			if (($i == 1) Or ($j == 1 And $ubt1 == 1)) continue;			// do not allow Moon aspects for transit planets, or for natal planets if birth time is unknown

			$da = Abs($L3[$i] - $L1[$j]);
			if ($da > 180) $da = 360 - $da;

			$orb = 2.0;				//orb = 2.0 degree

			// are planets within orb?
			$q = 1;
			if ($da <= $orb) $q = 2;
			else if (($da <= 60 + $orb) And ($da >= 60 - $orb)) $q = 3;
			else if (($da <= 90 + $orb) And ($da >= 90 - $orb)) $q = 4;
			else if (($da <= 120 + $orb) And ($da >= 120 - $orb)) $q = 5;
			else if ($da >= 180 - $orb) $q = 6;

			if ($q > 1) {
				if ($q == 2) $aspect = "Conjunct";
				else if ($q == 6) $aspect = "Opposite";
				else if ($q == 3) $aspect = "Sextile";
				else if ($q == 4) $aspect = "Square";
				else if ($q == 5) $aspect = "Trine";

				$tTitle = $pl_name[$i].' '.$aspect.' '.$pl_name[$j];
				$pos = Convert_Longitude($L3[$i]) . " " . Mid($rx3, $i + 1, 1) ?>
			<div class="paragraph" id="<? echo trendCode($tTitle) ?>" data-rid="<? echo astro(trendCode($tTitle))['id'] ?>" data-trans-num="<? echo countTrans(astro(trendCode($tTitle))['id']) ?>">
				<h3><b><? echo $lang[$pl_name[$i]].' <span class="gensmall">('.$pos.')</span> '.$lang[$aspect].' '.$lang[$pl_name[$j]] ?></b></h3>
				<div class="chart-paragraph-content"><? echo astro(trendCode($tTitle))['content'] ?></div>
			</div>
<?			}
		}
	}
}
?>
	</div>
</section>
