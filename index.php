<?
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); 
else ob_start();

// config file
include_once 'include/config.php';
$config = new Config();

if ($config->u) $config->me = $config->getUserInfo(); // setup $config->me
else $config->me = array('id' => '', 'avatar' => '', 'link' => '', ',name' => '', 'username' => '', 'first_name' => '', 'last_name' => '', 'online' => '', 'is_mod' => '', 'is_admin');

// include object files
//include_once 'objects/page.php';

if (check($__page, '?') > 0) $__page = $__page.'&';
else $__page = $__page;

$__pageAr = array_filter(explode('/', explode('?', rtrim($__page))[0]));
if ($__pageAr) {
	$page = $__pageAr[0];
	$n = (array_key_exists(1, $__pageAr) && $__pageAr[1]) ? $__pageAr[1] : null;
	$requestAr = explode('?', $__page);
	$config->request = isset($requestAr[1]) ? $requestAr[1] : null;
} else {
	$requestArr = explode('?', $__page);
	$config->request = (isset($requestArr[1])) ? $requestArr[1] : null;
}

$v = $config->get('v');
$temp = $config->get('temp');
$type = $config->get('type');
$do = $config->get('do');

//if ($do) header('Content-Type: text/plain; charset=utf-8');
header('Content-Type: text/html; charset=utf-8');

if (!isset($page) || !$page) $page = 'about';

if ($page == 'b') $page = 'blog';
if ($page == 'u') $page = 'user';
if ($page == 'c') $page = 'chart';
if ($page == 't') $page = 'transit';
if ($page == 'r') $page = 'relationship';

$allowAr = array('lang', 'about', 'source', 'error', 'logout', 'chart', 'relationship', 'transit', 'source', 'report');

if (!$config->u && !in_array($page, $allowAr)) $page = 'login';
if (!file_exists('pages/'.$page.'.php')) $page = 'error';

$config->page = $page;

if ($page) {
//	if (!$do && !$v && !$temp) include 'pages/views/_temp/header.php';
	include 'pages/'.$page.'.php';
	if ($temp) include 'pages/views/_temp/'.$page.'/'.$temp.'.php';
	if (!$do && !$v && !$temp) include 'pages/views/_temp/footer.php';
}
