<? if ($ubt1 == 0) {
	$desHReport = astro('house'); ?>
	<section id="house" class="hide">
		<div class="chart-report-head htitle"><? echo $lang['House position of planets'] ?></div>
		<div class="chart-report-content">
			<div class="chart-report-des"><? echo $desHReport['content'] ?></div>
<? for ($i = 0; $i <= 9; $i++) {
	$h_pos = $house_pos1[$i];
	$hTitle = $pl_name[$i] . " in " . $house_name[$h_pos - 1].' house';
	$hTitleReport = astro(trendCode($hTitle)); ?>
			<div class="paragraph" id="<? echo trendCode($hTitle) ?>" data-rid="<? echo $hTitleReport['id'] ?>" data-trans-num="<? echo countTrans($hTitleReport['id']) ?>">
				<h3><b><? echo $lang[$pl_name[$i]].' '.$lang['as^in'].' '.$lang['house'].' '.$h_pos ?></b></h3>
				<div class="chart-paragraph-content"><? echo $hTitleReport['content'] ?></div>
			</div>
<? } ?>
		</div>
	</section>
<? } ?>
