<? include_once '__initialize.'.$page.'.php'; ?>


<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
}
-->
</style>
<page backcolor="#FEFEFE" backtop="0" backbottom="30mm" footer="date;heure;page" style="font-size: 12pt">
    <bookmark title="Lettre" level="0" ></bookmark>
<? if ($ubt1 == 0) {
//	$s_pos = floor($hc1[1] / 30) + 1;
//	$rising = $sign_name[$s_pos];
	$risingCode = 'rising-'.trendCode($rising);
	$risingSunCode = $risingCode.'-sun-'.trendCode($sunSign);
	$desRRport = astro('rising');
	$rReport = astro($risingCode);
	$rsReport = astro($risingSunCode); ?>

	<div class="chart-report-head htitle"><? echo $lang['The rising sign or ascendant'] ?></div>
	<div class="chart-report-content">
		<div class="chart-report-des"><? echo $desRReport['content'] ?></div>
	<div class="module parallax">
		<div class="parallax-bg" style="background-image:url(<? echo zBg.'/zodiac-art-'.trendCode($rising).'.jpg' ?>)"></div>
		<div class="paragraph" id="<? echo ($risingCode) ?>" data-rid="<? echo $rReport['id'] ?>" data-trans-num="<? echo countTrans($rReport['id']) ?>">
<!--			<img class="paragraph-bg" src="<? echo zBg.'/zodiac-art-'.trendCode($rising).'.jpg' ?>"/> -->
			<h3><b><? echo $lang['ascendant-before'] ?> <? echo $lang[$rising] ?> <? echo $lang['ascendant'] ?></b></h3>
			<div class="chart-paragraph-content"><? echo $rReport['content'] ?></div>
		</div>
	</div>
		<div class="paragraph" id="<? echo ($risingSunCode) ?>" data-rid="<? echo $rsReport['id'] ?>" data-trans-num="<? echo countTrans($rsReport['id']) ?>">
			<h3><b><? echo $lang['rising_before'].' '.$lang[$rising].$lang['rising_after'].' '.$lang['and'].' '.$lang['sun'].' '.$lang[$sunSign] ?></b></h3>
			<div class="chart-paragraph-content"><? echo $rsReport['content'] ?></div>
		</div>
	</div>

<? } ?>
    <nobreak>
        <br>
        Dans cette attente, nous vous prions de recevoir, Madame, Monsieur, Cher Client, nos meilleures salutations.<br>
        <br>
    </nobreak>
</page>

