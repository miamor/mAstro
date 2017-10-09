<? $uname = $login->username = $login->uname = htmlentities($_POST['username'], ENT_QUOTES);
$pass = $login->password = $_POST['password'];
$token = $_POST['token'];
$id = $_POST['id'];
$type = $_POST['type'];
$name = $_POST['name'];
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$avatar = urldecode($_POST['avatar']);
$friends = json_decode($_POST['friends'], true);

$ok = false;

if ($uname && $pass) $member = $login->login();
else echo '[type]error[/type][content]Missing paramemters![/content]';

if ($login->uid) $ok = true;
else echo '[type]error[/type][content]Username or password mismatched![/content]';

if ($ok == true) {
	$config->u = $_SESSION['user_id'] = $login->uid;
	echo '[type]success[/type][content]Logged in successfully. Redirecting...[/content]';
}
