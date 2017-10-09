<?php
// set page headers
$page_title = "Forum";

// query products
$stmt = $forum->readAll();
$forumsList = $forum->forumsList;
$num = $stmt->rowCount();

include_once 'pages/views/_temp/blog/forum.php';
