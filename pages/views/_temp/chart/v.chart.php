<div class="chart-info">
	<h2><? echo $restored_name ?></h2>
	<div class="chart-more-info">
		<a class="chart-pdf-download" href="?v=pdf" target="_blank" data-placement="bottom" title="Download pdf"><span class="fa fa-file-pdf-o"></span></a>
		<div class="chart-stt dropdown">
			<div class="chart-current-stt dropdown-toggle" data-toggle="dropdown">
				<? if ($cIn['stt'] == 0) echo '<div class="fa fa-lock" data-placement="bottom" title="Only me"></div>';
				else if ($cIn['stt'] == -1) echo '<div class="fa fa-globe" data-placement="bottom" title="Public"></div>';
				else if ($cIn['stt'] == 1) echo '<div class="fa fa-users" data-placement="bottom" title="Friends"></div>';
				//else if ($cIn['stt'] == 2) echo '<div class="fa fa-users" data-placement="bottom" title="Friends of friends"></div>'; ?>
			</div>
	<? if ($cIn['uid'] == $config->u) { ?>
			<div class="chart-stt-dropdown dropdown-menu with-triangle primary pull-right">
				<li<? if ($cIn['stt'] == -1) echo ' class="active"' ?>><a id="-1"><span class="fa fa-globe" title="Public"></span> Public</a></li>
				<li<? if ($cIn['stt'] == 0) echo ' class="active"' ?>><a id="0"><span class="fa fa-lock" title="Only me"></span> Only me</a></li>
				<li<? if ($cIn['stt'] == 1) echo ' class="active"' ?>><a id="1"><span class="fa fa-users" title="Friends"></span> Friends</a></li>
			</div>
	<? } ?>
		</div>
		<div class="chart-ratings">
			<? $chart->echoRate() ?>
		</div>
	</div>
	<div class="chart-private left">
		<? if (!$type && $cIn['uid'] == $config->u) { ?>
			<div class="chart-born">Born <? echo strftime("%A, %B %d, %Y<br>%X (time zone = GMT $tz hours)", mktime($hour, $minute, $secs, $month, $day, $year)) ?></div>
			<div class="chart-position"><? echo $longAr['deg'] . $ew_txt . $longAr['min'] . ", " . $latAr['deg'] . $ns_txt . $latAr['min']?></div>
		<? } else {
			$cOwn = $cIn['cOwn']; $cAu = $cIn['au'];
			if ($cAu['id'] != $cOwn['id']) $by = ' by '. $cAu['name'] .' using '. $cOwn['name'] .'\'s data'; ?>
			<div class="chart-owner" title="Data details have been hidden under the mAstro's privacy policy.">
				<div class="gensmall hide">This chart belongs to</div>
				<a data-online="<? echo $cOwn['online'] ?>" href="<? echo $cOwn['link'] ?>">
					<img class="img-rounded chart-owner-avt" src="<? echo $cOwn['avatar'] ?>"/>
				</a>
				<div style="margin-left:50px"><a href="<? echo $cOwn['link'] ?>"><? echo $cOwn['name'] ?></a>
					<div class="gensmall time"><span class="fa fa-clock-o" title="Created at <? echo date('D dS, M', $cIn['time']).$by ?>"></span> <? echo date('D dS, M', $cIn['time']) ?>
					<? if ($cAu['id'] != $cOwn['id']) echo ' - by <a href="'. $cAu['link'] .'">'. $cAu['name'] .'</a>' ?>
					</div>
				</div>
<!--				<div class="gensmall hide">Details have been hidden under the mAstro's privacy policy.</div> -->
				<div class="clearfix"></div>
			</div>
		<? } ?>
	</div>
</div>

<div id="m_tab">
		<div class="m_tab">
			<div class="tab active" id="c-images">Natal wheel</div>
			<div class="tab" id="c-aspect">Aspects</div>
			<div class="tab" id="c-natal">Data</div>
		</div>
		<div class="chart-canvas tab-index c-images">
			<div class="chart-wheel">
				<img src='<? echo $asLink.'/natal_wheel_1.php?'.$cData0 //echo MAIN_URL.'/'.$chartwheel_filename ?>'>
			</div>
		</div>

		<div class="hide chart-canvas tab-index c-aspect">
			<div class="chart-aspect">
				<img src='<? echo $asLink.'/natal_aspect_grid.php?'.$cData1 //echo MAIN_URL.'/'.$grids_filename ?>'>
			</div>
		</div>

		<div class="hide chart-canvas tab-index c-natal">
