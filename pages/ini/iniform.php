<? 
if (!isset($p) || !$p) $p = 1;
if (!isset($_DATA) || !$_DATA) {
	$stt 		= isset($_COOKIE['stt'.$p]) 		? $_COOKIE['stt'.$p] 		: 1;
	$name 		= isset($_COOKIE['name'.$p]) 		? $_COOKIE['name'.$p] 		: null;
	$gender	 	= isset($_COOKIE['gender'.$p]) 		? $_COOKIE['gender'.$p] 	: null;
	$day 		= isset($_COOKIE['day'.$p]) 		? $_COOKIE['day'.$p] 		: null;
	$month 		= isset($_COOKIE['month'.$p]) 		? $_COOKIE['month'.$p] 		: null;
	$year		= isset($_COOKIE['year'.$p]) 		? $_COOKIE['year'.$p] 		: null;
	$hour		= isset($_COOKIE['hour'.$p]) 		? $_COOKIE['hour'.$p] 		: null;
	$minute 	= isset($_COOKIE['minute'.$p]) 		? $_COOKIE['minute'.$p] 	: null;
	$lat_min 	= isset($_COOKIE['lat_min'.$p]) 	? $_COOKIE['lat_min'.$p] 	: null;
	$lat_deg 	= isset($_COOKIE['lat_deg'.$p])		? $_COOKIE['lat_deg'.$p] 	: null;
	$long_min 	= isset($_COOKIE['long_min'.$p]) 	? $_COOKIE['long_min'.$p] 	: null;
	$long_deg 	= isset($_COOKIE['long_deg'.$p]) 	? $_COOKIE['long_deg'.$p] 	: null;
	$ew = $ns = null;
	
	if (isset($_COOKIE['ew'.$p])) {
		$ew = ($_COOKIE['ew'.$p] == 'e' || $_COOKIE['ew'.$p] == 1) ? 1 : -1;
	}
	if (isset($_COOKIE['ns'.$p])) {
		$ns = ($_COOKIE['ns'.$p] == 'n' || $_COOKIE['ns'.$p] == 1) ? 1 : -1;
	}

	$timezone 	= isset($_COOKIE['timezone'.$p]) 	? $_COOKIE['timezone'.$p] 	: null;
	$country 	= isset($_COOKIE['country'.$p]) 	? $_COOKIE['country'.$p] 	: null;
	$town 		= isset($_COOKIE['town'.$p]) 		? $_COOKIE['town'.$p] 		: null;
} else {
	$stt = $_DATA['stt'];
	$name = $_DATA['name'];
	$gender = $_DATA['gender'];
	
	$bday = $_DATA['birthday'];
	$day = (int)date('d', $bday);
	$month = (int)date('m', $bday);
	$year = (int)date('Y', $bday);
	$bh = explode(':', $_DATA['birthhour']);
	
	$hour = $bh[0];
	$minute = $bh[1];
	
	$long_deg = $_DATA['long_deg'];
	$long_min = $_DATA['long_min'];
	$lat_deg = $_DATA['lat_deg'];
	$lat_min = $_DATA['lat_min'];
	$ns = ($_DATA['ns'] == 'n') ? 1 : -1;
	$ew = ($_DATA['ew'] == 'e') ? 1 : -1;
	$country = $_DATA['country'];
	$town = $_DATA['town'];
	$timezone = $_DATA['timezone'];
}
?>
<? if ($page == 'profile') { ?>
	<div class="form-group">
		<div class="col-lg-3 no-padding control-label bold">Privacy</div>
		<div class="col-lg-3">
			<!--<select class="form-control" name="stt<? echo $p ?>">
				<option value="-1">Public</option>
				<option value="0">Only me</option>
				<option value="1">Friends</option>
			</select> -->
			<label class="radio">
				<input type="radio" value="-1" <? if ($stt == -1) echo 'checked' ?> name="stt<? echo $p ?>"/> <span class="fa fa-globe"></span> Public
			</label>
			<label class="radio" style="margin-top:2px">
				<input type="radio" value="-1" <? if ($stt == 0) echo 'checked' ?> name="stt<? echo $p ?>"/> <span class="fa fa-lock"></span> Only me
			</label>
			<label class="radio" style="margin-top:2px">
				<input type="radio" value="-1" <? if (!$stt || $stt == 1) echo 'checked' ?> name="stt<? echo $p ?>"/> <span class="fa fa-users"></span> Friends
			</label>
		</div>
		<div class="col-lg-6 no-padding">
			<div class="alerts alert-info no-margin">
				Setting mAstro data privacy will allow permitted users to use your data to generate relationship/transit charts (not natal chart) without knowing your details.
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
<? } ?>
	<div class="form-group">
		<div class="col-lg-3 no-padding control-label">Name</div>
		<div class="col-lg-9"><input style="width:200px" type="text" name="name<? echo $p ?>" value="<? echo $name ?>" placeholder="Name"/></div>
		<div class="clearfix"></div>
	</div>
	<div class="form-group">
		<div class="col-lg-3 no-padding">Gender</div>
		<div class="col-lg-4">
			<label class="radio">
				<input type="radio" value="f" <? if (!$gender || $gender == 'f') echo 'checked' ?> name="gender<? echo $p ?>"/> Female
			</label>
		</div>
		<div class="col-lg-4">
			<label class="radio">
				<input type="radio" value="m" <? if ($gender == 'm') echo 'checked' ?> name="gender<? echo $p ?>"/> Male
			</label>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
	
	<div class="form-group">
		<div class="col-lg-3 no-padding control-label">Birthday</div>
		<div class="col-lg-9">
