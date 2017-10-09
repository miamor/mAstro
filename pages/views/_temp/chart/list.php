<div class="col-lg-7 no-padding-left">
<form class="chart-inputs" action="?do=caculate" method="post" name="caculate">
	<h3><? echo $lang['Generate new chart'] ?></h3>
	<div class="alerts alert-info" style="margin:20px 0 10px!important">
		You cn only use your mAstro_data to generate natal charts. Others' mAstro_data which you're granted is only available in generating transit or relationship charts.
	</div>
	<? $chart->showForm() ?>
	<div class="add-form-submit center">
		<input type="reset" value="Reset"/>
		<input type="submit" value="Submit"/>
	</div>
</form>

<div class="my-charts my-<? echo $page ?>-charts">
	<h3 class="bor">My charts</h3>
	<div class="charts-list" style="margin-bottom:30px">
	<? foreach ($cListMy as $cO) { ?>
		<div class="c-one" style="background-image:url('<? echo IMG ?>/bg/tile-bg-<? echo (int)$cO['n']%8 ?>.jpg')">
			<div class="c-info"><a href="<? echo $cO['link'] ?>">
				<div class="c-name"><? echo $cO['name'] ?></div>
<!--				<div class="c-au"><img class="img-mini img-circle" src="<? echo $cO['author']['avatar'] ?>"/></div> -->
				<div class="c-au c-privacy">
					<? if ($cO['stt'] == 0) echo '<div class="fa fa-lock" data-placement="bottom" title="Only me"></div>';
					else if ($cO['stt'] == -1) echo '<div class="fa fa-globe" data-placement="bottom" title="Public"></div>';
					else if ($cO['stt'] == 1) echo '<div class="fa fa-user" data-placement="bottom" title="Friends"></div>'; ?>
				</div>
				<div class="c-time"><? echo timeFormat($cO['birthday']) ?></div>
			</a></div>
		</div>
	<? } ?>
		<div class="clearfix"></div>
	</div>
	<h3 class="bor">Others</h3>
	<div class="charts-list" style="margin-bottom:30px">
	<? foreach ($cListOthers as $cO) { ?>
		<div class="c-one" style="background-image:url('<? echo $cO['author']['avatar'] ?>');background-size:100% 100%">
			<div class="c-info"><a href="<? echo $cO['link'] ?>">
				<div class="c-name"><? echo $cO['name'] ?></div>
				<div class="c-au c-privacy">
					<? if ($cO['stt'] == 0) echo '<div class="fa fa-lock" data-placement="bottom" title="Only me"></div>';
					else if ($cO['stt'] == -1) echo '<div class="fa fa-globe" data-placement="bottom" title="Public"></div>';
					else if ($cO['stt'] == 1) echo '<div class="fa fa-user" data-placement="bottom" title="Friends"></div>'; ?>
				</div>
				<div class="c-time"><? echo timeFormat($cO['birthday']) ?></div>
			</a></div>
		</div>
	<? } ?>
		<div class="clearfix"></div>
	</div>
</div>
</div>

<div class="chart-signs col-lg-5 no-padding-right">
<? include 'temp.signs.php' ?>
</div>

<div class="clearfix"></div>
