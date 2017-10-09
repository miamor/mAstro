<div class="chart-v chart-v-<? echo $page ?>">
	<div class="chart-canvas-div col-lg-5">
		<? include 'v.chart.php' ?>
	</div>
	<div class="chart-report col-lg-7 no-padding">
		<div class="nav-tabs-custom chart-report-tabs">
			<ul class="nav nav-tabs right">
				<li class="active"><a href="#free" data-toggle="tab"><? echo $lang['Collected data'] ?></a></li>
				<li class="pull-right" style="margin-left:15px;padding-left:15px;border-left:1px solid #f0f0f0"><a href="#ratings" data-toggle="tab"><? echo $lang['Ratings'] ?></a></li>
				<li class="pull-right"><a href="#advanced" data-toggle="tab"><? echo $lang['Advanced'] ?></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="free">
					<div class="chart-nav"></div>
					<? foreach ($sections as $sec) include 's.'.$sec.'.php' ?>
					<div class="chart-report-bottom">
						<div class="col-lg-6 right">
							<select class="form-control" data-v="<? echo $show ?>">
								<option class="top"<? if (!$show || $show == 'top') echo ' selected' ?>><? echo $lang['Show top report only'] ?></option>
								<option class="source"<? if ($show == 'source') echo ' selected' ?>><? echo $lang['Show reports by source'] ?></option>
							</select>
						</div>
						<div class="col-lg-2 right no-padding-right">
						<? if ($show == 'source') { ?>
							<a class="source-selected" title="Source selected: <? echo $sSelected['title'] ?>"><img src="<? echo $sSelected['avatar'] ?>"/></a>
						<? } ?>
						</div>
					</div>
				</div> <!-- end #free -->

				<div class="tab-pane hide" id="advanced">
					<div class="chart-nav"></div>
					<section id="s_advanced" class="hide" style="display: block;">
						<div class="chart-report-head htitle"><? echo $lang['Advanced'] ?></div>
						<div class="chart-report-content">
							<div class="alerts alert-warning"><? echo $lang['This feature is not available yet'] ?>.</div>
						</div>
					</section>
					<div class="chart-report-bottom"></div>
				</div> <!-- end #advanced -->

				<div class="tab-pane hide" id="ratings">
					<div class="chart-nav"></div>
					<section id="ratings" class="hide">
						<div class="chart-report-head htitle"><? echo $lang['Ratings'] ?></div>
						<div class="chart-report-content ratings">
							<? $tbRatings = $page.'_ratings';
							include 'pages/views/_temp/ratings.php' ?>
							<? $iIn = $cIn; include 'pages/views/_temp/ratingsAdd.php' ?>
						</div>
					</section>
					<div class="chart-report-bottom"></div>
				</div> <!-- end #ratings -->
			</div>
		</div>

	</div>
	
	<div class="clearfix"></div>
</div> <!-- .chart-v -->
