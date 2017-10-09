<?

$PASSWORD_SHA256 = hash('sha256', 'mypass');
$passInput = $_GET['password'];
$USER = 'admin';
$userInput = $_GET['user'];
if ($userInput == $USER) echo 'logged in username';
echo '<hr/>';
//$passInput = hash('sha256', $passInput);
$strcmp = strcmp($passInput, $PASSWORD_SHA256);
var_dump($strcmp);
if (!$strcmp) echo 'logged in password';

/*
header('Content-type: application/json; charset=utf-8');

$ar = '{
    "c2array": true,
    "size": [5, 1, 1],
    "data": [
		["344838695697313"],
		["EAAXXrIOZAgFgBAEbq0EI0a2oJnUSaP3CJMVrwUgTuKZC7ONspvPKRkAfO7W39VziS8071LETTHZAJsh3nDgc6WISvap3j4doBFjTYRcRdOCLfEverpVTzFgfNOX1aPGtL2ZBEcoUMc5ESUZAAZCif4bO1ZBLg6SDjEZD"],
		["Nguyễn Tú"],
		["nguyen.tu"],
		["https://scontent.xx.fbcdn.net/v/t1.0-1/p74x74/11866474_481874321993749_396300518817508076_n.jpg?oh=d6832bdfe004df57b4972b54bf69387d&oe=588A05F6"]
	]
}';

echo $ar;