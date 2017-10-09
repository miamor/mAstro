<? $config->addJS('plugins', 'bootstrapValidator/bootstrapValidator.min.js');
$config->addJS('plugins', 'sceditor/minified/jquery.sceditor.min.js');
$config->addJS('dist', 'main.js'); ?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="<? echo IMG ?>/favicon.ico" />

	<title>mAstro</title>

	<!-- Bootstrap -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<? echo MAIN_URL ?>/assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<? echo CSS ?>/font.min.css">
	<link rel="stylesheet" href="<? echo CSS ?>/plugins.css">
	<!-- Page style CSS -->
	<link rel="stylesheet" href="<? echo CSS ?>/minified.css">

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="<? echo MAIN_URL ?>/assets/jquery/jquery-2.2.3.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<!-- Latest compiled and minified JavaScript -->
	<script src="<? echo MAIN_URL ?>/assets/bootstrap/js/bootstrap.min.js"></script>
	<script>var MAIN_URL = '<? echo MAIN_URL ?>' </script>

</head>
<body>

	<div class="left-sidebar no-padding">
			<div class="left-top">
				<a class="logo" href="<? echo MAIN_URL ?>"><span class="fa fa-code"></span> mRoom</a>
				<div class="page-switch">
					<a href="#" id="home" title="Home" class="left-oneli"><span class="fa fa-home"></span></a>
					<a href="#" id="blog" title="Blog" class="left-oneli"><span class="fa fa-comments"></span></a>
					<a href="#" id="code" title="Chart" class="left-oneli"><span class="fa fa-code"></span></a>
				</div>
				<div class="lang">
					<a <? if ($config->lang == 'us') echo 'class="active"' ?> title="English (US)" lang="us"><img src="<? echo IMG ?>/flags/us.png"></a>
					<a <? if ($config->lang == 'vn') echo 'class="active"' ?> title="Tiếng Việt" lang="vn"><img src="<? echo IMG ?>/flags/vn.png"></a>
				</div>
			</div> <!-- .left-top -->
			<div id="left-menu" class="navbar">
				<ul class="home">
					<li class="left-menu-one <? if ($page == 'about') echo 'active' ?>"><a href="<? echo MAIN_URL ?>/about">About</a></li>
				<? if (!$config->u) { ?>
					<li class="left-menu-one <? if ($page == 'login') echo 'active' ?>"><a href="<? echo MAIN_URL ?>/login">Login</a></li>
				<? } ?>
				</ul>

				<ul class="code hide">
				<? if ($config->u) { ?>
					<label>Chart</label>
					<li class="left-menu-one <? if ($page == 'chart') echo 'active' ?>"><a href="<? echo MAIN_URL ?>/chart">Natal chart</a></li>
					<li class="left-menu-one <? if ($page == 'transit') echo 'active' ?>"><a href="<? echo MAIN_URL ?>/transit">Transit</a></li>
					<li class="left-menu-one <? if ($page == 'relationship') echo 'active' ?>"><a href="<? echo MAIN_URL ?>/relationship">Relationship</a></li>
				<? } else echo '<div class="need-login">You need to <a href="'.MAIN_URL.'/login">log in</a> to use this feature.</div>' ?>
				</ul>
				<ul class="blog hide"></ul>
			</div>
		
			<div class="left-bottom">
			<form class="search-form">
				<input name="keywords" class="search-input" placeholder="Input something..." type="text">
			</form>

			<div class="user-right-bar left">
				<ul class="nav-users">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<img src="<? echo ($config->u) ? $config->me['avatar'] : MAIN_URL.'/data/img/anonymous.jpeg' ?>" class="avatar img-circle">
							<strong class="s-title"><? echo ($config->u) ? $config->me['name'] : '[Guests]' ?></strong>
						</a>
						<ul class="dropdown-menu with-triangle primary pull-left">
							<li><a href="<? echo $config->me['link'] ?>">Me</a></li>
							<li><a href="<? echo $config->me['link'] ?>/submissions">My submissions</a></li>
							<li><a href="<? echo $config->me['link'] ?>/profile">Profile</a></li>
							<li class="divider"></li>
							<li><a href="<? echo MAIN_PATH ?>/logout">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>


			<? if ($config->u) { ?>
			<div class="noti-right-bar right">
				<ul class="nav-users">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<span class="badge badge-primary icon-count">1</span>
							<i class="fa fa-globe" style="font-size:17px"></i>
						</a>
						<ul class="dropdown-menu with-triangle pull-left">
							<li>
								<div class="nav-dropdown-heading">Notifications</div>
								<div class="nav-dropdown-content scroll-nav-dropdown">
									<ul class="notification-load">
										
									</ul>
								</div>
								<div class="btn btn-primary btn-block">See all notifications</div>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-inbox" style="font-size:17px"></i>
						</a>
						<ul class="dropdown-menu with-triangle pull-left">
							<li>
								<div class="nav-dropdown-heading">
									Messages
								</div>
								<div class="nav-dropdown-content scroll-nav-dropdown">
									<ul class="notification-load">
									</ul>
								</div>
								<div class="btn btn-primary btn-block" href="http://localhost/astro/inbox">See all messages</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<? } ?>

			<div class="copyright">
				<span>©</span>
				<span class="hide">2016 Miamor West</span>
			</div>
			</div> <!-- .left-bottom -->

		</div>


	<div id="main-content" class="page-<? echo $page ?> col-lg-10">
