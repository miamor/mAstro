<?
function ConvertJDtoDateandTime ($Result_JD, $current_tz) {
	//returns date and time in local time, e.g. 9/3/2007 4:59 am
	//get calendar day - must adjust for the way the PHP function works by adding 0.5 days to the JD of interest
	$jd_to_use = $Result_JD + $current_tz / 24;

	$JDDate = jdtogregorian($jd_to_use + 0.5);

	$fraction = $jd_to_use - floor($jd_to_use);

	if ($fraction < 0.5) $am_pm = "pm";
	else {
		$fraction = $fraction - 0.5;
		$am_pm = "am";
	}

	$hh = $fraction * 24;
	if ($hh < 1) $hh = $hh + 12;

	$mm = $hh - floor($hh);
	$mins = floor($mm * 60);

	$secs = floor(($mm * 60 - floor($mm * 60)) * 60);
	if ($secs == 30) $secs = "30";
	else $secs = "00";

	if ($mins < 10) return $JDDate . " " . floor($hh) . ":0" . floor($mm * 60) . ":" . $secs . " " . $am_pm;
	else return $JDDate . " " . floor($hh) . ":" . floor($mm * 60) . ":" . $secs . " " . $am_pm;
}

$name1 = explode('::', $cIn['name'])[0];
$gender1 = explode('::', $cIn['gender'])[0];
$bday1 = explode('::', $cIn['birthday'])[0];
$day1 = date('d', $bday1);
$month1 = date('m', $bday1);
$year1 = date('Y', $bday1);
$bhour1 = explode('::', $cIn['birthhour'])[0];
$hour1 = explode(':', $bhour1)[0];
$minute1 = explode(':', $bhour1)[1];
/*$my_longitude1 = explode('::', explode('|', $cIn['long'])[1])[0];
$my_latitude1 = explode('::', explode('|', $cIn['lat'])[1])[0];
$ns_txt1 = explode('::', explode('|', $cIn['lat'])[0])[0];
$ew_txt1 = explode('::', explode('|', $cIn['long'])[0])[0];
*/$long_deg1 = explode('::', $cIn['long_deg'])[0];
$long_min1 = explode('::', $cIn['long_min'])[0];
$lat_deg1 = explode('::', $cIn['lat_deg'])[0];
$lat_min1 = explode('::', $cIn['lat_min'])[0];
$ns_txt1 = explode('::', $cIn['ns'])[0];
$ew_txt1 = explode('::', $cIn['ew'])[0];
if ($ew_txt1 == 'e') $ew1 = 1;
else $ew1 = -1;
if ($ns_txt1 == 'n') $ns1 = 1;
else $ns1 = -1;
$my_longitude1 = $ew1 * ($long_deg1 + ($long_min1 / 60));
$my_latitude1 = $ns1 * ($lat_deg1 + ($lat_min1 / 60));
$country1 = explode('::', $cIn['country'])[0];
$town1 = explode('::', $cIn['town'])[0];
$timezone1 = explode('::', $cIn['timezone'])[0];

$name2 = explode('::', $cIn['name'])[1];
$gender2 = explode('::', $cIn['gender'])[1];
$bday2 = explode('::', $cIn['birthday'])[1];
$day2 = date('d', $bday2);
$month2 = date('m', $bday2);
$year2 = date('Y', $bday2);
$bhour2 = explode('::', $cIn['birthhour'])[1];
$hour2 = explode(':', $bhour2)[0];
$minute2 = explode(':', $bhour2)[1];
/*$my_longitude2 = explode('::', explode('|', $cIn['long'])[1])[1];
$my_latitude2 = explode('::', explode('|', $cIn['lat'])[1])[1];
$ns_txt2 = explode('::', explode('|', $cIn['lat'])[0])[1];
$ew_txt2 = explode('::', explode('|', $cIn['long'])[0])[1];
*/$long_deg2 = explode('::', $cIn['long_deg'])[1];
$long_min2 = explode('::', $cIn['long_min'])[1];
$lat_deg2 = explode('::', $cIn['lat_deg'])[1];
$lat_min2 = explode('::', $cIn['lat_min'])[1];
$ns_txt2 = explode('::', $cIn['ns'])[1];
$ew_txt2 = explode('::', $cIn['ew'])[1];
if ($ew_txt2 == 'e') $ew2 = 1;
else $ew2 = -1;
if ($ns_txt2 == 'n') $ns2 = 1;
else $ns2 = -1;
$my_longitude2 = $ew2 * ($long_deg2 + ($long_min2 / 60));
$my_latitude2 = $ns2 * ($lat_deg2 + ($lat_min2 / 60));

