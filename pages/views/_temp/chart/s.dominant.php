<? include '__initialize.dominant.php'; ?>
<section id="dominant" class="hide">
	<div class="chart-report-head htitle"><? echo $lang['Dominants'] ?></div>
	<div class="chart-report-content">
		<div class="alerts alert-warning"><b>Note</b> This section is being under experiment, calculation might be incorrect. If you're willing to help us improve this, please see <a href="">this</a>.</div>
		<div class="paragraph" id="<? echo $crTitle ?>" data-rid="<? echo astro($crTitle)['id'] ?>" data-trans-num="<? echo countTrans(astro($crTitle)['id']) ?>">
			<h3><b><? echo 'Chart ruler: '.$lang[$chartRuler] ?></b></h3>
			<div class="chart-paragraph-content"><? echo astro($crTitle)['content'] ?></div>
		</div>

		<div class="paragraph" id="<? echo $pTitle ?>" data-rid="<? echo astro($pTitle)['id'] ?>" data-trans-num="<? echo countTrans(astro($pTitle)['id']) ?>">
			<h3><b><? echo 'Domiant planet: '.$lang[$dominant_planet] ?></b></h3>
	<table align="center">
		<thead>
			<td align='center'><b>Planet</b></td>
			<td align='center'><b>Longitude</b></td>
			<td align='center'><b>House</b></td>
			<td align='center'><b>Power</b></td>
			<td align='center'><b>Percentage</b></td>
			<td align='center'><b>Harmony</b></td>
		</thead>
<? 	for ($xx = 0; $xx <= 11; $xx++) {
		$rank = array_search($planet_power[$xx], $planet_power_sort) + 1;
		$rCl = 'rank-'.$rank;
		if ($rank <= 3) $rank = '<b>'.$rank.'</b>';
		echo "<tr class='$rCl'>
			<td>".$lang[$pl_name[$xx]]."</td>
			<td>$L1[$xx]</td>";
			if ($xx < 10) echo "<td align='center'>$house_pos[$xx]</td>";
			else echo "<td>&nbsp;</td>";
			echo "<td align='center'>$planet_power[$xx] (".$rank.")</td>
			<td align='center'>".round($planet_power[$xx]/$totals[0] * 100, 2)."%</td>
			<td align='center'>$planet_harmony[$xx]</td>
		</tr>";
	}
		echo "<tr><td>------</td><td>&nbsp;</td><td>&nbsp;</td><td align='center'>------</td><td align='center'>------</td><td align='center'>------</td></tr>
		<tr><td>TOTALS</td> <td>&nbsp;</td> <td>&nbsp;</td> <td align='center'>$totals[0]</td> <td align='center'>100%</td> <td align='center'>$totals[1]</td></tr>" ?>
	</table>
			<div class="chart-paragraph-content"><? echo astro($pTitle)['content'] ?></div>
		</div>


	<div class="module parallax">
		<div class="parallax-bg" style="background-image:url(<? echo zBg.'/zodiac-art-'.trendCode($dominant_sign).'.jpg' ?>)"></div>
		<div class="paragraph" id="<? echo $sTitle ?>" data-rid="<? echo astro($sTitle)['id'] ?>" data-trans-num="<? echo countTrans(astro($sTitle)['id']) ?>">
			<h3><b><? echo 'Domiant sign: '.$lang[$dominant_sign] ?></b></h3>
	<table align="center">
		<thead>
			<td align='center'><b>Sign</b></td>
			<td align='center'><b>Power</b></td>
			<td align='center'><b>Percentage</b></td>
			<td align='center'><b>Harmony</b></td>
		</thead>
<? 	for ($xx = 1; $xx <= 12; $xx++) {
		$rank = array_search($sign_power[$xx], $sign_power_sort) + 1;
		$rCl = 'rank-'.$rank;
		if ($rank <= 3) $rank = '<b>'.$rank.'</b>';
		echo "<tr class='$rCl'>
			<td>".mb_ucfirst($lang[$sign_name[$xx]], "UTF-8", true)."</td>
			<td align='center'>$sign_power[$xx] (".$rank.")</td>
			<td align='center'>".round($sign_power[$xx]/$totals[2] * 100, 2)."%</td>
			<td align='center'>$sign_harmony[$xx]</td>
		</tr>";
	}
		echo "<tr><td>------</td> <td align='center'>------</td> <td align='center'>------</td> <td align='center'>------</td></tr>
		<tr><td>TOTALS</td> <td align='center'>$totals[2]</td> <td align='center'>100%</td> <td align='center'>$totals[3]</td></tr>" ?>
	</table>
			<div class="chart-paragraph-content"><? echo astro($sTitle)['content'] ?></div>
		</div>
	</div>


		<div class="paragraph" id="<? echo $hTitle ?>" data-rid="<? echo astro($hTitle)['id'] ?>" data-trans-num="<? echo countTrans(astro($hTitle)['id']) ?>">
			<h3><b><? echo 'Domiant house: '.$lang['house'].' '.$dominant_house ?></b></h3>
	<table align="center">
		<thead>
			<td align='center'><b>House</b></td>
			<td align='center'><b>Power</b></td>
			<td align='center'><b>Percentage</b></td>
			<td align='center'><b>Harmony</b></td>
			<td align='center'><b>Longitude</b></td>
		</thead>
<? 	for ($xx = 1; $xx <= 12; $xx++) {
		$rank = array_search($house_power[$xx], $house_power_sort) + 1;
		$rCl = 'rank-'.$rank;
		if ($rank <= 3) $rank = '<b>'.$rank.'</b>';
		echo "<tr class='$rCl'>
			<td align='center'>$xx</td>
			<td align='center'>$house_power[$xx] (".$rank.")</td>
			<td align='center'>".round($house_power[$xx]/$totals[4] * 100, 2)."%</td>
			<td align='center'>$house_harmony[$xx]</td>
			<td>$HC1[$xx]</td>
		</tr>";
	} ?>
		<tr><td>------</td> <td align='center'>------</td> <td align='center'>------</td> <td>&nbsp;</td></tr>
		<tr><? echo "<td>TOTALS</td> <td align='center'>$totals[4]</td> <td align='center'>$totals[5]</td> <td>&nbsp;</td>" ?></tr>
	</table>
			<div class="chart-paragraph-content"><? echo astro($hTitle)['content'] ?></div>
			<div class="chart-report-des" id="<? echo $hTitleT ?>" data-rid="<? echo astro($hTitleT)['id'] ?>" data-trans-num="<? echo countTrans(astro($hTitleT)['id']) ?>">
				<h4><b><? echo 'Domiant house belongs to '.$tHse.' house' ?></b></h4>
				<div class="chart-report-des-content"><? echo astro($hTitleT)['content'] ?></div>
			</div>
			<div class="chart-report-des" id="<? echo $hTitleN ?>" data-rid="<? echo astro($hTitleN)['id'] ?>" data-trans-num="<? echo countTrans(astro($hTitleN)['id']) ?>">
				<h4><b><? echo 'Domiant house belongs to '.$nHse.' house' ?></b></h4>
				<div class="chart-report-des-content"><? echo astro($hTitleN)['content'] ?></div>
			</div>
		</div>
	</div>
</section>