<!--		<input name="day" size="3" value="" maxlength="2" type="number" min="1" max="31" placeholder="dd"> -->
			<select class="day" id="day<? echo $p ?>" name="day<? echo $p ?>">
			<? for ($i = 1; $i <= 31; $i++) {
				if ($i < 10) $t = '0'.$i; else $t = $i;
				echo '<option value="'.$i.'">'.$t.'</option>';
			} ?>
			</select>
			<select id="month<? echo $p ?>" name="month<? echo $p ?>">
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
			</select>
			<? if ($day) echo '<script>document.getElementById("day'.$p.'").value="'.$day .'";</script>';
			if ($month) echo '<script>document.getElementById("month'.$p.'").value="'.$month .'";</script>' ?>
			<input name="year<? echo $p ?>" value="<? echo $year ?>" size="7" maxlength="4" placeholder="YYYY">
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="form-group">
		<div class="col-lg-3 no-padding control-label">Birth-hour</div>
		<div class="col-lg-9">
			<select class="hour" id="hour<? echo $p ?>" name="hour<? echo $p ?>">
				<option <? if (!$hour) echo 'selected' ?> value="0">0 [12 midnight]</option>
				<option value="1">1 [am]</option>
				<option value="2">2 [am]</option>
				<option value="3">3 [am]</option>
				<option value="4">4 [am]</option>
				<option value="5">5 [am]</option>
				<option value="6">6 [am]</option>
				<option value="7">7 [am]</option>
				<option value="8">8 [am]</option>
				<option value="9">9 [am]</option>
				<option value="10">10 [am]</option>
				<option value="11">11 [am]</option>
				<option value="12">12 [noon]</option>
				<option value="13">13 [1 pm]</option>
				<option value="14">14 [2 pm]</option>
				<option value="15">15 [3 pm]</option>
				<option value="16">16 [4 pm]</option>
				<option value="17">17 [5 pm]</option>
				<option value="18">18 [6 pm]</option>
				<option value="19">19 [7 pm]</option>
				<option value="20">20 [8 pm]</option>
				<option value="21">21 [9 pm]</option>
				<option value="22">22 [10 pm]</option>
				<option value="23">23 [11 pm]</option>
			</select>
			:
			<select class="min" id="min<? echo $p ?>" name="min<? echo $p ?>">
			<? for ($i = 0; $i < 60; $i++) {
				if ($i < 10) $t = '0'.$i; else $t = $i;
				echo '<option value="'.$i.'">'.$t.'</option>';
			} ?>
			</select>
			<? if ($hour) echo '<script>document.getElementById("hour'.$p.'").value="'.$hour .'";</script>';
			if ($minute) echo '<script>document.getElementById("min'.$p.'").value="'.$minute .'";</script>' ?>
			<label class="checkbox unknown-hr right">
				<input type="checkbox" value="-1" <? if ($hour && $hour == 0) echo 'checked' ?> name="hour<? echo $p ?>"/> Unknown
			</label>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="form-group" style="margin-bottom:3px!important">
		<div class="col-lg-3 no-padding control-label">Birth place</div>
		<div class="col-lg-5 no-padding-right">
			<input class="form-control" type="text" id="town" name="town<? echo $p ?>" value="<? echo $town ?>" placeholder="Town/City"/>
		</div>
		<div class="col-lg-4">
			<input class="form-control" type="text" name="country<? echo $p ?>" value="<? echo $country ?>" placeholder="Country"/>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="form-group">
		<div class="col-lg-3 no-padding"></div>
		<div class="col-lg-9 birth-place-info"></div>
		<div class="clearfix"></div>
	</div>

	<div class="txt-with-line">
		<span class="txt">Data below is automatically modified based on your <b>birth-place</b> input</span>
	</div>
<!--	<input type="hidden" value="<? echo $long_deg ?>" name="long_deg<? echo $p ?>"/>
	<input type="hidden" value="<? echo $long_min ?>" name="long_min<? echo $p ?>"/>
	<input type="hidden" value="<? echo $lat_deg ?>" name="lat_deg<? echo $p ?>"/>
	<input type="hidden" value="<? echo $lat_min ?>" name="lat_min<? echo $p ?>"/>

	<input type="hidden" value="<? echo $ew ?>" name="ew<? echo $p ?>"/>
	<input type="hidden" value="<? echo $ns ?>" name="ns<? echo $p ?>"/>
	<input type="hidden" value="<? echo $timezone ?>" name="timezone<? echo $p ?>"/>
