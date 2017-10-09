<? $pTitle = 'Login/Sign up';

// include object files
include_once 'objects/login.php';

$login = new Login();

$pageTitle = 'Login';
if (!$do && !$v && !$temp) include 'pages/views/_temp/header.php';
//include '../lib/config.php';
//$do = $_GET['do'];
//if (!$do) include 'header.php';

$p = $config->get('p');
if (!$p) $p = 'login';

if ($config->u) echo '<div class="alerts alert-info">You\'ve already been logged in.</div>';
else if (!$do) include 'pages/views/'.$page.'/'.$p.'.php';
else include 'pages/system/'.$page.'/'.$do.'.php';
