<? header('Content-Type: application/json');

$topic->topicsList = '';
$topic->readAll(true, '', 0, 0, 10);
$lastTopic['all'] = $topic->topicsList;

$topic->topicsList = '';
$topic->readAll(array(4,5,6), '', 0, 0, 10);
$lastTopic['c'] = $topic->topicsList;

$topic->topicsList = '';
$topic->readAll(array(14,15,16), '', 0, 0, 10);
$lastTopic['php'] = $topic->topicsList;

$topic->topicsList = '';
$topic->readAll(array(4,5,6), '', 0, 0, 10);
$lastTopic['java'] = $topic->topicsList;

$topic->topicsList = '';
$topic->readAll(array(7,12,18,23,44,45,46), '', 0, 0, 10);
$lastTopic['ebook'] = $topic->topicsList;

$topic->topicsList = '';
$topic->readAll(array(36,37,38,39,40,41,42), '', 0, 0, 10);
$lastTopic['network'] = $topic->topicsList;

$topic->topicsList = '';
$topic->readAll(array(11,17,22,48,50), '', 0, 0, 10);
$lastTopic['source'] = $topic->topicsList;

echo json_encode($lastTopic);
