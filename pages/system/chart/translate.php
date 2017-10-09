<?
	$report->translate = $translator = $_POST['translator-'.$id];
	$report->code = $id = $config->get('id');
	$report->content = $content = _content($_POST['content-'.$id]);
	$report->lang = $lng = $_POST['lang-'.$id];
	if ($content && $lng) {
		if ($report->check > 0) echo $er[002];
		else {
			$ins = insert('data', "`translate`, `untrans`, `uid`, `code`, `content`, `lang`, `time` ", " '1', '{$translator}', '{$u}', '{$id}', '{$content}', '{$lng}', '{$current}' ");
			if ($ins) echo 0;
			else echo 1;
		}
	} else echo $er[001];
