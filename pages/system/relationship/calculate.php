<? 
function safeEscapeString ($string) {
	// replace HTML tags '<>' with '[]'
	$temp1 = str_replace("<", "[", $string);
	$temp2 = str_replace(">", "]", $temp1);

	// but keep <br> or <br />
	// turn <br> into <br /> so later it will be turned into ""
	// using just <br> will add extra blank lines
	$temp1 = str_replace("[br]", "<br />", $temp2);
	$temp2 = str_replace("[br /]", "<br />", $temp1);

//	if (get_magic_quotes_gpc()) 
		return $temp2;
//	else
//		return mysqli_escape_string($temp2);
}

$months = array (0 => 'Choose month', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$my_error = "";

if ($do == 'calculate') {
	$ok = false;
	$aID1 = $_POST['aid1'];
	$aID2 = $_POST['aid2'];
	if ($aID1) {
		$_DATA = $config->readAstroData($aID1);
		$name1 = $_DATA['name'];
		$gender1 = $_DATA['gender'];
		$bday1 = $_DATA['birthday'];
		$day1 = date('d', $bday1);
		$month1 = (int)date('m', $bday1);
		$year1 = date('Y', $bday1);
		$hour1 = explode(':', $_DATA['birthhour'])[0];
		$minute1 = explode(':', $_DATA['birthhour'])[1];
/*		$long_deg1 = DECtoDMS(explode('|', $_DATA['long'])[1])['deg'];
		$long_min1 = DECtoDMS(explode('|', $_DATA['long'])[1])['min'];
		$lat_deg1 = DECtoDMS(explode('|', $_DATA['lat'])[1])['deg'];
		$lat_min1 = DECtoDMS(explode('|', $_DATA['lat'])[1])['min'];
		$ns_txt1 = explode('|', $_DATA['lat'])[0];
		$ew_txt1 = explode('|', $_DATA['long'])[0];
*/		$long_deg1 = $_DATA['long_deg'];
		$long_min1 = $_DATA['long_min'];
		$lat_deg1 = $_DATA['lat_deg'];
		$lat_min1 = $_DATA['lat_min'];
		$ns_txt1 = $_DATA['ns'];
		$ew_txt1 = $_DATA['ew'];
		if ($ew_txt1 == 'e') $ew1 = 1;
		else $ew1 = -1;
		if ($ns_txt1 == 'n') $ns1 = 1;
		else $ns1 = -1;
		$country1 = $_DATA['country'];
		$town1 = $_DATA['town'];
		$timezone1 = $_DATA['timezone'];

		$uname1 = $_DATA['uname'];
		$auid1 = $_DATA['uid'];
	}
	if ($aID2) {
		$_DATA2 = $config->readAstroData($aID2);
		$name2 = $_DATA2['name'];
		$gender2 = $_DATA2['gender'];
		$bday2 = $_DATA2['birthday'];
		$day2 = date('d', $bday2);
		$month2 = (int)date('m', $bday2);
		$year2 = date('Y', $bday2);
		$hour2 = explode(':', $_DATA2['birthhour'])[0];
		$minute2 = explode(':', $_DATA2['birthhour'])[1];
/*		$long_deg2 = DECtoDMS(explode('|', $_DATA2['long'])[1])['deg'];
		$long_min2 = DECtoDMS(explode('|', $_DATA2['long'])[1])['min'];
		$lat_deg2 = DECtoDMS(explode('|', $_DATA2['lat'])[1])['deg'];
		$lat_min2 = DECtoDMS(explode('|', $_DATA2['lat'])[1])['min'];
		$ns_txt2 = explode('|', $_DATA2['lat'])[0];
		$ew_txt2 = explode('|', $_DATA2['long'])[0];
*/		$long_deg2 = $_DATA2['long_deg'];
		$long_min2 = $_DATA2['long_min'];
		$lat_deg2 = $_DATA2['lat_deg'];
		$lat_min2 = $_DATA2['lat_min'];
		$ns_txt2 = $_DATA2['ns'];
		$ew_txt2 = $_DATA2['ew'];
		if ($ew_txt2 == 'e') $ew2 = 1;
		else $ew2 = -1;
		if ($ns_txt2 == 'n') $ns2 = 1;
		else $ns2 = -1;
		$country2 = $_DATA2['country'];
		$town2 = $_DATA2['town'];
		$timezone2 = $_DATA2['timezone'];

		$uname2 = $_DATA2['uname'];
		$auid2 = $_DATA2['uid'];
	}

//	$bday1 = strtotime("$day1 ".date('F', mktime(0, 0, 0, $month1, 10))." $year1");
	$bhour1 = $hour1.':'.$minute1;

//	$bday2 = strtotime("$day2 ".date('F', mktime(0, 0, 0, $month2, 10))." $year2");
	$bhour2 = $hour2.':'.$minute2;

//	echo $bday1.'::'.$bday2.'<br/>';


if ($aID1 && $aID2) {
	$my_longitude1 = $ew1 * ($long_deg1 + ($long_min1 / 60));
	$my_latitude1 = $ns1 * ($lat_deg1 + ($lat_min1 / 60));

	$my_longitude2 = $ew2 * ($long_deg2 + ($long_min2 / 60));
	$my_latitude2 = $ns2 * ($lat_deg2 + ($lat_min2 / 60));

	$name = $name1.'::'.$name2;
	$gender = $gender1.'::'.$gender2;
	$bday = $bday1.'::'.$bday2;
	$bhour = $bhour1.'::'.$bhour2;
	$timezone = $timezone1.'::'.$timezone2;
	$country = $country1.'::'.$country2;
	$town = $town1.'::'.$town2;
	$ew_txt = $ew_txt1.'::'.$ew_txt2;
	$long_deg = $long_deg1.'::'.$long_deg2;
	$long_min = $long_min1.'::'.$long_min2;
//	$my_longitude = $my_longitude1.'::'.$my_longitude2;
	$ns_txt = $ns_txt1.'::'.$ns_txt2;
//	$my_latitude = $my_latitude1.'::'.$my_latitude2;
	$lat_deg = $lat_deg1.'::'.$lat_deg2;
	$lat_min = $lat_min1.'::'.$lat_min2;

	$name_ = $name2.'::'.$name1;
	$gender_ = $gender2.'::'.$gender1;
	$bday_ = $bday2.'::'.$bday1;
	$bhour_ = $bhour2.'::'.$bhour1;
	$timezone_ = $timezone2.'::'.$timezone1;
	$country_ = $country2.'::'.$country1;
	$town_ = $town2.'::'.$town1;
	$ew_txt_ = $ew_txt2.'::'.$ew_txt1;
	$long_deg_ = $long_deg2.'::'.$long_deg1;
	$long_min_ = $long_min2.'::'.$long_min1;
	$ns_txt_ = $ns_txt2.'::'.$ns_txt1;
	$lat_deg_ = $lat_deg2.'::'.$lat_deg1;
	$lat_min_ = $lat_min2.'::'.$lat_min1;


	$uname = $uname1.'::'.$uname2;
	$auid = $auid1.'::'.$auid2;
	$aID = $aID1.'::'.$aID2;
	$aID_ = $aID2.'::'.$aID1;
} else echo 'Error';

if (($bday1 != $bday2) || ($bhour1 != $bhour2) || ($timezone1 != $timezone2) || ($ns_txt1 != $ns_txt2) || ($ew_txt1 != $ew_txt2) || ($my_longitude1 != $my_longitude2) || ($my_latitude1 != $my_latitude2) ) $ok = true;
else echo 'Two people must be different.';

	if ($ok == true) {
		$valAr = 
			array(
				'aid' => $aID,
				'auid' => $auid,
				'uname' => $config->me['username'],
				'uid' => $config->u,
				'name' => $name,
				'gender' => $gender,
				'birthday' => $bday,
				'birthhour' => $bhour,
				'timezone' => $timezone,
				'country' => $country,
				'town' => $town,
				'long_deg' => $long_deg,
				'lat_deg' => $lat_deg,
				'long_min' => $long_min,
				'lat_min' => $lat_min,
				'ew' => $ew_txt,
				'ns' => $ns_txt,
			);
		$valAr_ = 
			array(
				'aid' => $aID_,
				'auid' => $auid,
				'uname' => $uname,
				'uid' => $config->u,
				'name' => $name_,
				'gender' => $gender_,
				'birthday' => $bday_,
				'birthhour' => $bhour_,
				'timezone' => $timezone_,
				'country' => $country_,
				'town' => $town_,
				'long_deg' => $long_deg_,
				'lat_deg' => $lat_deg_,
				'long_min' => $long_min_,
				'lat_min' => $lat_min_,
				'ew' => $ew_txt_,
				'ns' => $ns_txt_
			);
		$cIn = $chart->createChart($valAr, $aID_);
		//print_r($cIn);
		if ($cIn) echo $cIn['link'];
	}
} ?>