$country2 = explode('::', $cIn['country'])[1];
$town2 = explode('::', $cIn['town'])[1];
$timezone2 = explode('::', $cIn['timezone'])[1];

	$swephsrc = 'sweph';
	$sweph = 'sweph';

//	putenv("PATH=$PATH:$swephsrc");

	if (!isset($h_sys) || strlen($h_sys) != 1)
		$h_sys = "p";

//Person 1
	// Unset any variables not initialized elsewhere in the program
	unset($PATH,$out,$pl_name,$longitude1,$house_pos1);

	$inmonth1 = $month1;
	$inday1 = $day1;
	$inyear1 = $year1;

	$inhours1 = $hour1;
	$inmins1 = $minute1;
	$insecs1 = "0";

	$intz1 = $timezone1;

	if ($intz1 >= 0) {
		$whole1 = floor($intz1);
		$fraction1 = $intz1 - floor($intz1);
	} else {
		$whole1 = ceil($intz1);
		$fraction1 = $intz1 - ceil($intz1);
	}

	$inhours1 = $inhours1 - $whole1;
	$inmins1 = $inmins1 - ($fraction1 * 60);

	// adjust date and time for minus hour due to time zone taking the hour negative
	$utdatenow1 = strftime("%d.%m.%Y", mktime($inhours1, $inmins1, $insecs1, $inmonth1, $inday1, $inyear1));
	$utnow1 = strftime("%H:%M:%S", mktime($inhours1, $inmins1, $insecs1, $inmonth1, $inday1, $inyear1));

	exec (SWETEST." -b$utdatenow1 -ut$utnow1 -p0123456789DAttt -eswe -house$my_longitude1,$my_latitude1,$h_sys -flsj -g, -head", $out);		//add a planet
	//exec (SWEPH.SWETEST." -edir".SWEPH." -b$utdatenow1 -ut$utnow1 -p0123456789DAttt -eswe -house$my_longitude1,$my_latitude1,$h_sys -flsj -g, -head", $out);		//add a planet

	// Each line of output data from swetest is exploded into array $row, giving these elements:
	// 0 = longitude
	// 1 = speed
	// 2 = house position
	// planets are index 0 - index (LAST_PLANET), house cusps are index (LAST_PLANET + 1) - (LAST_PLANET + 12)
	foreach ($out as $key => $line) {
//		print_r($line);
		$row = explode(',', $line);
		$longitude1[$key] = $row[0];
		$speed1[$key] = $row[1];
		$house_pos1[$key] = (isset($row[2])) ? $row[2] : '';
	}

	include __ASTRO.'/constants.php'; // this is here because we must rename the planet names

	//calculate the Part of Fortune
	//is this a day chart or a night chart?
	if ($longitude1[LAST_PLANET + 1] > $longitude1[LAST_PLANET + 7]) {
		if ($longitude1[0] <= $longitude1[LAST_PLANET + 1] And $longitude1[0] > $longitude1[LAST_PLANET + 7])
			$day_chart = True;
		else
			$day_chart = False;
	} else {
		if ($longitude1[0] > $longitude1[LAST_PLANET + 1] And $longitude1[0] <= $longitude1[LAST_PLANET + 7])
			$day_chart = False;
		else $day_chart = True;
	}

	if ($day_chart == True)
		$longitude1[SE_POF] = $longitude1[LAST_PLANET + 1] + $longitude1[1] - $longitude1[0];
	else
		$longitude1[SE_POF] = $longitude1[LAST_PLANET + 1] - $longitude1[1] + $longitude1[0];

	if ($longitude1[SE_POF] >= 360)
		$longitude1[SE_POF] = $longitude1[SE_POF] - 360;

	if ($longitude1[SE_POF] < 0)
		$longitude1[SE_POF] = $longitude1[SE_POF] + 360;

	//add a planet - maybe some code needs to be put here

	//capture the Vertex longitude
	$longitude1[LAST_PLANET] = $longitude1[LAST_PLANET + 16];		//Asc = +13, MC = +14, RAMC = +15, Vertex = +16

	//get house positions of planets here
	for ($x = 1; $x <= 12; $x++) {
		for ($y = 0; $y <= LAST_PLANET; $y++) {
			$pl = $longitude1[$y] + (1 / 36000);
			if ($x < 12 And $longitude1[$x + LAST_PLANET] > $longitude1[$x + LAST_PLANET + 1]) {
				if (($pl >= $longitude1[$x + LAST_PLANET] And $pl < 360) Or ($pl < $longitude1[$x + LAST_PLANET + 1] And $pl >= 0)) {
					$house_pos1[$y] = $x;
					continue;
				}
			}

			if ($x == 12 And ($longitude1[$x + LAST_PLANET] > $longitude1[LAST_PLANET + 1])) {
				if (($pl >= $longitude1[$x + LAST_PLANET] And $pl < 360) Or ($pl < $longitude1[LAST_PLANET + 1] And $pl >= 0))
					$house_pos1[$y] = $x;
				continue;
			}

			if (($pl >= $longitude1[$x + LAST_PLANET]) And ($pl < $longitude1[$x + LAST_PLANET + 1]) And ($x < 12)) {
				$house_pos1[$y] = $x;
				continue;
			}

			if (($pl >= $longitude1[$x + LAST_PLANET]) And ($pl < $longitude1[LAST_PLANET + 1]) And ($x == 12))
				$house_pos1[$y] = $x;
		}
	}



