<? if ($config->u /*&& $chart->checkMyRate() <= 0*/) { ?>
<div class="separator divider"></div>
<form class="item-rating-form" id="wreview">
	<h4 class="col-lg-12 no-padding add-review-label">Add a review</h4>
	<div class="arrow-div">
		<div class="form-group">
			<div class="col-lg-4 bold control-label" style="margin-top:10px">Section </div>
			<div class="col-lg-8">
				<select class="form-control" data-v="source">
					<option class="0">Collected data</option>
				<? if ($page == 'chart') { ?>
					<option class="1">[Advanced] Personality</option>
					<option class="2">[Advanced] Love</option>
					<option class="3">[Advanced] Career</option>
					<option class="4">[Advanced] Future forecast</option>
				<? } ?>
				</select>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="form-groups">
			<div class="col-lg-4 bold">How would you rate this? </div>
			<div class="col-lg-8" style="padding-bottom:3px">
				<div class="star-info" data-c="<? echo $bp['id'] ?>">
					<div class="rating-icons left">
						<? for ($z = 1; $z <= 5; $z++) { ?>
							<div class="rating-star-icon v<? echo $z ?>" id="v<? echo $z ?>">&nbsp;</div>
						<? } ?>
						<div class="rate-count" style="width:0%"></div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="form-group no-margin">
			<div class="col-lg-12 bold control-label">Your review title? </div>
			<div class="col-lg-12">
				<input type="text" name="title" class="form-input" placeholder="e.g. Exactly!"/>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="form-group">
			<div class="col-lg-12 bold control-label">Share something about? </div>
			<div class="col-lg-12">
				<input type="hidden" class="rate-val" name="rate"/>
				<textarea name="content" class="form-input" style="height:120px"></textarea>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="add-form-submit center">
			<input type="reset" value="Reset"/>
			<input type="submit" value="Submit"/>
		</div>
		<div class="clearfix"></div>
	</div>
</form>
<? } else if (!$config->u) echo '<div class="alerts alert-warning">Please <a href="'.MAIN_URL.'/login">login</a> to help us rate this campaign.</div>' ?>
