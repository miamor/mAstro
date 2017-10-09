<?php
// set page headers
$page_title = "Forum";

// query products
$stmt = $forum->readAll();
$forumsList = $forum->forumsList;
$num = $stmt->rowCount();

$topic->topicsList = '';
$topic->readAll(true, 'replies DESC', 0, 0, 10);
$activeTopic = $topic->topicsList;

$topic->topicsList = '';
$topic->readAll(true, 'views DESC', 0, 0, 10);
$viewsTopic = $topic->topicsList;

// display the products if there are any
if ($num>0) 
	include_once 'pages/views/_temp/blog/forum.php';
 else 
	echo '<div class="alert alert-info">Nothing\'s found.</div>';

