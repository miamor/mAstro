<? $phReport = astro('philosophy') ?>
	<section id="philosophy" class="hide">
		<div class="chart-report-head htitle"><? echo $lang['My philoshophy of astrology'] ?></div>
		<div class="chart-report-content">
			<div class="paragraph" data-trans-num="<? echo countTrans($phReport['id']) ?>">
				<div><? echo $phReport['content'] ?></div>
			</div>
		</div>
	</section>