//Person 2 calculations
	// Unset any variables not initialized elsewhere in the program
//	unset($out,$longitude2,$house_pos2);

	//assign data from database to local variables
	$inmonth2 = $month2;
	$inday2 = $day2;
	$inyear2 = $year2;

	$inhours2 = $hour2;
	$inmins2 = $minute2;
	$insecs2 = "0";

	$intz2 = $timezone2;

	if ($intz2 >= 0) {
		$whole2 = floor($intz2);
		$fraction2 = $intz2 - floor($intz2);
	} else {
		$whole2 = ceil($intz2);
		$fraction2 = $intz2 - ceil($intz2);
	}

	$inhours2 = $inhours2 - $whole2;
	$inmins2 = $inmins2 - ($fraction2 * 60);

	// adjust date and time for minus hour due to time zone taking the hour negative
	$utdatenow2 = strftime("%d.%m.%Y", mktime($inhours2, $inmins2, $insecs2, $inmonth2, $inday2, $inyear2));
	$utnow2 = strftime("%H:%M:%S", mktime($inhours2, $inmins2, $insecs2, $inmonth2, $inday2, $inyear2));

	exec (SWETEST." -b$utdatenow2 -ut$utnow2 -p0123456789DAttt -eswe -house$my_longitude2,$my_latitude2,$h_sys -flsj -g, -head", $out2);		//add a planet
	//exec (SWEPH.SWETEST." -edir".SWEPH." -b$utdatenow2 -ut$utnow2 -p0123456789DAttt -eswe -house$my_longitude2,$my_latitude2,$h_sys -flsj -g, -head", $out2);		//add a planet

	// Each line of output data from swetest is exploded into array $row, giving these elements:
	// 0 = longitude
	// 1 = speed
	// 2 = house position
	// planets are index 0 - index (LAST_PLANET), house cusps are index (LAST_PLANET + 1) - (LAST_PLANET + 12)
	foreach ($out2 as $key => $line) {
//		print_r($line);
		$row = explode(',', $line);
		$longitude2[$key] = $row[0];
		$speed2[$key] = $row[1];
		$house_pos2[$key] = $row[2];
	}

	//calculate the Part of Fortune
	//is this a day chart or a night chart?
	if ($longitude2[LAST_PLANET + 1] > $longitude2[LAST_PLANET + 7]) {
		if ($longitude2[0] <= $longitude2[LAST_PLANET + 1] And $longitude2[0] > $longitude2[LAST_PLANET + 7])
			$day_chart = True;
		else
			$day_chart = False;
	} else {
		if ($longitude2[0] > $longitude2[LAST_PLANET + 1] And $longitude2[0] <= $longitude2[LAST_PLANET + 7])
			$day_chart = False;
		else $day_chart = True;
	}

	if ($day_chart == True)
		$longitude2[SE_POF] = $longitude2[LAST_PLANET + 1] + $longitude2[1] - $longitude2[0];
	else
		$longitude2[SE_POF] = $longitude2[LAST_PLANET + 1] - $longitude2[1] + $longitude2[0];

	if ($longitude2[SE_POF] >= 360)
		$longitude2[SE_POF] = $longitude2[SE_POF] - 360;

	if ($longitude2[SE_POF] < 0)
		$longitude2[SE_POF] = $longitude2[SE_POF] + 360;

	//add a planet - maybe some code needs to be put here

	//capture the Vertex longitude
	$longitude2[LAST_PLANET] = $longitude2[LAST_PLANET + 16];		//Asc = +13, MC = +14, RAMC = +15, Vertex = +16

	//get house positions of planets here
	for ($x = 1; $x <= 12; $x++) {
		for ($y = 0; $y <= LAST_PLANET; $y++) {
			$pl = $longitude2[$y] + (1 / 36000);
			if ($x < 12 And $longitude2[$x + LAST_PLANET] > $longitude2[$x + LAST_PLANET + 1]) {
				if (($pl >= $longitude2[$x + LAST_PLANET] And $pl < 360) Or ($pl < $longitude2[$x + LAST_PLANET + 1] And $pl >= 0)) {
					$house_pos2[$y] = $x;
					continue;
				}
			}

			if ($x == 12 And ($longitude2[$x + LAST_PLANET] > $longitude2[LAST_PLANET + 1])) {
				if (($pl >= $longitude2[$x + LAST_PLANET] And $pl < 360) Or ($pl < $longitude2[LAST_PLANET + 1] And $pl >= 0))
					$house_pos2[$y] = $x;
				continue;
			}

			if (($pl >= $longitude2[$x + LAST_PLANET]) And ($pl < $longitude2[$x + LAST_PLANET + 1]) And ($x < 12)) {
				$house_pos2[$y] = $x;
				continue;
			}

			if (($pl >= $longitude2[$x + LAST_PLANET]) And ($pl < $longitude2[LAST_PLANET + 1]) And ($x == 12))
				$house_pos2[$y] = $x;
		}
	}


