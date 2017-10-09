<section id="re-simple" class="hide">
	<div class="chart-report-head htitle"><? echo $lang['Simple relationship compability'] ?></div>
	<div class="chart-report-content">
		<div class="para">
			<h3>Info</h3>
			<div class="col-lg-6">
				<h4>You </h4>
				<b>Name:</b> <? echo $name_without_slashes ?><br/>
				<b>Sun sign:</b> <? echo $sunSign1 ?><br/>
				<b>Gender:</b> <? echo ucfirst($lang[$gender1]) ?>
			</div>
			<div class="col-lg-6">
				<h4>Your partner </h4>
				<b>Name:</b> <? echo $name2_without_slashes ?><br/>
				<b>Sun sign:</b> <? echo $sunSign2 ?><br/>
				<b>Gender:</b> <? echo ucfirst($lang[$gender2]) ?>
			</div>
			<div class="clearfix"></div>
		</div>
<? $loveSun1 = trendCode('love-'.$sunSign1);
$loveSun2 = trendCode('love-'.$sunSign2);
$loveSun12 = trendCode('love-'.$sunSign1.'-'.$sunSign2); ?>
		<div class="paragraph" id="<? echo $loveSun1 ?>" data-rid="<? echo astro($loveSun1)['id'] ?>" data-trans-num="<? echo countTrans(astro($loveSun1)['id']) ?>">
			<h3><? echo $lang[$sunSign1].' '.$lang['and'].' '.$lang['love'] ?></h3>
			<div class="chart-paragraph-content"><? echo astro($loveSun1)['content'] ?></div>
		</div>
		<div class="paragraph" id="<? echo $loveSun2 ?>" data-rid="<? echo astro($loveSun2)['id'] ?>" data-trans-num="<? echo countTrans(astro($loveSun2)['id']) ?>">
			<h3><? echo $lang[$sunSign2].' '.$lang['and'].' '.$lang['love'] ?></h3>
			<div class="chart-paragraph-content"><? echo astro($loveSun2)['content'] ?></div>
		</div>
		<div class="paragraph" id="<? echo $loveSun12 ?>" data-rid="<? echo astro($loveSun12)['id'] ?>" data-trans-num="<? echo countTrans(astro($loveSun12)['id']) ?>">
			<h3><? echo $lang[$sunSign1].' '.$lang['and'].' '.$lang[$sunSign2] ?></h3>
			<div class="chart-paragraph-content"><? echo astro($loveSun12)['content'] ?></div>
		</div>
<? $lwgAr = array();
foreach ($sign_name as $i => $sii) {
	for ($j = $i; $j < 12; $j++) {
		$sij = $sign_name[$j];
		$lwgAr[] = trendCode('love-f-'.$sii.'-m-'.$sij);
		if ($i != $j) $lwgAr[] = trendCode('love-m-'.$sii.'-f-'.$sij);
	}
}
$lwg = trendCode('love-'.$gender1.'-'.$sunSign1.'-'.$gender2.'-'.$sunSign2);
$lwg_ = trendCode('love-'.$gender2.'-'.$sunSign2.'-'.$gender1.'-'.$sunSign1);
if (in_array($lwg, $lwgAr)) $loveWithGender = $lwg;
else $loveWithGender = $lwg_; ?>
		<div class="paragraph" id="<? echo $loveWithGender ?>" data-rid="<? echo astro($loveWithGender)['id'] ?>" data-trans-num="<? echo countTrans(astro($loveWithGender)['id']) ?>">
			<h3><? echo $lang[$gender1].' '.$lang[$sunSign1].' '.$lang['and'].' '.$lang[$gender2].' '.$lang[$sunSign2] ?></h3>
			<div class="chart-paragraph-content"><? echo astro($loveWithGender)['content'] ?></div>
		</div>
	</div>
</section>
