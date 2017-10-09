<?
header('Content-Type: text/plain; charset=utf-8');

$topic->title = $title = isset($_POST['title']) ? $_POST['title'] : null;
if ($title && $config->me['is_mod'] == 1) {
	$tp = $topic->readOne();
	if ($tp['id']) echo '[type]error[/type][content]One topic with this title has already existed. Please choose another title if this is different from <a href="'.$tp->link.'">this</a>[/content]';
	else {
		$topic->title = $title = isset($_POST['title']) ? $_POST['title'] : null;
		$topic->link = encodeURL($topic->title);
		$topic->content = $content = isset($_POST['content']) ? $_POST['content'] : null;
		if ($title && $content) {
			$create = $topic->create();
			if ($create) {
//				$tpn = $topic->readOne();
				echo '[type]success[/type][dataID]'.$config->bLink.'/'.$topic->f.'/'.$topic->link.'[/dataID][content]Topic created successfully. Redirecting to <a href="'.$config->bLink.'/'.$topic->fid.'/'.$topic->link.'</a>">'.$title.'</a>...[/content]';
			} else echo '[type]error[/type][content]Oops! Something went wrong with our system. Please contact the administrators for furthur help.[/content]';
		} else echo '[type]error[/type][content]Missing parameters[/content]';
	}
} else echo '[type]error[/type][content]Missing parameters[/content]';
