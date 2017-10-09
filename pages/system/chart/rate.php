<?
	$star = $_POST['star'];
	$star = $config->get('rate');
	$chart->star = $star;
	$chart->title = $title = $_POST['title'];
	$chart->content = $content = _content($_POST['content']);
	if ($star && $title && $content) {
//		$rated = rate($tb, $iid, $star, $title, $content);
		$rated = $chart->rate();
		if ($rated == 1) echo '[type]success[/type][content]Rated successfully![/content]';
		else echo '[type]warning[/type][content]'.$content.'[/content]';
	} else echo $Er[001];
