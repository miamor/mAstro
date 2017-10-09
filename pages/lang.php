<? if ($do) {
	if (array_key_exists($do, $lgAr)) {
		$_SESSION['lang'] = $do;
//		$updateLang = changeValue('members', "`id` = '{$u}' ", "`lang` = '{$do}' ");
		$config->lang = $do;
		$updateLang = $config->updateLang();
		if ($updateLang) {
			if ($_SESSION['show'] = 'source') {
				$_SESSION['show'] = 'top';
				$_SESSION['source'] = '';
			}
			echo 0;
		} else echo 1;
	} else echo 'No language package found.';
}
