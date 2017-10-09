<?
	$report->sid = $sid = explode('s', $_POST['source-'.$id]);
	$report->code = $id = $config->get('id');
	$report->content = $content = _content($_POST['content-'.$id]);
	$report->lang = $lg;
	if ($content) {
		if ($report->check() > 0) echo $er[002];
		else {
			$report->add();
			if ($ins) echo 0;
			else echo 1;
		}
	} else echo $er[001];
