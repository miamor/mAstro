<?
header('Content-Type: text/plain; charset=utf-8');

$topic->title = $title = isset($_POST['title']) ? $_POST['title'] : null;
$topic->content = $content = isset($_POST['content']) ? $_POST['content'] : null;
if ($title && $content) {
			$update = $topic->update();
			if ($update) {
				echo '[type]success[/type][dataID]'.$config->bLink.'/'.$topic->f.'/'.$topic->link.'[/dataID][content]Topic updated successfully. Redirecting to <a href="'.$config->bLink.'/'.$topic->fid.'/'.$topic->link.'</a>">'.$title.'</a>...[/content]';
			} else echo '[type]error[/type][content]Oops! Something went wrong with our system. Please contact the administrators for furthur help.[/content]';
} else echo '[type]error[/type][content]Missing parameters[/content]';
