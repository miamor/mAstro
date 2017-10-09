<section id="overview">
<style>#overview .chart-report-content .form-group{margin:6px 0 0;border-bottom:1px dashed #f2f2f2;padding-bottom:6px}
#overview .chart-report-content .form-group:last-child{border:0}
#overview .chart-report-content{font-size:14px;line-height:25px}</style>
	<div class="chart-report-head htitle"><? echo $lang['Overview'] ?></div>
	<div class="chart-report-content" style="padding:0">
		<div class="chart-overview-paragraph">
	<div class="overview-rising overview-section" style="padding:10px 20px">
<? 	$s_pos = floor($hc1[1] / 30) + 1;
	$rising = $sign_name[$s_pos];
	$risingCode = trendCode($rising) ?>
		<h3 class="bor"><? echo $lang['ascendant-before'] ?> <? echo $lang[$rising] ?> <? echo $lang['ascendant'] ?></h3>
		<div class="form-group">
			<div class="chart-paragraph-content des"><? echo _astro('rising-'.$risingCode)['content'] ?></div>
		</div>
	</div> <!-- .overview-rising -->
	<div class="overview-midheaven overview-section" style="padding:10px 20px">
<? 	$s_pos = floor($hc1[10] / 30) + 1;
	$mc = $sign_name[$s_pos];
	$mcCode = trendCode($mc) ?>
		<h3 class="bor"><? echo $lang['mc-before'] ?> <? echo $lang[$mc] ?> <? echo $lang['ascendant'] ?></h3>
		<div class="form-group">
			<div class="chart-paragraph-content des"><? echo _astro('mc-'.$mcCode)['content'] ?></div>
		</div>
	</div> <!-- .overview-midheaven -->
	<div class="overview-planets overview-section">
		<h3 class="bor" style="margin:10px 20px">Planets and houses overview</h3>
		<div class="form-group">
			<div class="col-lg-2">Planet</div>
			<div class="col-lg-5">Sign</div>
		<?	if ($ubt1 == 1) echo '<div class="col-lg-5">&nbsp;</div>';
			else echo '<div class="col-lg-5">House position </div>'; ?>
			<div class="clearfix"></div>
		</div>
<? 	for ($i = 0; $i <= $a1; $i++) {
		$s_pos = floor($longitude1[$i] / 30) + 1;
		$sigi = $sign_name[$s_pos]; ?>
		<div class="form-group">
			<div class="col-lg-2">
				<div class="bold"><? echo mb_convert_case($lang[$pl_name[$i]], MB_CASE_TITLE, "UTF-8"); ?></div>
			</div>
			<div class="col-lg-5">
				<div class="bold toggle-des"><? echo mb_convert_case($lang[$sigi], MB_CASE_TITLE, "UTF-8"); ?></div>
				<div class="des hide"><? echo _astro(trendCode($pl_name[$i].'-in-'.$sigi))['content'] ?></div>
			</div>
	<? 	if ($ubt1 == 1) echo '<div class="col-lg-5">&nbsp;</div>';
		else {
			$h_pos = $house_pos1[$i];
			$hse = floor($house_pos1[$i]);
			$hname = $house_name[$h_pos - 1] ?>
			<div class="col-lg-5">
				<div class="bold toggle-des"><? echo $hse ?></div>
				<div class="des hide"><? echo _astro(trendCode($pl_name[$i].'-in-'.$hname.'-house'))['content'] ?></div>
			</div>
	<? 	} ?>
			<div class="clearfix"></div>
		</div>
<?	} ?>
	</div> <!-- .overview-planets -->
		</div> <!-- .chart-report-overview -->
	</div>
</section>