// Davison
	$my_longitude3 = ($my_longitude1 + $my_longitude2) / 2;
	$my_latitude3 = ($my_latitude1 + $my_latitude2) / 2;

	$jd1 = gregoriantojd($inmonth1, $inday1, $inyear1) - 0.5 + ($inhours1 / 24) + ($inmins1 / 1440);
	$jd2 = gregoriantojd($inmonth2, $inday2, $inyear2) - 0.5 + ($inhours2 / 24) + ($inmins2 / 1440);

	$jd3 = ($jd1 + $jd2) / 2;

	//exec (SWEPH.SWETEST." -edir".SWEPH." -bj$jd3 -p0123456789DAttt -eswe -house$my_longitude3,$my_latitude3,$h_sys -flsj -g, -head", $out3);
	exec (SWETEST." -bj$jd3 -p0123456789DAttt -eswe -house$my_longitude3,$my_latitude3,$h_sys -flsj -g, -head", $out3);

	// Each line of output data from swetest is exploded into array $row, giving these elements:
	// 0 = longitude
	// 1 = speed
	// 2 = house position
	// planets are index 0 - index (LAST_PLANET), house cusps are index (LAST_PLANET + 1) - (LAST_PLANET + 12)
	foreach ($out3 as $key => $line) {
		$row = explode(',', $line);
		$longitude3[$key] = $row[0];
		$speed3[$key] = $row[1];
		$house_pos3[$key] = $row[2];
	}

	//calculate the Part of Fortune
	//is this a day chart or a night chart?
	if ($longitude3[LAST_PLANET + 1] > $longitude3[LAST_PLANET + 7]) {
		if ($longitude3[0] <= $longitude3[LAST_PLANET + 1] And $longitude3[0] > $longitude3[LAST_PLANET + 7])
			$day_chart = True;
		else
			$day_chart = False;
	} else {
		if ($longitude3[0] > $longitude3[LAST_PLANET + 1] And $longitude3[0] <= $longitude3[LAST_PLANET + 7])
			$day_chart = False;
		else $day_chart = True;
	}

	if ($day_chart == True)
		$longitude3[SE_POF] = $longitude3[LAST_PLANET + 1] + $longitude3[1] - $longitude3[0];
	else
		$longitude3[SE_POF] = $longitude3[LAST_PLANET + 1] - $longitude3[1] + $longitude3[0];

	if ($longitude3[SE_POF] >= 360)
		$longitude3[SE_POF] = $longitude3[SE_POF] - 360;

	if ($longitude3[SE_POF] < 0)
		$longitude3[SE_POF] = $longitude3[SE_POF] + 360;

	//add a planet - maybe some code needs to be put here

	//capture the Vertex longitude
	$longitude3[LAST_PLANET] = $longitude3[LAST_PLANET + 16];		//Asc = +13, MC = +14, RAMC = +15, Vertex = +16

	//get house positions of planets here
	for ($x = 1; $x <= 12; $x++) {
		for ($y = 0; $y <= LAST_PLANET; $y++) {
			$pl = $longitude3[$y] + (1 / 36000);
			if ($x < 12 And $longitude3[$x + LAST_PLANET] > $longitude3[$x + LAST_PLANET + 1]) {
				if (($pl >= $longitude3[$x + LAST_PLANET] And $pl < 360) Or ($pl < $longitude3[$x + LAST_PLANET + 1] And $pl >= 0)) {
					$house_pos3[$y] = $x;
					continue;
				}
			}

			if ($x == 12 And ($longitude3[$x + LAST_PLANET] > $longitude3[LAST_PLANET + 1])) {
				if (($pl >= $longitude3[$x + LAST_PLANET] And $pl < 360) Or ($pl < $longitude3[LAST_PLANET + 1] And $pl >= 0))
					$house_pos3[$y] = $x;
				continue;
			}

			if (($pl >= $longitude3[$x + LAST_PLANET]) And ($pl < $longitude3[$x + LAST_PLANET + 1]) And ($x < 12)) {
				$house_pos3[$y] = $x;
				continue;
			}

			if (($pl >= $longitude3[$x + LAST_PLANET]) And ($pl < $longitude3[LAST_PLANET + 1]) And ($x == 12))
				$house_pos3[$y] = $x;
		}
	}


