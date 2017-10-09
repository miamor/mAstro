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
$ok = false;
	$aID = isset($_POST['aid']) ? $_POST['aid'] : null;
	if (!$aID) $aID = ($config->get('aid') != null) ? $config->get('aid') : null;

	if ($aID) {
		$ok = true;
//		$_DATA = getRecord('astro_data', "`id` = '{$aID}' ");
		$_DATA = $config->readAstroData($aID);
		$name = $_DATA['name'];
		$gender = $_DATA['gender'];
		$bday = $_DATA['birthday'];
		$day = date('d', $bday);
		$month = (int)date('m', $bday);
		$year = date('Y', $bday);
		$hour = explode(':', $_DATA['birthhour'])[0];
		$minute = explode(':', $_DATA['birthhour'])[1];
/*		$long_deg = DECtoDMS(explode('|', $_DATA['long'])[1])['deg'];
		$long_min = DECtoDMS(explode('|', $_DATA['long'])[1])['min'];
		$lat_deg = DECtoDMS(explode('|', $_DATA['lat'])[1])['deg'];
		$lat_min = DECtoDMS(explode('|', $_DATA['lat'])[1])['min'];
		$ns_txt = explode('|', $_DATA['lat'])[0];
		$ew_txt = explode('|', $_DATA['long'])[0];
*/		$long_deg = $_DATA['long_deg'];
		$long_min = $_DATA['long_min'];
		$lat_deg = $_DATA['lat_deg'];
		$lat_min = $_DATA['lat_min'];
		$ns_txt = $_DATA['ns'];
		$ew_txt = $_DATA['ew'];
		if ($ew_txt == 'e') $ew = 1;
		else $ew = -1;
		if ($ns_txt == 'n') $ns = 1;
		else $ns = -1;
		$country = $_DATA['country'];
		$town = $_DATA['town'];
		$timezone = $_DATA['timezone'];
		
		$uname = $_DATA['uname'];
		$auid = $_DATA['uid'];
	} else {
		$uname = $config->me['username'];
		$auid = $config->u;
		$p = (isset($p)) ? $p : 1;

//		$h_sys = safeEscapeString($_POST["h_sys"]);

		$name = safeEscapeString($_POST["name".$p]);
		$gender = safeEscapeString($_POST["gender".$p]);

		$month = safeEscapeString($_POST["month".$p]);
		$day = safeEscapeString($_POST["day".$p]);
		$year = safeEscapeString($_POST["year".$p]);

		$hour = safeEscapeString($_POST["hour".$p]);
		$minute = safeEscapeString($_POST["min".$p]);

		$timezone = safeEscapeString($_POST["timezone".$p]);
		$country = safeEscapeString($_POST["country".$p]);
		$town = safeEscapeString($_POST["town".$p]);

		$long_deg = safeEscapeString($_POST["long_deg".$p]);
		$long_min = safeEscapeString($_POST["long_min".$p]);
		$ew = safeEscapeString($_POST["ew".$p]);

		$lat_deg = safeEscapeString($_POST["lat_deg".$p]);
		$lat_min = safeEscapeString($_POST["lat_min".$p]);
		$ns = safeEscapeString($_POST["ns".$p]);
/*include MAIN_PATH.'/lib/html_dom.php';
$url = 'http://www.astro.com/cgi/aq.cgi?country_list=&expr='.urlencode($town).'&submit=Search&lang=e';
$html = new simple_html_dom();
$html->load_file($url);
$content = '';
$strongAr = array();
$lnglat = $llA = array();
foreach ($html->find('ol') as $ol) {
	foreach ($ol->find('b') as $b) {
		$txt = $b->plaintext;
		$llA[] = $txt;
	}
}
foreach ($llA as $i => $ll) {
	$lAr = preg_split('/(n|s|e|w)/', $ll);
	$deg = $lAr[0];
	$min = $lAr[1];
	preg_match('/(n|s|e|w)/', $ll, $m);
	$txt = $m[0];
	if ($i == 0) $k = 'lat';
	else $k = 'long';
	$lnglat[$k] = array('deg' => $deg, 'min' => $min, 'txt' => $txt);
}
		$long_deg = safeEscapeString($lnglat['long']['deg']);
		$long_min = safeEscapeString($lnglat['long']['min']);
		$ew = safeEscapeString($lnglat['long']['txt']);

		$lat_deg = safeEscapeString($lnglat['lat']['deg']);
		$lat_min = safeEscapeString($lnglat['lat']['min']);
		$ns = safeEscapeString($lnglat['lat']['txt']);
*/
	}
	if ($page == 'transit') {
		$start_month = safeEscapeString($_POST["start_month"]);
		$start_day = safeEscapeString($_POST["start_day"]);
		$start_year = safeEscapeString($_POST["start_year"]);
		$startt = $start_day.'|'.$start_month.'|'.$start_year;
	}
	$bday = strtotime("$day ".date('F', mktime(0, 0, 0, $month, 10))." $year");
	$bhour = $hour.':'.$minute;

