<?
header('Content-Type: text/plain; charset=utf-8');

$topic->replycontent = $content = isset($_POST['content']) ? $_POST['content'] : null;

if ($content) {
	$reply = $topic->reply();
	$pID = $topic->replies + 1;
	if ($reply) echo '[type]success[/type][dataID]'.$pID.'[/dataID][content]Comment submitted successfully.[/content]';
	else echo '[type]error[/type][content]Oops! Something went wrong with our system. Please contact the administrators for furthur help.[/content]';
} else echo '[type]error[/type][content]Missing parameters[/content]';
