<form class="chart-inputs col-lg-9" action="?mode=mastro_data<? if ($m) echo '&m='.$m ?>&do=save" method="post" name="save">
	<? include 'pages/ini/iniform.php' ?>
	<div class="add-form-submit center">
		<input type="reset" value="Reset"/>
		<input type="submit" value="Save"/>
	</div>
</form>

<div class="mastro-data-list col-lg-3">
	<ol>
<? foreach ($dList as $dO) { ?>
	<li class="mastro-data-one">
		<div class="mastro-data-title">
			<a href="<? echo $dO['link'] ?>"><? echo $dO['name'] ?></a>
		</div>
	</li>
<? } ?>
	</ol>
</div>
