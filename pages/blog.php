<? 
// include object files
include_once 'objects/forum.php';
include_once 'objects/topic.php';

// prepare product object
$forum = new Forum();
$topic = new Topic();

// get ID of the product to be edited
//$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

//$f = ($config->get('f') !== null) ? $config->get('f') : null;
$mode = ($config->get('mode') !== null) ? $config->get('mode') : null;
$f = isset($n) ? $n : null;
$id = (isset($__pageAr[2])) ? $__pageAr[2] : null;
$pageTitle = 'Blog';
if ($f) {
	$forum->id = $f;

	$fInfo = $forum->readOne();
	$pageTitle = $fInfo['title'];
}
if ($id) {
	$topic->id = $id;
	$id = null;
	$topicView = $topic->readOne();
	extract($topicView);
	// Reset $id to ID property of product
	$topic->id = $id;
	$topic->link = $link;
	$pageTitle = $topicView['title'];
}
if ($f) {
	$topic->fid = $forum->id = $fInfo['id'];
	$topic->forumLink = $topic->f = $forum->link;
}
if (!$do && !$v && !$temp) include 'pages/views/_temp/header.php';

if ($do) include 'system/blog/'.$do.'.php';
else if (!$temp) {
	if ($id) {
		if ($mode == 'edit') include 'views/blog/'.$mode.'.php';
		else {
			$topic->updateView();
			include 'views/blog/view.php';
		}
	} else if ($mode == 'new') include 'views/blog/new.php';
	else include 'views/blog/topic.php';
//	else if ($f) include 'views/blog/topic.php';
//	else include 'views/blog/forum.php';
}