if (!$aID) {
	//error check
	$my_form = new Validate_fields;

	$my_form->check_4html = true;

	$my_form->add_text_field("Name", $name, "text", "y", 40);

	$my_form->add_text_field("Month", $month, "text", "y", 2);
	$my_form->add_text_field("Day", $day, "text", "y", 2);
	$my_form->add_text_field("Year", $year, "text", "y", 4);

	$my_form->add_text_field("Hour", $hour, "text", "y", 2);
	$my_form->add_text_field("Minute", $minute, "text", "y", 2);

	$my_form->add_text_field("Time zone", $timezone, "text", "y", 4);

	$my_form->add_text_field("Longitude degree", $long_deg, "text", "y", 3);
	$my_form->add_text_field("Longitude minute", $long_min, "text", "y", 2);
	$my_form->add_text_field("Longitude E/W", $ew, "text", "y", 2);

	$my_form->add_text_field("Latitude degree", $lat_deg, "text", "y", 2);
	$my_form->add_text_field("Latitude minute", $lat_min, "text", "y", 2);
	$my_form->add_text_field("Latitude N/S", $ns, "text", "y", 2);

	// additional error checks on user-entered data
	if ($month == 0) $my_error .= "Please enter a month.<br>";

	if ($month != "" And $day != "" And $year != "") {
		if (!$date = checkdate(settype ($month, "integer"), settype ($day, "integer"), settype ($year, "integer")))
			$my_error .= "The date of birth you entered is not valid.<br>";
	}

	if (($year < 1900) Or ($year >= 2100))
		$my_error .= "Please enter a year between 1900 and 2099.<br>";

	if (($hour < 0) Or ($hour > 23))
		$my_error .= "Birth hour must be between 0 and 23.<br>";

	if (($minute < 0) Or ($minute > 59))
		$my_error .= "Birth minute must be between 0 and 59.<br>";

	if (($long_deg < 0) Or ($long_deg > 179))
		$my_error .= "Longitude degrees must be between 0 and 179.<br>";

	if (($long_min < 0) Or ($long_min > 59))
		$my_error .= "Longitude minutes must be between 0 and 59.<br>";

	if (($lat_deg < 0) Or ($lat_deg > 65))
		$my_error .= "Latitude degrees must be between 0 and 65.<br>";

	if (($lat_min < 0) Or ($lat_min > 59))
		$my_error .= "Latitude minutes must be between 0 and 59.<br>";

	if (($ew == '-1') And ($timezone > 2))
		$my_error .= "You have marked West longitude but set an east time zone.<br>";

	if (($ew == '1') And ($timezone < 0))
		$my_error .= "You have marked East longitude but set a west time zone.<br>";

	if ($ew < 0) $ew_txt = "w";
	else $ew_txt = "e";

	if ($ns > 0) $ns_txt = "n";
	else $ns_txt = "s";

	$validation_error = $my_form->validation();
}

if (!$aID && ((!$validation_error) || ($my_error != ""))) {
	$error = $my_form->create_msg();
//	echo '<div class="alerts alert-error"><b>Error! - The following error(s) occurred</b><br/>';

	if ($error) echo $error . $my_error;
	else echo $error . "<br>" . $my_error;

//	echo "<br>Please re-enter your timezone data.<br><br>";
//	echo '</div>';
} else {
	$ok = true;
	$my_longitude = $ew * ($long_deg + ($long_min / 60));
	$my_latitude = $ns * ($lat_deg + ($lat_min / 60));

	if (!$aID) {
		// set cookie containing natal data here
		setcookie ('name'.$p, stripslashes($name), time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('gender'.$p, $gender, time() + 60 * 60 * 24 * 30, '/', '', 0);

		setcookie ('month'.$p, $month, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('day'.$p, $day, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('year'.$p, $year, time() + 60 * 60 * 24 * 30, '/', '', 0);

		setcookie ('hour'.$p, $hour, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('minute'.$p, $minute, time() + 60 * 60 * 24 * 30, '/', '', 0);

		setcookie ('timezone'.$p, $timezone, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('country'.$p, $country, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('town'.$p, $town, time() + 60 * 60 * 24 * 30, '/', '', 0);

		setcookie ('long_deg'.$p, $long_deg, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('long_min'.$p, $long_min, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('ew'.$p, $ew, time() + 60 * 60 * 24 * 30, '/', '', 0);

		setcookie ('lat_deg'.$p, $lat_deg, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('lat_min'.$p, $lat_min, time() + 60 * 60 * 24 * 30, '/', '', 0);
		setcookie ('ns'.$p, $ns, time() + 60 * 60 * 24 * 30, '/', '', 0);
	}

}?>
