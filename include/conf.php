<? define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "astro");
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}
$mysqli->set_charset("utf8");

/*
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die("Error " . mysqli_error($con)); 
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	die('Mysql connection error');
} else echo "Connection Established";

/*$dbName = DB_NAME;
//$con = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
$db_select = mysql_select_db(DB_NAME, $con);
mysql_set_charset("utf8", $con);
*/

define('MAIN_PATH', './');
define('HOST_URL', '//localhost/astro');
define('MAIN_URL', 'http:'.HOST_URL);
//define('SWEPH', '/opt/lampp/htdocs/astro/sweph/');
define('SWEPH', MAIN_PATH.'/sweph/');
define('SWETEST', 'swetest');

$page = str_replace('/astro/', '', $_SERVER['REQUEST_URI']);

$social_conf = array(
	'Facebook' => array(
		"id" => "1453024741651795",
		"secret" => "9b8f7c2b0d59a70c4e3d2bb161990624",
	),
); ?>
