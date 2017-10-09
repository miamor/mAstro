<?
	$chart->stt = $stt = $config->get('stt');
	if ($stt) {
		$chart->changeStt();
		if ($change) echo 0;
		else echo 1;
	} else echo $er[001];
