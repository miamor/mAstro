<? if ($do == 'rate') {
	$star = $_POST['star'];
	$star = get('rate');
	$title = $_POST['title'];
	$content = _content($_POST['content']);
	if ($star && $title && $content) {
		$rated = rate($tb, $iid, $star, $title, $content);
		if ($rated == 1) echo '[type]success[/type][content]Rated successfully![/content]';
		else echo '[type]warning[/type][content]'.$content.'[/content]';
	} else echo $Er[001];
}
if ($do == 'setstt') {
	$stt = get('stt');
	if ($stt) {
		$change = changeValue($tb, "`id` = '{$iid}' ", "`stt` = '{$stt}' ");
		if ($change) echo 0;
		else echo 1;
	} else echo $er[001];
}
if ($do == 'setshow') {
	$show = get('show');
	$source = get('source');
	$oki = false;
	if ($show == 'source' && !$source) {
$sort = get('sort');
$order = get('order');
if (!$sort || $sort == 'ratings') {
	if ($order == 'asc') $ordeR = "LENGTH(likes) DESC, LENGTH(dislikes) ASC";
	else $ordeR = "LENGTH(likes) ASC, LENGTH(dislikes) DESC";
} else {
	if ($order == 'asc') $ordeR = '`time` ASC';
	else $ordeR = '`time` DESC';
}
		$sList = $getRecord -> GET('source', "`lang` = '{$lg}' ", '', $ordeR); ?>
<div class="popup-full">
	<div class="popup-section section-light">
		<div class="data-filter-options" data-rid="<? echo $lg ?>">
			<div class="filter-lang left">
				Language: <img src="<? echo IMG ?>/flags/<? echo $lg ?>.png"/>
			</div>
			<div class="filter-sort right">
				Order by: 
				<select id="sort">
					<option value="ratings" <? if (!$sort || $sort == 'ratings') echo 'selected' ?>>Ratings</option>
					<option value="time" <? if ($sort == 'time') echo 'selected' ?>>Time</option>
				</select>
				<select id="order">
					<option value="asc" <? if ($order == 'asc') echo 'selected' ?>>ASC</option>
					<option value="desc" <? if (!$order || $order == 'desc') echo 'selected' ?>>DESC</option>
				</select>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="data-list">
<? 	foreach ($sList as $sO) { ?>
		<div class="friend-one" id="<? echo $sO['id'] ?>">
			<span class="source-icon source-<? echo $sO['type'] ?>"></span>
			<a class="friend-avt left">
				<div class="friend-avt-div">
					<img class="friend-avt-img img-rounded" src="<? echo $sO['avatar'] ?>"/>
				</div>
			</a>
			<a class="friend-name left"><? echo $sO['title'] ?></a>
			<div class="clearfix"></div>
			<div class="friend-des">
				<? echo $sO['des'] ?>
			</div>
			<div class="friend-url">
				<? if ($sO['type'] == 'website') echo '<span class="fa fa-home"></span> ';
				else echo '<span class="fa fa-book"></span>' ?>
				<a href="<? echo $sO['url'] ?>"><? echo $sO['url'] ?></a>
			</div>
		</div>
<? } ?>
		<div class="clearfix"></div>
		</div> <!-- .data-list -->
	</div>
</div>
<script src="<? echo JS ?>/chart/setshow_source.js"></script>
<?	} else if ($show) $oki = true;
	if ($oki == true) {
		if ($show) $_SESSION['show'] = $show;
		if ($source) $_SESSION['source'] = $source;
		else $_SESSION['source'] = '';
		echo 0;
	}
}
if ($do == 'edit') {
	$id = get('id');
	$rid = $_POST['rid-'.$id];
	$content = _content($_POST['content-'.$id]);
	if (!$rid || $rid == 0) echo 'No data found.';
	else if ($content) {
		if (countRecord('data', "`id` = '{$rid}' ") > 0) {
			$change = changeValue('data', "`id` = '{$rid}' ", "`content` = '{$content}' ");
			if ($change) echo 0;
			else echo 1;
		} else echo $er[002];
	} else echo $er[001];
}
if ($do == 'contribute') {
	$sid = explode('s', $_POST['source-'.$id]);
	$id = get('id');
	$content = _content($_POST['content-'.$id]);
	if ($content) {
		if (countRecord('data', "`content` = '{$content}' AND `code` = '{$id}' ") > 0) echo $er[002];
		else {
			$ins = insert('data', "`uid`, `code`, `sid`, `content`, `lang`, `time` ", " '{$u}', '{$id}', '{$sid}', '{$content}', '{$lg}', '{$current}' ");
			if ($ins) echo 0;
			else echo 1;
		}
	} else echo $er[001];
}
if ($do == 'translate') {
	$translator = $_POST['translator-'.$id];
	$id = get('id');
	$content = _content($_POST['content-'.$id]);
	$lng = $_POST['lang-'.$id];
	if ($content && $lng) {
		if (countRecord('data', "`content` = '{$content}' AND `code` = '{$id}' AND `lang` = '{$lng}' ") > 0) echo $er[002];
		else {
			$ins = insert('data', "`translate`, `untrans`, `uid`, `code`, `content`, `lang`, `time` ", " '1', '{$translator}', '{$u}', '{$id}', '{$content}', '{$lng}', '{$current}' ");
			if ($ins) echo 0;
			else echo 1;
		}
	} else echo $er[001];
} ?>