<? $sigAr = $plAr = $hsAr = array();
foreach ($sign_name as $i => $sig) {
	if (!array_key_exists($sig, $sigAr)) $sigAr[$sig] = 0;
}
foreach ($pl_name as $i => $pln) {
	if ($i <= 12 && !array_key_exists($pln, $plAr)) $plAr[$pln] = 0;
} ?>
			<table width="100%" class="natal_table" cellpadding="0" cellspacing="0" border="0">
				<thead>
					<td>&nbsp;</td>
					<td><font color='#0000ff'><b> C </b></font></td>
					<td><font color='#0000ff'><b> F </b></font></td>
					<td><font color='#0000ff'><b> M </b></font></td>
				</thead>
<? $clr = array('Fire' => 'df3222', 'Earth' => '09a909', 'Water' => '43c7f0', 'Air' => 'ff6510');
foreach ($elements as $ele => $eAr) { ?>
				<tr><td><font color='#<? echo $clr[$ele] ?>'><b> <? echo $ele ?> </b></font></td>
<? foreach ($qualities as $qk => $qAr) { ?>
					<td>
					<? for ($i = 0; $i < 14; $i++) {
						$s_pos = floor($longitude1[$i] / 30) + 1;
						$sigi = $sign_name[$s_pos];
						$pln = $pl_name[$i];
						if (in_array($sigi, $qAr) && in_array($sigi, $eAr)) echo '<font color="#'. $clr[$ele] .'"><img src="'.$asLink.'/natal_planet.php?g='.$i.'&clr='.$clr[$ele].'" title="'.trendCode($pln).'"/></font>';
					} ?>
					</td>
<? } ?>
				</tr>
<? } ?>
			</table>
			<table class="table table-striped table-hovered" width="100%">
				<thead>
					<td><font color='#0000ff'><b> Planet </b></font></td>
					<td><font color='#0000ff'><b> Longitude </b></font></td>
				<?	if ($ubt1 == 1) echo "<td>&nbsp;</td>";
					else echo "<td><font color='#0000ff'><b> House position </b></font></td>"; ?>
				</thead>
<? 	for ($i = 0; $i <= $a1; $i++) {
		$s_pos = floor($longitude1[$i] / 30) + 1;
		$sigi = $sign_name[$s_pos];
		$sigAr[$sigi]++;
		$pli = $pl_name[$i];
		if (check($crAr[$sigi], $pli)) $plAr[$pli]++;
		echo '<tr>';
		echo "<td>" . $pli . "</td>";
		echo "<td>" . Convert_Longitude($longitude1[$i]) . " " . Mid($rx1, $i + 1, 1) . "</td>";
		if ($ubt1 == 1) echo "<td>&nbsp;</td>";
		else {
			$hse = floor($house_pos1[$i]);
			$hsAr[$hse]++;
			echo "<td align='center'>" . $hse . "</td>";
		}
		echo '</tr>';
	} ?>
			</table>

<?	if ($ubt1 == 0) {
		echo '<table class="table table-striped table-hovered" width="100%">';
		echo '<thead>';
			echo "<td><font color='#0000ff'><b> House </b></font></td>";
			echo "<td><font color='#0000ff'><b> Longitude </b></font></td>";
//			echo "<td> &nbsp </td>";
		echo '</thead>';

		for ($i = LAST_PLANET + 1; $i <= LAST_PLANET + 12; $i++) {
			echo '<tr>';
			if ($i == LAST_PLANET + 1) echo "<td>Ascendant </td>";
			else if ($i == LAST_PLANET + 10) echo "<td>MC (Midheaven) </td>";
			else echo "<td>House " . ($i - LAST_PLANET) . "</td>";

			echo "<td>" . Convert_Longitude($longitude1[$i]) . "</td>";
//			echo "<td> &nbsp </td>";
			echo '</tr>';
		}
		echo '</table>';
	} ?>
		</div>
	</div>
