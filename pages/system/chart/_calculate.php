<? if ($do == 'caculate') {
	include 'pages/system/caculate.php';
	if ($ok == true) {
		$valAr = array(
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
		createChart($tb, $valAr);
		$cIn = getRecord('chart', "`name` = '{$name}' AND `gender` = '{$gender}' AND `birthday` = '{$bday}' AND `birthhour` = '{$bhour}' AND `timezone` = '{$timezone}' AND `country` = '{$country}' AND `town` = '{$town}' AND `long_deg` = '{$long_deg}' AND `lat_deg` = '{$lat_deg}' AND `long_min` = '{$long_min}' AND `lat_min` = '{$lat_min}' AND `ew` = '{$ew_txt}' AND `ns` = '{$ns_txt}' ");
/*		$cIn = getRecord('chart', 
				"`aid` = '{$aID}' 
					OR
				`name` = '{$name}' AND `gender` = '{$gender}' AND `birthday` = '{$bday}' AND `birthhour` = '{$bhour}' AND `timezone` = '{$timezone}' AND `country` = '{$country}' AND `town` = '{$town}' AND `long_deg` = '{$long_deg}' AND `lat_deg` = '{$lat_deg}' AND `long_min` = '{$long_min}' AND `lat_min` = '{$lat_min}' AND `ew` = '{$ew_txt}' AND `ns` = '{$ns_txt}' 
			");

/*		$stt = $cIn['stt'];
		$display = false;
		if ($stt == -1) $display = true;
		if ($stt == 0 && $cIn['uid'] == $u) $display = true;
		if ($stt == 1 && in_array($u, $auFriendsAr)) $display = true;
		if ($stt == 2) {
			$cAu = getUserInfo($cIn['uid'], 'friends');
			$auFriendsAr = explode(',', $cAu['friends']);
			$frF = array();
			foreach ($auFriendsAr as $aFo) {
				$aFi = getRecord('members^friends', "`id` = '{$cIn['uid']}' ");
				$aFf = explode(',', $aFi['friends']);
				foreach ($aFf as $aFfo) $frF[] = $aFfo;
			}
			if (in_array($u, $frF)) $display = true;
		}
*/
		if ($cIn['id']) {
//			$change = changeValue('chart', "`id` = '{$cIn['id']}' ", " `name` = '{$name}' AND `gender` = '{$gender}' AND `birthday` = '{$bday}' AND `birthhour` = '{$bhour}' AND `timezone` = '{$timezone}' AND `country` = '{$country}' AND `town` = '{$town}' AND `long_deg` = '{$long_deg}' AND `lat_deg` = '{$lat_deg}' AND `long_min` = '{$long_min}' AND `lat_min` = '{$lat_min}' AND `ew` = '{$ew_txt}' AND `ns` = '{$ns_txt}' ");
			echo $cLink.'/'.$cIn['uname'].'/'.$cIn['n'];
		} else {
			$nn = countRecord($tb, "`uid` = '{$_DATA['uid']}' ") + 1;
			$ins = insert($tb, "`name`, `aid`, `uid`, `ucreate`, `uname`, `n`, `gender`, `birthday`, `birthhour`, `timezone`, `long_deg`, `long_min`, `lat_deg`, `lat_min`, `ew`, `ns`, `country`, `town`, `time`, `last_updated`", " '{$name}', '{$aID}', '{$_DATA['uid']}', '{$_DATA['uid']}', '{$_DATA['uname']}', '{$nn}', '{$gender}', '{$bday}', '{$bhour}', '{$timezone}', '{$long_deg}', '{$long_min}', '{$lat_deg}', '{$lat_min}', '{$ew_txt}', '{$ns_txt}', '{$country}', '{$town}', '{$current}', '{$current}' ");
			$cIn = getRecord($tb, "`uid` = '{$_DATA['uid']}' AND `n` = '{$nn}' ");
			activityAdd($tb, $cIn['id'], 0);
			if ($ins) echo $cLink.'/'.$_DATA['uname'].'/'.$nn;
		}
	}
} ?>
