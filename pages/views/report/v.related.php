<? $code = $dIn['code'];
$ot = $config->get('ot');
$sort = $config->get('sort');
$order = $config->get('order');
$iid = $config->get('iid');
if (!$sort || $sort == 'ratings') {
	if (!$order || $order == 'desc') $ordeR = "LENGTH(likes) DESC, LENGTH(dislikes) ASC";
	else $ordeR = "LENGTH(likes) ASC, LENGTH(dislikes) DESC";
} else {
	if (!$order || $order == 'desc') $ordeR = '`time` ASC';
	else $ordeR = '`time` DESC';
}
if (!$ot || $ot == 'o') $ott = 0;
else $ott = 1;
$report->readAll($code, $dIn['lang'], $ott, $ordeR);
$related = $report->rList;
//$related = $getRecord -> GET('data', "`code` = '{$code}' AND `lang` = '{$dIn['lang']}' AND {$more} ", '', $ordeR); ?>
<div class="popup-full">
	<div class="popup-section section-light">
		<div class="data-filter-options" data-rid="<? echo $dIn['id'] ?>">
			<div class="filter-lang left">
				Language: <img src="<? echo IMG ?>/flags/<? echo $dIn['lang'] ?>.png"/>
			</div>
			<div class="filter-sort right">
				Order by: 
				<select id="sort" disabled>
					<option value="ratings" <? if (!$sort || $sort == 'ratings') echo 'selected' ?>>Ratings</option>
					<option value="time" <? if ($sort == 'time') echo 'selected' ?>>Time</option>
				</select>
				<select id="order" disabled>
					<option value="asc" <? if ($order == 'asc') echo 'selected' ?>>ASC</option>
					<option value="desc" <? if (!$order || $order == 'desc') echo 'selected' ?>>DESC</option>
				</select>
			</div>
			<div class="filter-ot right">
				Type:
				<select id="ot" >
					<option value="o" <? if (!$ot || $ot == 'o') echo 'selected' ?>>Origin language</option>
					<option value="t" <? if ($ot == 't') echo 'selected' ?>>Translated</option>
				</select>
			</div>
			<div class="clearfix"></div>
		</div>
	<div class="data-list">
<? if (count($related) <= 0) echo '<div class="one-data">No data available.</div>';
else {
	$source = new Source();
foreach ($related as $rO) {
	$pLikesAr = $pDislikesAr = array();
	if ($rO['likes']) $pLikesAr = explode(',', $rO['likes']);
	$pLikes = count($pLikesAr);
	if ($rO['dislikes']) $pDislikesAr = explode(',', $rO['dislikes']);
	$pDislikes = count($pDislikesAr);
	$vote = $pLikes - $pDislikes;
//	$pLikesWidth = round($pLikes/($pLikes + $pDislikes), 4)*100;
//	$pDislikesWidth = round($pDislikes/($pLikes + $pDislikes), 4)*100;
//	$sIn = getRecord('source', "`id` = '{$rO['sid']}' ");
	$source->id = $rO['sid'];
	$sIn = $source->readOne();
	if ($rO['translate'] == 1) {
//		$pIn = getRecord('data', "`id` = '{$rO['did']}' ");
		$report->id = $rO['did'];
		$pIn = $report->readOne();
//		$auTrans = '<a href=""></a>';
	}
	$au = $dIn['author'];
	if ($sIn['avatar']) {
		$thumb = $sIn['avatar'];
		$sTxt = '<a target="_blank" href="'.$config->sLink.'/'.$sIn['link'].'">'.$sIn['title'].'</a>';
	} else {
		$thumb = MAIN_URL.'/data/black.jpg';
		$sTxt = '<a>[Unnamed source]</a>';
	} ?>
	<div class="one-data<? if ($rO['id'] == $iid) echo ' active' ?>" data-id="<? echo $code ?>" data-rid="<? echo $rO['id'] ?>">
		<div class="col-lg-1 no-padding">
			<div class="sta-button">
				<div class="sta-likes-btn"><? echo $pLikes ?></div>
				<div class="sta-dislikes-btn"><? echo $pDislikes ?></div>
			</div>
			<img class="source-thumb" src="<? echo $thumb ?>"/>
		<? if ($vote != 0) { ?>
			<div class="vote-grade <? if ($vote > 0) echo 'text-primary'; else echo 'text-danger' ?>" align="center">
				<? if ($vote > 0) echo '+'; echo $vote ?>
			</div>
		<? } ?>
		</div>
		<div class="col-lg-11 no-padding-right">
			<div class="source-title"><? echo $sTxt ?> <span class="gensmall"><? if ($rO['translate'] == 1) echo 'translated from <a target="_blank" href="'.$dLink.'/'.$pIn['id'].'">#'.$pIn['id'].'</a>' ?></span></div>
			<div class="shorten"><? echo $rO['content'] ?></div>
		<? if (isset($sIn['uid']) && $sIn['uid'] != 0) { ?>
			<div class="contributor left">
				<a href="<? echo $au['link'] ?>" data-online="<? echo $au['online'] ?>">
					<img class="left" style="height:30px;margin-right:6px" src="<? echo $au['avatar'] ?>"/>
				</a>
				<a href="<? echo $au['link'] ?>"><? echo $au['name'] ?></a>
			</div>
		<? } ?>
			<div class="gensmall right time"><span class="fa fa-clock-o"></span> <? echo $rO['time'] ?></div>
		</div>
		<div class="clearfix"></div>
	</div>
<? }
} ?>
	</div> <!-- .data-list -->
	</div>
</div>
<script>var old_rid = <? echo $dIn['id'] ?>; var code = '<? echo $dIn['code'] ?>';</script>
<script src="<? echo JS ?>/report/v.related.js"></script>
