<?php
// set page headers
$page_title = $fInfo['title'];

$config->addJS('plugins', 'DataTables/datatables.min.js');
$config->addJS('dist', 'blog/topic.js');

$stmt = $topic->readAll(true);
$topicsList = $topic->topicsList;
$topicsListTop = $topic->topicsListTop;
$topicTop = $topic->topicTop;
$num = $stmt->rowCount();

// display the products if there are any
include_once 'pages/views/_temp/blog/topic.php';

