<div class="col-lg-7 no-padding-left">
<form class="chart-inputs" action="?do=caculate" method="post" name="caculate">
	<h3><? echo $lang['Generate new chart'] ?></h3>
	<? $chart->showForm() ?>
	<div class="txt-with-line">
		<span class="txt"></span>
	</div>
	<div class="form-group" style="margin-top:8px">
		<div class="col-lg-3 no-padding control-label">Progressed date</div>
		<div class="col-lg-9">
			<!--<input size="2" maxlength="2" name="start_day" value="<? echo date('d') ?>" placeholder="Day"> -->
			<select name="start_day" id="start_day">
			<? for ($i = 1; $i <= 31; $i++) {
				if ($i < 10) $i_d = '0'.$i;
				else $i_d = $i;
				echo '<option value="'.$i.'">'.$i_d.'</option>';
			} ?>
			</select>
			<script>document.getElementById('start_day').value='<? echo (int)date('d') ?>';</script>
			<select name="start_month" id="start_month"><option value="0">Choose month</option>
				<option value="1">January</option>
				<option value="2">February</option>
				<option value="3">March</option>
				<option value="4">April</option>
				<option value="5">May</option>
				<option value="6">June</option>
				<option value="7">July</option>
				<option value="8">August</option>
				<option value="9">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
				<script>document.getElementById('start_month').value='<? echo (int)date('m') ?>';</script>
			</select>
			<input size="4" maxlength="4" name="start_year" value="<? echo date('Y') ?>" placeholder="YYYY"><br/>
			<font color="#0000ff">(only years from 1900 through 2099 are valid)</font>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="add-form-submit center">
		<input type="reset" value="Reset"/>
		<input type="submit" value="Submit"/>
	</div>
</form>

<div class="my-charts my-<? echo $page ?>-charts">
	<h3 class="bor">My charts</h3>
	<div class="charts-list" style="margin-bottom:30px">
	<? foreach ($cListMy as $cO) {
	$startAr = explode('|', $cO['start']);
	if ($startAr[1] < 10) $startM = '0'.$startAr[1];
	else $startM = $startAr[1];
	$start = $startAr[0].'.'.$startM.'.'.$startAr[2] ?>
		<div class="c-one" style="background-image:url('<? echo IMG ?>/bg/tile-bg-<? echo (int)$cO['n']%8 ?>.jpg')">
			<div class="c-info"><a href="<? echo $cO['link'] ?>">
				<div class="c-name"><? echo $cO['name'] ?></div>
				<div class="c-au c-privacy">
					<? if ($cO['stt'] == 0) echo '<div class="fa fa-lock" data-placement="bottom" title="Only me"></div>';
					else if ($cO['stt'] == -1) echo '<div class="fa fa-globe" data-placement="bottom" title="Public"></div>';
					else if ($cO['stt'] == 1) echo '<div class="fa fa-user" data-placement="bottom" title="Friends"></div>'; ?>
				</div>
				<div class="c-time"><? echo $start ?></div>
			</a></div>
		</div>
	<? } ?>
		<div class="clearfix"></div>
	</div>
	<h3 class="bor">Others</h3>
	<div class="charts-list" style="margin-bottom:30px">
	<? foreach ($cListOthers as $cO) {
	$startAr = explode('|', $cO['start']);
	if ($startAr[1] < 10) $startM = '0'.$startAr[1];
	else $startM = $startAr[1];
	$start = $startAr[0].'.'.$startM.'.'.$startAr[2] ?>
		<div class="c-one" style="background-image:url('<? echo $cO['author']['avatar'] ?>');background-size:100% 100%">
			<div class="c-info"><a href="<? echo $cO['link'] ?>">
				<div class="c-name"><? echo $cO['name'] ?></div>
				<div class="c-au c-privacy">
					<? if ($cO['stt'] == 0) echo '<div class="fa fa-lock" data-placement="bottom" title="Only me"></div>';
					else if ($cO['stt'] == -1) echo '<div class="fa fa-globe" data-placement="bottom" title="Public"></div>';
					else if ($cO['stt'] == 1) echo '<div class="fa fa-user" data-placement="bottom" title="Friends"></div>'; ?>
				</div>
				<div class="c-time"><? echo $start ?></div>
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
