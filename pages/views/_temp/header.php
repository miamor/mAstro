<? $config->addJS('plugins', 'bootstrapValidator/bootstrapValidator.min.js');
$config->addJS('plugins', 'sceditor/minified/jquery.sceditor.min.js');
$config->addJS('dist', 'main.js'); ?>
<!DOCTYPE html>
<html lang="vi-VN">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="<? echo IMG ?>/logo.png" />

	<title><? echo (isset($pageTitle)) ? $pageTitle : 'mAstro' ?></title>

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
				<a class="logo" href="<? echo MAIN_URL ?>"><span class="fa fa-code"></span></a>
				<div class="lang">
					<a <? if ($config->lang == 'us') echo 'class="active"' ?> title="English (US)" lang="us"><img src="<? echo IMG ?>/flags/us.png"></a>
					<a <? if ($config->lang == 'vn') echo 'class="active"' ?> title="Tiếng Việt" lang="vn"><img src="<? echo IMG ?>/flags/vn.png"></a>
				</div>
			</div> <!-- .left-top -->
			<div id="left-menu" class="navbar">
				<ul class="home">
					<li class="left-menu-one <? if ($page == 'about') echo 'active' ?>"><a href="<? echo MAIN_URL ?>/about"><span class="fa fa-home"></span></a></li>
				<? if (!$config->u) { ?>
					<li class="left-menu-one <? if ($page == 'login') echo 'active' ?>"><a href="<? echo MAIN_URL ?>/login"><span class="fa fa-key"></span></a></li>
				<? } else { ?>
					<li class="left-menu-one <? if ($page == 'profile') echo 'active' ?>"><a title="Profile/Settings" href="<? echo MAIN_URL ?>/profile"><span class="fa fa-cog"></span></a></li>
				<? } ?>

					<!--<label>Chart</label>-->
					<li class="divide" style="margin-right:8px!important"></li>
					<li class="left-menu-one <? if ($page == 'chart') echo 'active' ?>"><a title="Natal chart" href="<? echo MAIN_URL ?>/chart"><span class="fa fa-user-circle-o"></span></a></li>
					<li class="left-menu-one <? if ($page == 'transit') echo 'active' ?>"><a title="Transit chart" href="<? echo MAIN_URL ?>/transit"><span class="fa fa-calendar"></span></a></li>
					<li class="left-menu-one <? if ($page == 'relationship') echo 'active' ?>"><a title="Relationship chart" href="<? echo MAIN_URL ?>/relationship"><span class="fa fa-heart"></span></a></li>

					<!--<label>Others</label>-->
					<li class="divide" style="margin-right:8px!important"></li>
					<li class="left-menu-one <? if ($page == 'blog') echo 'active' ?>"><a title="News and Blogs" href="<? echo MAIN_URL ?>/blog"><span class="fa fa-comments"></span></a></li>
					<li class="left-menu-one <? if ($page == 'report') echo 'active' ?>"><a title="Report library" href="<? echo MAIN_URL ?>/report"><span class="fa fa-database"></span></a></li>
					<li class="left-menu-one <? if ($page == 'source') echo 'active' ?>"><a title="Sources" href="<? echo MAIN_URL ?>/source"><span class="fa fa-bookmark"></span></a></li>
				</ul>

				<!--<ul class="blog hide"></ul> -->
			</div>
		
			<div class="left-bottom">
				<ul class="nav-users">
					<li class="dropdown" data-placement="top">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<img src="<? echo ($config->u) ? $config->me['avatar'] : MAIN_URL.'/data/img/anonymous.jpeg' ?>" class="avatar img-circle">
							<strong class="s-title hide"><? echo ($config->u) ? $config->me['name'] : '[Guests]' ?></strong>
						</a>
						<? if ($config->u) { ?>
						<ul class="dropdown-menu with-triangle primary pull-left">
							<li><a href="<? echo $config->me['link'] ?>">Me</a></li>
							<li><a href="<? echo $config->me['link'] ?>/charts">My charts</a></li>
							<li><a href="<? echo MAIN_URL ?>/profile">Profile</a></li>
							<li class="divider"></li>
							<li><a href="<? echo MAIN_URL ?>/logout">Logout</a></li>
						</ul>
						<? } ?>
					</li>
				</ul>


			<? if ($config->u) { ?>
				<ul class="nav-users left">
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
				</ul>
			<? } ?>

			<div class="copyright">
				<span>©</span>
				<span class="hide">2016 Miamor West</span>
			</div>
			</div> <!-- .left-bottom -->

		</div>


	<div id="main-content" class="page-<? echo $page ?>">
