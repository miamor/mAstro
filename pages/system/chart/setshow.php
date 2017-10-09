<?
	include_once 'objects/source.php';
	$source = new Source();
	$show = $config->get('show');
	$_source = $config->get('source');
	$oki = false;
	if ($show == 'source' && !$_source) {
$sort = ($config->get('sort') != null) ? $config->get('sort') : 'ratings';
$order = ($config->get('order') != null) ? $config->get('order') : 'desc';
if (!$sort || $sort == 'ratings') {
	if ($order == 'asc') $ordeR = "LENGTH(likes) ASC, LENGTH(dislikes) DESC";
	else $ordeR = "LENGTH(likes) DESC, LENGTH(dislikes) ASC";
} else {
	if ($order == 'asc') $ordeR = '`time` ASC';
	else $ordeR = '`time` DESC';
}
$sList = $source->readAll($lg, $ordeR);
$stList = $source->readAll(($lg == 'vn') ? 'us' : 'vn', $ordeR);
//$sList = $getRecord -> GET('source', "`lang` = '{$lg}' ", '', $ordeR); ?>
<div class="popup-full">
	<div class="popup-section section-light" id="original-list">
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
				<? if ($sO['type'] == 'website') echo '<span class="left fa fa-home"></span> ';
				else echo '<span class="left fa fa-book"></span>' ?>
				<a title="<? echo $sO['url'] ?>" style="display:inline-block;float:left;margin:-3px 0 0 5px;position:relative;max-width:80%;overflow:hidden;white-space:nowrap;text-overflow:ellipsis" href="<? echo $sO['url'] ?>"><? echo $sO['url'] ?></a>
			</div>
		</div>
<? } ?>
		<div class="clearfix"></div>
		</div> <!-- .data-list -->
	</div>
	
	<div class="popup-section section-light" id="translate-list">
		<div class="data-filter-options" data-rid="<? echo ($lg == 'vn') ? 'us' : 'vn' ?>">
			<div class="filter-lang left">
				Translate from: <img src="<? echo IMG ?>/flags/<? echo ($lg == 'vn') ? 'us' : 'vn' ?>.png"/>
			</div>
<!--			<div class="filter-sort right">
				Order by: 
				<select id="sort">
					<option value="ratings" <? if (!$sort || $sort == 'ratings') echo 'selected' ?>>Ratings</option>
					<option value="time" <? if ($sort == 'time') echo 'selected' ?>>Time</option>
				</select>
				<select id="order">
					<option value="asc" <? if ($order == 'asc') echo 'selected' ?>>ASC</option>
					<option value="desc" <? if (!$order || $order == 'desc') echo 'selected' ?>>DESC</option>
				</select>
			</div>-->
			<div class="clearfix"></div>
		</div>
		<div class="data-list">
<? 	foreach ($stList as $sO) { ?>
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
				<? if ($sO['type'] == 'website') echo '<span class="left fa fa-home"></span> ';
				else echo '<span class="left fa fa-book"></span>' ?>
				<a title="<? echo $sO['url'] ?>" style="display:inline-block;float:left;margin:-3px 0 0 5px;position:relative;max-width:80%;overflow:hidden;white-space:nowrap;text-overflow:ellipsis" href="<? echo $sO['url'] ?>"><? echo $sO['url'] ?></a>
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
		if ($_source) $_SESSION['source'] = $_source;
		else $_SESSION['source'] = '';
		echo 0;
	}
