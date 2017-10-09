<? $code = $dIn['code'];
//$sIn = getRecord('source', "`id` = '{$dIn['sid']}' ");
	$source->id = $dIn['sid'];
	$sIn = $source->readOne();
if ($dIn['translate'] == 1) {
//	$pIn = getRecord('data', "`id` = '{$dIn['did']}' ");
		$report->id = $dIn['did'];
		$pIn = $report->readOne();
//	$auTrans = '<a href=""></a>';
}
$au = $dIn['author'];
if ($sIn['avatar']) {
	$thumb = $sIn['avatar'];
	$sTxt = '<a target="_blank" href="'.$sLink.'/'.$sIn['link'].'">'.$sIn['title'].'</a>';
} else {
	$thumb = MAIN_URL.'/data/black.jpg';
	$sTxt = '<a>[Unnamed source]</a>';
}
 ?>
<div class="popup-full">
	<div class="popup-section section-light report-section">
		<h3 class="bor no-margin">Report content</h3>
<!--		<div class="report-reasons hide" id="a1">
			<div><label class="radio"><input type="radio" value="0" name="reason"> The license is wrong.</label></div>
			<div><label class="radio"><input type="radio" value="1" name="reason"> It's not related to the topic.</label></div>
			<div><label class="radio"><input type="radio" value="0" name="reason"> It's not appropriate to me.</label></div>
		</div>
		<div class="report-reasons hide" id="a0">
			<div><label class="radio"><input type="radio" value="1" name="reason"> It contains grammar error.</label></div>
			<div><label class="radio"><input type="radio" value="0" name="reason"> This is a translation from a report in other language.</label></div>
		</div> -->
	<div class="one-data" data-id="<? echo $code ?>" data-rid="<? echo $iid ?>">
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
			<div class="source-title"><? echo $sTxt ?> <span class="gensmall"><? if ($dIn['translate'] == 1) echo 'translated fdInm <a target="_blank" href="'.$dLink.'/'.$pIn['id'].'">#'.$pIn['id'].'</a>' ?></span></div>
			<div class="shorten"><? echo $dIn['content'] ?></div>
		<? if ($sIn['uid']) { ?>
			<div class="contributor left">
				<a href="<? echo $au['link'] ?>" data-online="<? echo $au['online'] ?>">
					<img class="left" style="height:30px;margin-right:6px" src="<? echo $au['avatar'] ?>"/>
				</a>
				<a href="<? echo $au['link'] ?>"><? echo $au['name'] ?></a>
			</div>
		<? } ?>
			<div class="gensmall right time"><span class="fa fa-clock-o"></span> <? echo $dIn['time'] ?></div>
		</div>
		<div class="clearfix"></div>
	</div>
		<form class="report-reasons">
			<p>Ok my friend. What's the problem?</p>
<!--			<div><label class="radio"><input type="radio" value="0" name="act"> I want this to be removed from mAstro.</label></div>
			<div><label class="radio"><input type="radio" value="1" name="act"> This needs to be edited.</label></div> -->
			<li><label class="radio"><input type="radio" value="0" name="reason"> The copyright/license is missing/incorrect.</label></li>
			<li><label class="radio"><input type="radio" value="1" name="reason"> It's not related to the topic.</label></li>
			<li><label class="radio"><input type="radio" value="2" name="reason"> It contains grammar error.</label></li>
			<li><label class="radio"><input type="radio" value="3" name="reason"> It's not appropriate to me.</label></li>
			<li><label class="radio"><input type="radio" value="4" name="reason"> This is a translation from a report in other language.</label></li>
			<div class="add-form-submit center">
				<a type="reset" class="btn btn-default cancel-report" name="Cancel">Cancel</a>
				<input type="submit" value="Submit"/>
			</div>
		</form>
	</div>
</div>