//display natal data
	$secs = "0";
	if ($timezone1 < 0) $tz1 = $timezone1;
	else $tz1 = "+" . $timezone1;

	if ($timezone2 < 0) $tz2 = $timezone2;
	else $tz2 = "+" . $timezone2;

	$tz3 = ($tz1 + $tz2) / 2;
	$relationship_date = ConvertJDtoDateandTime($jd3, $tz3);

	$name_without_slashes = stripslashes($name1);
	$name2_without_slashes = stripslashes($name2);

	$hr_ob1 = $hour1;
	$min_ob1 = $minute1;
	$ubt1 = 0;
	if (($hr_ob1 == 12) And ($min_ob1 == 0)) $ubt1 = 1;				// this person has an unknown birth time

	$hr_ob2 = $hour2;
	$min_ob2 = $minute2;
	$ubt2 = 0;
	if (($hr_ob2 == 12) And ($min_ob2 == 0)) $ubt2 = 1;				// this person has an unknown birth time

	if ($ubt1 == 1 Or $ubt2 == 1) {
		$ubt1 = 1;
		$ubt2 = 1;
	}

	$rx1 = "";
	for ($i = 0; $i <= SE_TNODE; $i++) {
		if ($speed1[$i] < 0) $rx1 .= "R";
		else $rx1 .= " ";
	}

	$rx2 = '';
	for ($i = 0; $i <= SE_TNODE; $i++) {
		if ($speed2[$i] < 0) $rx2 .= "R";
		else $rx2 .= " ";
	}

	// to make GET string shorter (for IE6)
	for ($i = 0; $i <= LAST_PLANET; $i++) {
		$S_L1[$i] = $longitude1[$i];
		$S_L2[$i] = $longitude2[$i];
	}
	for ($i = 1; $i <= LAST_PLANET; $i++) {
		$S_hc1[$i] = $longitude1[LAST_PLANET + $i];
		$S_hc2[$i] = $longitude2[LAST_PLANET + $i];
	}

	$rx3 = "";
	for ($i = 0; $i <= SE_TNODE; $i++) $rx3 .= " ";

	// calculate midpoints
	for ($i = 0; $i <= LAST_PLANET; $i++) {
		$L3[$i] = ($longitude1[$i] + $longitude2[$i]) / 2;
		$diff = abs($longitude1[$i] - $longitude2[$i]);

		if ($diff >= 180 And Abs($L3[$i] - $longitude1[$i]) > 90 And Abs($L3[$i] - $longitude2[$i]) > 90)
			$L3[$i] = $L3[$i] + 180;

		$L3[$i] = sprintf("%.3f", Crunch($L3[$i]));
	}

	// save house cusp data
	for ($i = 1; $i <= 12; $i++) {
		$hc1[$i] = $longitude1[LAST_PLANET + $i];
		$hc2[$i] = $longitude2[LAST_PLANET + $i];
	}

	// rearrange house cusps so house 10 is 1st house
	for ($i = 10; $i <= 12; $i++) {
		$hc1x[$i - 9] = $hc1[$i];
		$hc2x[$i - 9] = $hc2[$i];
	}

	for ($i = 1; $i <= 9; $i++) {
		$hc1x[$i + 3] = $hc1[$i];
		$hc2x[$i + 3] = $hc2[$i];
	}

	for ($i = 1; $i <= 12; $i++) {
		$hc3x[$i] = ($hc1x[$i] + $hc2x[$i]) / 2;
		if (abs($hc3x[$i] - $hc1x[$i]) > 90 Or abs($hc3x[$i] - $hc2x[$i]) > 90)
			$hc3x[$i] = $hc3x[$i] + 180;

		if ($hc3x[$i] >= 360) $hc3x[$i] = $hc3x[$i] - 360;

		if ($i >= 2) {
			if (abs($hc3x[$i] - $hc3x[$i - 1]) > 90 And abs($hc3x[$i] - $hc3x[$i - 1]) < 270)
				$hc3x[$i] = Crunch($hc3x[$i] + 180);
		}
	}

	// put the house cusps back in their original order - house cusp 1 is array element 1
	for ($i = 1; $i <= 9; $i++) $hc3[$i] = sprintf("%.3f", $hc3x[$i + 3]);

	for ($i = 10; $i <= 12; $i++) $hc3[$i] = sprintf("%.3f", $hc3x[$i - 9]);

	$hc3[13] = $hc3[1];

