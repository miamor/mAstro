<?
	$id = $config->get('id');
	$rid = _content($_POST['rid-'.$id]);
	$content = _content($_POST['content-'.$id]);
	if (!$rid || $rid == 0) echo 'No data found.';
	else if ($content) {
//		if (countRecord('data', "`id` = '{$rid}' ") > 0) {
//			$change = changeValue('data', "`id` = '{$rid}' ", "`content` = '{$content}' ");
			$report->id = $rid;
			$report->content = $content;
			$change = $report->update();
			if ($change) echo 0;
			else echo 1;
//		} else echo $er[002];
	} else echo $er[001];
