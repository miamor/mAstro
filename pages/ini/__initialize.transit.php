<? $name = $cIn['name'];
$gender = $cIn['gender'];
$bday = $cIn['birthday'];
$day = date('d', $bday);
$month = date('m', $bday);
$year = date('Y', $bday);
$hour = explode(':', $cIn['birthhour'])[0];
$minute = explode(':', $cIn['birthhour'])[1];
/*$my_longitude = explode('|', $cIn['long'])[1];
$my_latitude = explode('|', $cIn['lat'])[1];
$ns_txt = explode('|', $cIn['lat'])[0];
$ew_txt = explode('|', $cIn['long'])[0];
*/$long_deg = $cIn['long_deg'];
$long_min = $cIn['long_min'];
$lat_deg = $cIn['lat_deg'];
$lat_min = $cIn['lat_min'];
$ns_txt = $cIn['ns'];
$ew_txt = $cIn['ew'];
if ($ew_txt == 'e') $ew = 1;
else $ew = -1;
if ($ns_txt == 'n') $ns = 1;
else $ns = -1;
$my_longitude = $ew * ($long_deg + ($long_min / 60));
$my_latitude = $ns * ($lat_deg + ($lat_min / 60));
$country = $cIn['country'];
$town = $cIn['town'];
$timezone = $cIn['timezone'];
/*$cDataAr = explode('||', $cIn['data']);
$cData0 = $cDataAr[0];
$cData1 = $cDataAr[1];
*/$start_day = explode('|', $cIn['start'])[0];
$start_month = explode('|', $cIn['start'])[1];
$start_year = explode('|', $cIn['start'])[2];

$restored_name = stripslashes($name);

	$secs = "0";
	if ($timezone < 0) 
		$tz = $timezone;
	else 
		$tz = "+" . $timezone;

	$swephsrc = 'sweph';
	$sweph = 'sweph';

	// Unset any variables not initialized elsewhere in the program
	unset($PATH,$out,$pl_name,$longitude1,$house_pos);

	//assign data from database to local variables
	$inmonth = $month;
	$inday = $day;
	$inyear = $year;

	$inhours = $hour;
	$inmins = $minute;
	$insecs = "0";

	$intz = $timezone;

	if ($intz >= 0) {
		$whole = floor($intz);
		$fraction = $intz - floor($intz);
	} else {
		$whole = ceil($intz);
		$fraction = $intz - ceil($intz);
	}

	$inhours = $inhours - $whole;
	$inmins = $inmins - ($fraction * 60);

	// adjust date and time for minus hour due to time zone taking the hour negative
	$utdatenow = strftime("%d.%m.%Y", mktime($inhours, $inmins, $insecs, $inmonth, $inday, $inyear));
	$utnow = strftime("%H:%M:%S", mktime($inhours, $inmins, $insecs, $inmonth, $inday, $inyear));

	$PATH = 0;
	putenv("PATH=$PATH:$swephsrc");

	// get LAST_PLANET planets and all house cusps
	if (!isset($h_sys) || strlen($h_sys) != 1) 
		$h_sys = "p";

	exec (SWEPH.SWETEST." -edir".SWEPH." -b$utdatenow -ut$utnow -p0123456789DAttt -eswe -house$my_longitude,$my_latitude,$h_sys -flsj -g, -head", $out);
