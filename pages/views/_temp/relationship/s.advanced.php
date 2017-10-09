<section id="re-advanced" class="hide">
	<div class="chart-report-head htitle"><? echo $lang['Simple relationship compability'] ?></div>
	<div class="chart-report-content">
		<div class="paragraph">
			<h3>You</h3>
			<b>Name:</b> <? echo $name_without_slashes ?><br/>
			<b>Born:</b> <? echo strftime("%A, %B %d, %Y - %X (time zone = GMT $tz2 hours)", mktime($hour1, $minute1, 0, $month1, $day1, $year1)); ?><br/>
			<b>Position:</b> <? echo $longAr1['deg'] . $ew_txt1 . $longAr1['min'] . ", " . $latAr1['deg'] . $ns_txt1 . $latAr1['min'] ?><br/>
			<b>Sun sign:</b> <? echo $sunSign1 ?>
		</div>
		<div class="paragraph">
			<h3>Your partner</h3>
			<b>Name:</b> <? echo $name2_without_slashes ?><br/>
			<b>Born:</b> <? echo strftime("%A, %B %d, %Y - %X (time zone = GMT $tz2 hours)", mktime($hour2, $minute2, 0, $month2, $day2, $year2)); ?><br/>
			<b>Position:</b> <? echo $longAr2['deg'] . $ew_txt2 . $longAr2['min'] . ", " . $latAr2['deg'] . $ns_txt2 . $latAr2['min'] ?><br/>
			<b>Sun sign:</b> <? echo $sunSign2 ?>
		</div>
	</div>
</section>
