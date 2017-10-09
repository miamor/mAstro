<? $name = $cIn['name'];
$gender = $cIn['gender'];
$bday = $cIn['birthday'];
$day = date('d', $bday);
$month = date('m', $bday);
$year = date('Y', $bday);
$profile_birthdata = $day.'/'.$month.'/'.$year;
$hour = explode(':', $cIn['birthhour'])[0];
$minute = explode(':', $cIn['birthhour'])[1];
/*$my_longitude = explode('|', $cIn['long'])[1];
$my_latitude = explode('|', $cIn['lat'])[1];
$ns_txt = explode('|', $cIn['lat'])[0];
$ew_txt = explode('|', $cIn['long'])[0];
*/
$long_deg = $cIn['long_deg'];
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
//$cDataAr = explode('||', $cIn['data']);

$restored_name = stripslashes($name);

	$secs = "0";
	if ($timezone < 0)
		$tz = $timezone;
	else
		$tz = "+" . $timezone;

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

/*	$swephsrc = MAIN_PATH.'/sweph';
	$sweph = MAIN_PATH.'/sweph';
	$PATH = 0;
	putenv("PATH=$PATH:$swephsrc");
*/
	// get LAST_PLANET planets and all house cusps
	if (!isset($h_sys) || strlen($h_sys) != 1)
		$h_sys = "p";

	//$cmdRun = SWEPH.SWETEST." -edir".SWEPH." -b$utdatenow -ut$utnow -p0123456789DAttt -eswe -house$my_longitude,$my_latitude,$h_sys -flsj -g, -head";
	$cmdRun = SWETEST." -b$utdatenow -ut$utnow -p0123456789DAttt -eswe -house$my_longitude,$my_latitude,$h_sys -flsj -g, -head";
	//echo $cmdRun.'~~~~';
	// opt/lampp/htdocs/astro/include/sweph/swetest -edir/opt/lampp/htdocs/astro/include/sweph/ -b28.07.1997 -ut18:10:00 -p0123456789DAttt -eswe -house105.85,21.033333333333,p -flsj -g, -head
	exec ($cmdRun, $out, $error);

/*	echo $cmdRun.'~~~~';
	print_r($out);
*/
	// Each line of output data from swetest is exploded into array $row, giving these elements:
	// 0 = longitude
	// 1 = speed
	// 2 = house position
	// planets are index 0 - index (LAST_PLANET), house cusps are index (LAST_PLANET + 1) - (LAST_PLANET + 12)
	foreach ($out as $key => $line) {
//		print_r($line);
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

	$hr_ob = $hour;
	$min_ob = $minute;

	$ubt1 = 0;
	if (($hr_ob == 12) And ($min_ob == 0))
		$ubt1 = 1;	// this person has an unknown birth time

	$ubt2 = $ubt1;

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

	$rx2 = $rx1;

	for ($i = 1; $i <= LAST_PLANET; $i++) $hc1[$i] = $longitude1[LAST_PLANET + $i];

	// no need to urlencode unless perhaps magic quotes is ON (??)
	$ser_L1 = serialize($longitude1);
	$ser_L2 = serialize($longitude1);
	$ser_hc1 = serialize($hc1);
	$ser_hpos = serialize($house_pos1);

	// include Ascendant and MC
	$longitude1[LAST_PLANET + 1] = $hc1[1];
	$longitude1[LAST_PLANET + 2] = $hc1[10];

	$pl_name[LAST_PLANET + 1] = "Ascendant";
	$pl_name[LAST_PLANET + 2] = "Midheaven";

$_SESSION['nL1'] = $longitude1;
$_SESSION['nHC1'] = $hc1;
$_SESSION['nH1'] = $house_pos1;

$filename = $cIn['id'].".png";
$grids_filename = MAIN_PATH."/data/{$page}/{$cIn['id']}_grids.png";
$grids_filename2 = MAIN_PATH."/data/{$page}/{$cIn['id']}_grids_2.png";
$chartwheel_filename = MAIN_PATH."/data/{$page}/{$cIn['id']}_wheel.png";
$chartwheel_filename2 = MAIN_PATH."/data/{$page}/{$cIn['id']}_wheel_2.png";
$grids_fileurl = MAIN_URL."/data/{$page}/{$cIn['id']}_grids.png";
$chartwheel_fileurl = MAIN_URL."/data/{$page}/{$cIn['id']}_wheel.png";
$grids_fileurl2 = MAIN_URL."/data/{$page}/{$cIn['id']}_grids2.png";
$chartwheel_fileurl2 = MAIN_URL."/data/{$page}/{$cIn['id']}_wheel2.png";
$_SESSION['chartwheel_filename'] = $chartwheel_filename;
$_SESSION['grids_filename'] = $grids_filename;

$sunSign = $sigi = $sign_name[floor($longitude1[0] / 30) + 1];
if ($ubt1 == 0) $rising = $sign_name[floor($hc1[1] / 30) + 1];
$mc = $sign_name[floor($hc1[10] / 30) + 1];
$moonSign = $sign_name[floor($longitude1[1] / 30) + 1];

$sunSignCode = trendCode($sunSign);
//if (!$cIn['thumb']) $change = changeValue($tb, "`id` = '{$cIn['id']}' ", "`thumb` = '{$sunSignCode}' ");

$longAr = DECtoDMS($my_longitude);
$latAr = DECtoDMS($my_latitude);

if (!file_exists($chartwheel_filename)) $__ini['wheel'] = true;
else $__ini['wheel'] = false;
if (!file_exists($grids_filename)) $__ini['grids'] = true;
else $__ini['grids'] = false;

$cData0 = "rx1=$rx1&p1=$ser_L1&hc1=$ser_hc1&hpos=$ser_hpos";
$cData1 = "rx1=$rx1&rx2=$rx2&p1=$ser_L1&p2=$ser_L2&hc1=$ser_hc1&ubt1=$ubt1&ubt2=$ubt2";

/*
if (!file_exists($chartwheel_filename)) include __ASTRO."/natal_wheel_1_pdf.php";
if (!file_exists($grids_filename)) include __ASTRO.'/natal_aspect_grid_pdf.php';