//	print_r($out);

	// Each line of output data from swetest is exploded into array $row, giving these elements:
	// 0 = longitude
	// 1 = speed
	// 2 = house position
	// planets are index 0 - index (LAST_PLANET), house cusps are index (LAST_PLANET + 1) - (LAST_PLANET + 12)
	foreach ($out as $key => $line) {
		$row = explode(',',$line);
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
		else 
			$day_chart = True;
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


//Progressed calculations
	// Unset any variables not initialized elsewhere in the program
	unset($out,$longitude2,$speed2);

	// get all variables from form - Progressions
	//get todays date and time
	$name2 = "Progressions";

	// get progressed birthday
	$n_mc = $house_pos1[10];
	$n_sun = $longitude1[0];
	$latitude = $my_latitude;

	$birth_JD = gregoriantojd($month, $day, $year) - 0.5;					// find Julian day for birth date at midnight.
	$start_JD = gregoriantojd($start_month, $start_day, $start_year) - 0.5;	// find Julian day for start of relationship at midnight.

	$birth_JD = $birth_JD + (($inhours + ($inmins / 60)) / 24);
	$start_JD = $start_JD + (($inhours + ($inmins / 60)) / 24);

	$days_alive = $start_JD - $birth_JD;
	$prog_time_to_add = $days_alive / 365.25;
	$jd_to_use = $birth_JD + $prog_time_to_add;

	exec (SWEPH.SWETEST." -edir".SWEPH." -bj$jd_to_use -ut -p0123456789DAttt -eswe -fls -g, -head", $out);	//add a planet

	// Each line of output data from swetest is exploded into array $row, giving these elements:
	// 0 = longitude
	// 1 = speed
	// planets are index 0 - index (LAST_PLANET), house cusps are index (LAST_PLANET + 1) - (LAST_PLANET + 12)
	foreach ($out as $key => $line) {
		$row = explode(',', $line);
		$longitude2[$key] = $row[0];
		$speed2[$key] = $row[1];
	};

//add a planet - maybe some code needs to be put here
	$p_mc = Crunch($longitude1[LAST_PLANET + 10] + $longitude2[0] - $longitude1[0]);
	$ob_deg = Get_OB_Ecl($jd_to_use);

//FOR DEBUG
//echo $longitude1[LAST_PLANET + 10] . "<br><br>";
//echo $longitude2[0] . "<br><br>";
//echo $longitude1[0] . "<br><br>";
//echo $p_mc . "<br><br>";
//echo $ob_deg . "<br><br>";

	$p_RAMC = r2d(atan(Cosine($ob_deg) * Sine($p_mc) / Cosine($p_mc)));

	if (Cosine($p_mc) < 0) $p_RAMC = $p_RAMC + 180;

	if ($p_RAMC < 0) $p_RAMC = $p_RAMC + 360;

	$p_RAMC_r = d2r($p_RAMC);
	$ob_r = d2r($ob_deg);

	$a1 = atan(Cosine($p_RAMC) / (-Sine($p_RAMC) * Cosine($ob_deg) - tan(d2r($latitude)) * Sine($ob_deg)));

	if ($a1 < 0) $a1 = $a1 + 3.1415926535;

	if (Cosine($p_RAMC) < 0) $a1 = $a1 + 3.1415926535;

	$longitude2[LAST_PLANET + 1] = Mod360(r2d($a1));
	$longitude2[LAST_PLANET + 10] = $p_mc;

//get the progressed Part of Fortune
	if ($day_chart == True) $longitude2[SE_POF] = $longitude2[LAST_PLANET + 1] + $longitude2[1] - $longitude2[0];
	else $longitude2[SE_POF] = $longitude2[LAST_PLANET + 1] - $longitude2[1] + $longitude2[0];

	if ($longitude2[SE_POF] >= 360) $longitude2[SE_POF] = $longitude2[SE_POF] - 360;

	if ($longitude2[SE_POF] < 0) $longitude2[SE_POF] = $longitude2[SE_POF] + 360;


//Transit calculations
	// Unset any variables not initialized elsewhere in the program
	unset($out,$longitude3,$speed3);

	// get all variables from form - Transits
	//get todays date and time
	$name3 = "Transits";
	$inmonth = $start_month;
	$inday = $start_day;
	$inyear = $start_year;

	$hour3 = gmdate("H");
	$minute3 = gmdate("i");
	$timezone3 = 0;

	$inhours = $hour3;
	$inmins = $minute3;
	$insecs = "0";

	$intz = $timezone3;

	// adjust date and time for minus hour due to time zone taking the hour negative
	$utdatenow = strftime("%d.%m.%Y", mktime($inhours, $inmins, $insecs, $inmonth, $inday, $inyear));
	$utnow = strftime("%H:%M:%S", mktime($inhours, $inmins, $insecs, $inmonth, $inday, $inyear));

	exec (SWEPH.SWETEST." -edir".SWEPH." -b$utdatenow -ut$utnow -p0123456789DAttt -eswe -fls -g, -head", $out);	//add a planet

	// Each line of output data from swetest is exploded into array $row, giving these elements:
	// 0 = longitude
	// 1 = speed
	// planets are index 0 - index (LAST_PLANET), house cusps are index (LAST_PLANET + 1) - (LAST_PLANET + 12)
	foreach ($out as $key => $line) {
		$row = explode(',',$line);
		$longitude3[$key] = $row[0];
		$speed3[$key] = $row[1];
	};


//Solar arc calculations
	// Unset any variables not initialized elsewhere in the program
	unset($out, $longitude2, $speed2);

	// get all variables from form - solar_arcs
	//get todays date and time
	$name4 = "Solar Arcs";

	// get progressed birthday
	$birth_JD = gregoriantojd($month, $day, $year) - 0.5;					// find Julian day for birth date at midnight.
	$start_JD = gregoriantojd($start_month, $start_day, $start_year) - 0.5;	// find Julian day for start of relationship at midnight.

	$birth_JD = $birth_JD + (($inhours + ($inmins / 60)) / 24);
	$start_JD = $start_JD + (($inhours + ($inmins / 60)) / 24);

	$days_alive = $start_JD - $birth_JD;
	$prog_time_to_add = $days_alive / 365.25;
	$jd_to_use = $birth_JD + $prog_time_to_add;

	exec (SWEPH.SWETEST." -edir".SWEPH." -bj$jd_to_use -ut -p0 -eswe -fl -g, -head", $out);	//add a planet

	// Each line of output data from swetest is exploded into array $row, giving these elements:
	// 0 = longitude of Sun
	foreach ($out as $key => $line) {
			$row = explode(',',$line);
		$longitude2[$key] = $row[0];
	};

//add a planet - maybe some code needs to be put here

	$p_sun = $longitude2[0];
	$solar_arc = Crunch($longitude2[0] - $longitude1[0]);

	for ($i = 0; $i <= LAST_PLANET + 12; $i++) $longitude2[$i] = Crunch($longitude1[$i] + $solar_arc);


	$hr_ob = $hour;
	$min_ob = $minute;

	$ubt1 = 0;
	if (($hr_ob == 12) And ($min_ob == 0)) 
		$ubt1 = 1;	// this person has an unknown birth time

	$ubt2 = $ubt1;

	$hr_ob3 = $hour3;
	$min_ob3 = $minute3;

	$ubt3 = 1;		//always assume an unknown time

	if ($ubt1 == 1) 
		$a1 = SE_TNODE;
	else 
		$a1 = LAST_PLANET;

	$rx1 = "";
	for ($i = 0; $i <= SE_TNODE; $i++) {
		if ($speed1[$i] < 0) 
			$rx1 .= "R";
		else 
			$rx1 .= " ";
	}

	$rx2 = "";
	for ($i = 0; $i <= SE_TNODE; $i++) $rx2 .= " ";

	$rx3 = "";
	for ($i = 0; $i <= SE_TNODE; $i++) {
		if ($speed3[$i] < 0) $rx3 .= "R";
		else $rx3 .= " ";
	}

	for ($i = 0; $i <= LAST_PLANET; $i++) {
		$L1[$i] = $longitude1[$i];
		$L2[$i] = $longitude2[$i];
		$L3[$i] = $longitude3[$i];
	}
	for ($i = 1; $i <= LAST_PLANET; $i++) {
		$hc1[$i] = $longitude1[LAST_PLANET + $i];
		$hc3[$i] = $longitude3[LAST_PLANET + $i];
	}

	for ($i = 1; $i <= 12; $i++) $hc2[$i] = ($i - 1) * 30;

	$hc2[13] = 0;

	$L2[LAST_PLANET + 1] = $longitude2[LAST_PLANET + 1];
	$L2[LAST_PLANET + 2] = $longitude2[LAST_PLANET + 10];


// no need to urlencode unless perhaps magic quotes is ON (??)
	$ser_L1 = serialize($L1);
	$ser_hc1 = serialize($hc1);
	$ser_L2 = serialize($L2);
	$ser_hc2 = serialize($hc2);
	$ser_L3 = serialize($L3);
	$ser_hc3 = serialize($hc3);

$longAr = DECtoDMS($my_longitude);
$latAr = DECtoDMS($my_latitude);

$sunSign = $sign_name[floor($longitude1[0] / 30) + 1];

$sunSignCode = trendCode($sunSign);

//if (!$cIn['thumb']) $change = changeValue($tb, "`id` = '{$iid}' ", "`thumb` = '{$sunSignCode}' ");

function mod360 ($x) {
	return $x - (floor($x / 360) * 360);
}

function Get_OB_Ecl ($jd) {
	// fetch mean obliquity
	$t = ($jd - 2451545) / 36525;
	$epsilon = 23.43929111;
	$epsilon = $epsilon - (46.815 * $t / 3600);
	$epsilon = $epsilon - (0.00059 * $t * $t / 3600);
	$epsilon = $epsilon + (0.001813 * $t * $t * $t / 3600);
	return $epsilon;
}

function Sine ($x) {
	return sin($x * 3.1415926535 / 180);
}

function Cosine ($x) {
	return cos($x * 3.1415926535 / 180);
}

function r2d ($x) {
  return $x * 180 / 3.1415926535;
}

function d2r ($x) {
  return $x * 3.1415926535 / 180;
}
?>