-->
	<div class="form-group">
		<div class="col-lg-3 no-padding control-label">Timezone</div>
		<div class="col-lg-9">
			<select class="form-control" id="timezone<? echo $p ?>" name="timezone<? echo $p ?>">
				<option value="" selected=""> Select Time Zone </option>
				<option value="-12">GMT -12:00 hrs - IDLW</option>
				<option value="-11">GMT -11:00 hrs - BET or NT</option>
				<option value="-10.5">GMT -10:30 hrs - HST</option>
				<option value="-10">GMT -10:00 hrs - AHST</option>
				<option value="-9.5">GMT -09:30 hrs - HDT or HWT</option>
				<option value="-9">GMT -09:00 hrs - YST or AHDT or AHWT</option>
				<option value="-8">GMT -08:00 hrs - PST or YDT or YWT</option>
				<option value="-7">GMT -07:00 hrs - MST or PDT or PWT</option>
				<option value="-6">GMT -06:00 hrs - CST or MDT or MWT</option>
				<option value="-5">GMT -05:00 hrs - EST or CDT or CWT</option>
				<option value="-4">GMT -04:00 hrs - AST or EDT or EWT</option>
				<option value="-3.5">GMT -03:30 hrs - NST</option>
				<option value="-3">GMT -03:00 hrs - BZT2 or AWT</option>
				<option value="-2">GMT -02:00 hrs - AT</option>
				<option value="-1">GMT -01:00 hrs - WAT</option>
				<option value="0">Greenwich Mean Time - GMT or UT</option>
				<option value="1">GMT +01:00 hrs - CET or MET or BST</option>
				<option value="2">GMT +02:00 hrs - EET or CED or MED or BDST or BWT</option>
				<option value="3">GMT +03:00 hrs - BAT or EED</option>
				<option value="3.5">GMT +03:30 hrs - IT</option>
				<option value="4">GMT +04:00 hrs - USZ3</option>
				<option value="5">GMT +05:00 hrs - USZ4</option>
				<option value="5.5">GMT +05:30 hrs - IST</option>
				<option value="6">GMT +06:00 hrs - USZ5</option>
				<option value="6.5">GMT +06:30 hrs - NST</option>
				<option value="7">GMT +07:00 hrs - SST or USZ6</option>
				<option value="7.5">GMT +07:30 hrs - JT</option>
				<option value="8">GMT +08:00 hrs - AWST or CCT</option>
				<option value="8.5">GMT +08:30 hrs - MT</option>
				<option value="9">GMT +09:00 hrs - JST or AWDT</option>
				<option value="9.5">GMT +09:30 hrs - ACST or SAT or SAST</option>
				<option value="10">GMT +10:00 hrs - AEST or GST</option>
				<option value="10.5">GMT +10:30 hrs - ACDT or SDT or SAD</option>
				<option value="11">GMT +11:00 hrs - UZ10 or AEDT</option>
				<option value="11.5">GMT +11:30 hrs - NZ</option>
				<option value="12">GMT +12:00 hrs - NZT or IDLE</option>
				<option value="12.5">GMT +12:30 hrs - NZS</option>
				<option value="13">GMT +13:00 hrs - NZST</option>
			</select>
			<? if ($timezone) echo "<script>document.getElementById('timezone".$p."').value='".$timezone."';</script>"; ?>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="form-group">
		<div class="col-lg-3 no-padding control-label">Longtitude</div>
		<div class="col-lg-9">
			<input name="long_deg<? echo $p ?>" maxlength="3" size="3" value="<? echo $long_deg ?>" type="number" min="1" max="999" placeholder="deg">
			<select id="ew<? echo $p ?>" name="ew<? echo $p ?>">
				<option value="1">E</option> <option value="-1">W</option>
			</select>
			<? if ($ew) echo "<script>document.getElementById('ew".$p."').value='".$ew."';</script>"; ?>
<!--		<input maxlength="2" size="2" value="<? echo $long_min ?>" name="long_min<? echo $p ?>"/> -->
			<input name="long_min<? echo $p ?>" maxlength="3" size="3" value="<? echo $long_min ?>" type="number" min="1" max="999" placeholder="min">
			<br/><font color="#0000ff">(example: Chicago is 87 W 39, Sydney is 151 E 13)</font>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="form-group">
		<div class="col-lg-3 no-padding control-label">Latitude</div>
		<div class="col-lg-9">
			<input name="lat_deg<? echo $p ?>" maxlength="3" size="3" value="<? echo $lat_deg ?>" type="number" min="1" max="999" placeholder="deg">
			<select id="ns<? echo $p ?>" name="ns<? echo $p ?>">
				<option value="1">N</option> <option value="-1">S</option>
			</select>
			<? if ($ns) echo "<script>document.getElementById('ns".$p."').value='".$ns."';</script>"; ?>
			<input name="lat_min<? echo $p ?>" maxlength="3" size="3" value="<? echo $lat_min ?>" type="number" min="1" max="999" placeholder="min">
			<br/><font color="#0000ff">(example: Chicago is 41 N 51, Sydney is 33 S 52)</font>
		</div>
		<div class="clearfix"></div>
	</div> 

<? // $config->addJS('dist', 'form.js'); ?>
