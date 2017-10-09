<? if ($do == 'calculate') {
	include 'pages/ini/calculate.php';
	if ($ok == true) {
		$valAr = 
			array(
				'aid' => $aID,
				'auid' => $auid,
				'uname' => $uname,
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
				'start' => $startt,
			);
		$cIn = $chart->createChart($valAr);
		//print_r($cIn);
		if ($cIn) echo $cIn['link'];
	}
} ?>
