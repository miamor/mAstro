<div class="chart-info">
	<h2 class="left"><? echo str_replace('::', ' - ', $cIn['name']) ?></h2>
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
		<? /*if (!$type && $cIn['uid'] == $config->u) { ?>
			<div class="chart-born">Born <? echo strftime("%A, %B %d, %Y<br>%X (time zone = GMT $tz hours)", mktime($hour, $minute, $secs, $month, $day, $year)) ?></div>
			<div class="chart-position"><? echo $longAr['deg'] . $ew_txt . $longAr['min'] . ", " . $latAr['deg'] . $ns_txt . $latAr['min']?></div>
		<? } else { */
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
		<? //} ?>
	</div>
</div>

	<div id="m_tab">
		<div class="m_tab">
			<div class="tab active" id="c-davison">Davison</div>
			<div class="tab" id="c-composite">Composite</div>
			<div class="tab" id="c-synastry">Synastry</div>
			<div class="tab" id="c-data">Data</div>
		</div>
		<div class="chart-canvas tab-index c-davison">
			<div class="chart-wheel">
				<img src='<? echo $asLink."/natal_wheel_1.php?rx1=$Drx1&rx2=$Drx2&p1=$Dser_L1&p2=$Dser_L2&hc1=$Dser_hc1&ubt1=$ubt1&ubt2=$ubt2" ?>'/>
				<img src='<? echo $asLink."/chartwheel_natal_line.php?rx1=$Drx1&rx2=$Drx2&p1=$Dser_L1&p2=$Dser_L2&hc1=$Dser_hc1&ubt1=$ubt1&ubt2=$ubt2" ?>'/>
			</div>
		</div>
		<div class="hide chart-canvas tab-index c-composite">
			<div class="chart-wheel">
				<img src='<? echo $asLink."/composite_wheel.php?rx1=$rx1&rx2=$rx2&p1=$ser_L1&p2=$ser_L2&hc1=$ser_hc1&ubt1=$ubt1&ubt2=$ubt2" ?>'/>
				<img src='<? echo $asLink."/composite_aspect_grid.php?rx1=$rx1&rx2=$rx2&p1=$ser_L1&p2=$ser_L2&hc1=$ser_hc1&ubt1=$ubt1&ubt2=$ubt2" ?>'/>
			</div>
		</div>
		<div class="hide chart-canvas tab-index c-synastry">
			<div class="chart-wheel">
				<img src='<? echo $asLink."/synastry_wheel.php?rx1=$Srx1&rx2=$Srx2&p1=$Sser_L1&p2=$Sser_L2&hc1=$Sser_hc1&hc2=$Sser_hc2&ubt1=$ubt1&ubt2=$ubt2" ?>'/>
				<img src='<? echo $asLink."/synastry_aspect_grid.php?rx1=$rx1&rx2=$rx2&p1=$ser_L1&p2=$ser_L2&hc1=$ser_hc1&hc2=$Sser_hc2&ubt1=$ubt1&ubt2=$ubt2" ?>'/>
			</div>
		</div>
		<div class="hide chart-canvas tab-index c-data">
			<div class="chart-date-p">
			</div>
		</div>

		<div class="hide chart-canvas tab-index c-transit">
			<div class="chart-date-t">
				<? echo strftime("<div class='date post-time right'><span class='day-txt'>%a</span> <span class='day'>%d</span> <span class='month'>%B</span> <span class='year'>%Y</span></div><div class='clearfixs'></div><div class='chart-date-t-title'><h4> $name3 </h4></div><div class='post-time-tz left'>%X (time zone = GMT $tz1 hours)</div>", mktime($hour3, $minute3, $secs, $start_month, $start_day, $start_year)) ?>
				<div class="clearfix"></div>
			</div>
			<img src='<? echo $asLink."/transit_aspect_grid_blue.php?rx1=$rx1&rx2=$rx3&p1=$ser_L1&p2=$ser_L3&hc1=$ser_hc1&hc2=$ser_hc3&ubt1=$ubt1&ubt2=$ubt3" ?>'/>
		</div>
	</div>

