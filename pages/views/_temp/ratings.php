<div class="ratings-list abox">
<? //$rList = $getRecord -> GET($tbRatings, "`iid` = '{$iid}' AND `show` = 1 ", '', '`rate` DESC, LENGTH(likes) DESC, LENGTH(content) DESC');
$rList = $chart->rList;
if (count($rList) == 0) echo 'No ratings yet.';
else {
foreach ($rList as $rl) {
	$rAu = $rl['au'] ?>
	<div class="one-rating one-reg hep<? echo $rl['id'] ?> <? if ($rl['content']) echo 'with-content' ?>" data-uid="<? echo $rl['uid'] ?>" alt="<? echo $rl['id'] ?>">
		<a class="left" data-online="<? echo $rAu['online'] ?>" href="<? echo $rAu['link'] ?>">
			<img class="rl-avt img-rounded left" width="40px" height="40px" src="<? echo $rAu['avatar'] ?>"/>
		</a>
		<div class="rl-details">
			<div class="gensmall right reg-time" style="margin-top:5px"><? echo timeFormat($rl['time']) ?></div>
			<a class="bold" href="<? echo $rAu['link'] ?>"><? echo $rAu['name'] ?></a>
			<div class="star-info" style="margin-left:7px">
				<div class="rating-icons rated">
				<? for ($z = 1; $z <= 5; $z++) { ?>
					<div class="rating-star-icon v<? echo $z ?>" id="v<? echo $z ?>">&nbsp;</div>
				<? } ?>
					<div class="rate-count" style="width:<? echo round($rl['rate']/5*100, 2) ?>%"></div>
				</div>
			</div>
			<div class="rl-title bold">
				<? echo $rl['title'] ?>
			</div>
			<div class="rl-content">
				<? if ($rl['content']) echo content($rl['content']) ?>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
<? }
} ?>
</div>