//get house positions of composite planets here
	for ($x = 1; $x <= 12; $x++) {
		for ($y = 0; $y <= LAST_PLANET; $y++) {
			$pl = $L3[$y] + (1 / 36000);
			if ($x < 12 And $hc3[$x] > $hc3[$x + 1]) {
				if (($pl >= $hc3[$x] And $pl < 360) Or ($pl < $hc3[$x + 1] And $pl >= 0)) {
					$house_pos3[$y] = $x;
					continue;
				}
			}

			if ($x == 12 And ($hc3[$x] > $hc3[1])) {
				if (($pl >= $hc3[$x] And $pl < 360) Or ($pl < $hc3[1] And $pl >= 0))
					$house_pos3[$y] = $x;
				continue;
			}

			if (($pl >= $hc3[$x]) And ($pl < $hc3[$x + 1]) And ($x < 12)) {
				$house_pos3[$y] = $x;
				continue;
			}

			if (($pl >= $hc3[$x]) And ($pl < $hc3[1]) And ($x == 12))
				$house_pos3[$y] = $x;
		}
	}


// no need to urlencode unless perhaps magic quotes is ON (??)
	$ser_L1 = serialize($L3);
	$ser_L2 = serialize($L3);
	$ser_hc1 = serialize($hc3);


//	$Drx1 = $rx1 = $Drx2;
	$Drx1 = "";
	for ($i = 0; $i <= SE_TNODE; $i++) {
		if ($speed3[$i] < 0) $Drx1 .= "R";
		else $Drx1 .= " ";
	}

	$Drx2 = $Drx1;

	// to make GET string shorter (for IE6)
	for ($i = 0; $i <= LAST_PLANET; $i++) {
		$D_L1[$i] = $longitude3[$i];
		$D_L2[$i] = $longitude4[$i];
	}

	// save house cusp data
	for ($i = 1; $i <= LAST_PLANET; $i++) $D_hc1[$i] = $longitude3[LAST_PLANET + $i];
//	print_r($out3);
// no need to urlencode unless perhaps magic quotes is ON (??)
	$Dser_L1 = serialize($D_L1);
	$Dser_L2 = serialize($D_L2);
	$Dser_hc1 = serialize($D_hc1);

	$Srx1 = $rx1;
	$Srx2 = $rx2;
	$Sser_L1 = serialize($S_L1);
	$Sser_hc1 = serialize($S_hc1);
	$Sser_L2 = serialize($S_L2);
	$Sser_hc2 = serialize($S_hc2);

$longAr1 = DECtoDMS($my_longitude1);
$latAr1 = DECtoDMS($my_latitude1);

$longAr2 = DECtoDMS($my_longitude2);
$latAr2 = DECtoDMS($my_latitude2);

$sunSign1 = $sign_name[floor($longitude1[0] / 30) + 1];
$sunSign2 = $sign_name[floor($longitude2[0] / 30) + 1];

$sunSignCode = trendCode($sunSign1).'-'.trendCode($sunSign2);

//if (!$cIn['thumb']) $change = changeValue($tb, "`id` = '{$iid}' ", "`thumb` = '{$sunSignCode}' ");
