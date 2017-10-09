<? 
if (!$config->u) {
	$pageTitle = 'Members area';
	echo '<div class="alerts alert-warning">Only members have permissions to access this page.</div>';
} else {
	// include object files
	include_once 'objects/mData.php';
	$mData = new mData();
	
		$tabs = array(
			'mastro_data' => 'mAstro data',
			'information' => 'Information',
			'account' => 'Account settings',
			'notification' => 'Notifications settings',
			'settings' => 'mAstro settings',
			//'info' => '<a href="'.$config->me['link'].'">Information</a>'
		);
	
	$mode = ($config->get('mode') !== null) ? $config->get('mode') : null;
	$m = ($config->get('m') !== null) ? $config->get('m') : null;

	if (!$mode) $mode = 'mastro_data';
	$pageTitle = $tabs[$mode];

	if (!$do && !$v && !$temp) include 'pages/views/_temp/header.php';

	if ($do) include 'system/'.$page.'/'.$do.'.php';
	else { ?>
		<div class="alerts alert-info">
			We highly remcommend you save your data and even publish them to your friends.<br/>
			Saving your data can help you save time while generating a chart, and publishing them will allow people to generate <span class="italic">relationship charts</span> with your data. (without knowing your data details. They are always protected under our <a>privacy policy</a> in any circumstances.) <a>Read more</a>
		</div>
		<div id="m_tab" class="profile">
			<div class="m_tab">
		<? foreach ($tabs as $tak => $tab) {
			if ($mode && $mode == $tak) echo '<div class="tab active" id="'.$tak.'"><a href="?mode='.$tak.'">'.$tab.'</a></div>';
			else echo '<div class="tab" id="'.$tak.'"><a href="?mode='.$tak.'">'.$tab.'</a></div>';
		} ?>
			</div>
		<? 	foreach ($tabs as $tak => $tab) {
				if (($mode && $mode == $tak) || $tak == 'mastro_data') echo '<div class="tab-index '.$tak.'">';
				else echo '<div class="hide tab-index '.$tak.'">';
					include 'views/'.$page.'/v.'.$tak.'.php';
				echo '</div>';
			} ?>
		</div>
<? 	}
} ?>