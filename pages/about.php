<? $pageTitle = 'About';
if (!$do && !$v && !$temp) include 'pages/views/_temp/header.php';
 ?>
<div class="about col-lg-8 no-padding">
<div class="paragraph" id="mastro">
	<h2>What is mAstro?</h2>
	<p>mAstro is a free and open astrological community.</p>
	<ol>
		<li>We offer a free astrological tool which allows users to generate natal, transit, progression, composite chart,... and collects reports from many sources to make it easier for everyone to understand the chart.</li>
		<li>Users are free to rate and better the reports, get to know astrology and horoscope, join with friends and share the results,...</li>
	</ol>
	<p>Our targets are to make everything clear and clean so that everyone could understand what the chart says about you, about your relationship with partner,... and to better the reports thanks to the whole community.</p>
</div>

<div class="paragraph" id="mastro">
	<h2>Why mAstro is built?</h2>
	<p>We want to bring you the best experience in astrology with totally free cost!</p>
</div>

<div class="paragraph" id="contribute">
	<h2>How to contribute?</h2>
	<div class="paragraph" id="reporter">
		<h3>Reporter</h3>
		<p>You know, the contents are not always appropriate, some really need correcting. So, the easiest way you can help us is to report the unappropriate contents.</p>
		<p>Next to each report header are several buttons, in this section we notice only the report button (<span class="fa fa-lock"></span>), click the report button, you will see a window appear.</p>
	</div>
	<div class="paragraph" id="free-contributor">
		<h3>Free contributor</h3>
<!--		<p>mAstro is set to be free for everyone to contribute.</p> -->
		<p>mAstro is an open community for everyone to contribute. You no need to become an official-contributor or manager to edit the contents. Please see sections below.</p>
		<p>In a chart (eg: <a href="<? echo $config->cLink ?>/miamor/1"><? echo $config->cLink ?>/miamor/1</a>), you will see several reports in the report section (right side). Next to each section header appear the contribute (<span class="fa fa-plus"></span>) and translate (<span class="fa fa-language"></span>) buttons. Click on each button and scroll down you will see a form.</p>
		<div class="paragraph" id="for-contribute">
			<h4>For contributor <span class="gensmall light">Click contribute (<span class="fa fa-plus"></span>) button.</span></h4>
			<p><b>Source</b>: The source page of the data. See the source library <a href="<? echo $sLink ?>">here</a>.</p>
			<p><b>Content</b>: (textarea) Content of the report.</p>
			<div class="text-warning"><b>* Note</b> If you translate an already-available report from a language to another language, please use the translate form (<span class="fa fa-language"></span> button, see the section below).</div>
		</div>
		<div class="paragraph" id="for-translate">
			<h4>For translator <span class="gensmall light">Click translate (<span class="fa fa-language"></span>) button.</span></h4>
			<p><b>Translator</b>: The person/people translating the report.</p>
			<p><b>Language</b>: The language which the report is translated to.</p>
			<p><b>Content</b>: (textarea) Translated content of the report.</p>
			<div class="text-warning"><b>* Note</b> Please fill in the appropriate translated content.</div>
		</div>
		<div class="alerts alert-info">Free contributor can only contribute to available contents meaning the contents which appear to you. If you are willing to support more, please the the section below.</div>
	</div>
	<div class="paragraph" id="partner-contributor">
		<h3>Partner-contributor</h3>
		<p>We have some sources of astrological that needs translating and updating. You are always welcomed to become one of us. </p>
		<div class="text-warning"><b>* Site translator</b> We're also looking for translators who work on site contents (not the reports). If you are interested, don't be hesitate to <a href="#contact">contact us</a>.</div>
	</div>
</div>

<div class="paragraph" id="source">
	<h2>Source</h2>
	<p>Sources are updated from: astro.com, documents from scripts, matngu12chomsao,...</p>
	<p>See and add sources to our library <a href="<? echo $sLink ?>">here</a></p>
</div>

<div class="paragraph" id="language">
	<h2>Language available</h2>
	<p>We're currently working on 2 first language, <b>English (US)</b> and <b>Vietnamese</b></p>
	<p>Based language is <b>English (US)</b></p>
</div>

<div class="paragraph" id="developer">
	<h2>Developer</h2>
	<p>mAstro is hosted open source <a href="https://bitbucket.org/vyskzi/mastro">here</a>.</p>
	<p>Scripts used: <b>Php Astrology Scripts</b> by <b>Allen Edwall</b> <a href="http://www.astrowin.org/php_scripts/">http://www.astrowin.org/php_scripts/</a></p>
</div>

<div class="paragraph" id="contact">
	<h2>Contact us</h2>
	<p><b>Facebook</b>: <a href="https://www.facebook.com/mialun.297">Nguyễn Tú (Mía Lùn)</a></p>
	<p><b>Gmail</b>: <a href="https://www.facebook.com/mialun.297">miamorwest@gmail.com</a></p>
</div>

</div>
<div class="clearfix"></div>