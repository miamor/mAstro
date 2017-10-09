<? $uname = $_POST['username'];
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$pass = $_POST['password'];
$repass = $_POST['confirm_password'];
$email = $_POST['email'];

if ($uname && $pass && $email) {
	$member = getRecord('members', "`username` = '{$uname}' ");
	if (!$member['id']) {
		if ($pass == $repass) {
			$ins = insert('members', "`username`, `password`, `email`, `first_name`, `last_name`, `time`, `last_activity`, `lastlog_time`", " '{$uname}', '{$pass}', '{$email}', '{$fname}', '{$lname}', '{$current}', '{$current}', '{$current}' ");
			if ($ins) {
				$member = getRecord('members', "`username` = '{$uname}' ");
				$u = $_SESSION['user_id'] = $member['id'];
				changeValue('members', "`id` = '{$u}' ", "`online` = '1' ");
				echo '[type]success[/type][content]Signed up and logged in successfully. Redirecting...[/content]';
			} else echo $Er[000];
		} else echo '[type]error[/type][content]Password mismatched. Please try again.[/content][dataID]password[/dataID]';
	} else echo '[type]error[/type][content]This username has been taken. Please choose another.[/content][dataID]username[/dataID]';
} else echo $Er[001];
