<? $desAReport = astro('aspect');
$aspectReport = astro(trendCode($aTitle)) ?>
	<section id="aspect" class="hide">
		<div class="chart-report-head htitle"><? echo $lang['Planetary aspects'] ?></div>
		<div class="chart-report-content">
			<div class="chart-report-des"><? echo $desAReport['content'] ?></div>
<?	for ($i = 0; $i <= 8; $i++) {
		for ($j = $i + 1; $j <= 9; $j++) {
			if (($i == 1 Or $j == 1 Or $j == 10) And $ubt1 == 1) 
				continue;			// do not allow Moon aspects or Ascendant aspects if birth time is unknown

			$da = Abs($longitude1[$i] - $longitude1[$j]);
			if ($da > 180) $da = 360 - $da;

			// set orb - 8 if Sun or Moon, 6 if not Sun or Moon
			if ($i == 0 Or $i == 1 Or $j == 0 Or $j == 1) $orb = 8;
			else $orb = 6;

			// are planets within orb?
			$q = 1;
			if ($da <= $orb) $q = 2;
			else if (($da <= 60 + $orb) And ($da >= 60 - $orb)) $q = 3;
			else if (($da <= 90 + $orb) And ($da >= 90 - $orb)) $q = 4;
			else if (($da <= 120 + $orb) And ($da >= 120 - $orb)) $q = 5;
			else if ($da >= 180 - $orb) $q = 6;

			if ($q > 1) {
				if ($q == 2) $aspect = "blending with";
				else if ($q == 3 Or $q == 5) $aspect = "harmonizing with";
				else if ($q == 4 Or $q == 6) $aspect = "discordant to";
//				$aspect = $asp_name[$q];

				$aTitle = $pl_name[$i].' '.$aspect.' '.$pl_name[$j];
/*				$file = "natal_files/" . strtolower($pl_name[$i]) . ".txt";
				$string = Find_Specific_Report_Paragraph($phrase_to_look_for, $file);
				$string = nl2br($string);
				echo "<font size=2>" . $string . "</font>";
*/ ?>
			<div class="paragraph" id="<? echo trendCode($aTitle) ?>" data-rid="<? echo $aTitleReport['id'] ?>" data-trans-num="<? echo countTrans($aTitleReport['id']) ?>">
				<h3><b><? echo $lang[$pl_name[$i]].' '.$lang[$aspect].' '.$lang[$pl_name[$j]] ?></b></h3>
				<div class="chart-paragraph-content"><? echo $aTitleReport['content'] ?></div>
			</div>
<? 			}
		}
	} ?>
		</div>
	</section>
