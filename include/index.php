<?
header('Content-Type: text/html; charset=utf-8');

include_once 'include/config.php';
$config = new Config();

$accessToken = $config->accessToken;

?>

<script src="<? echo MAIN_URL ?>/jquery-2.1.1.min.js"></script>
<script>
$(function () {
	$.get('login.php', function (data) {
		console.log(data);
	})
})
</script>