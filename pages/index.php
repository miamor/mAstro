<?php
// set page headers
$page_title = "mRoom";

include_once 'objects/index.php';

$index = new Index();

$stmt = $index->readProblems();
$problemsList = $index->problemsList;
$num = $stmt->rowCount();

if ($do) include 'system/index/'.$do.'.php';
else {
//	include_once "views/_temp/header.php";

	$config->addJS('plugins', 'DataTables/datatables.min.js');

	include 'views/_temp/index.php';
//	include_once "views/_temp/footer.php";
}
