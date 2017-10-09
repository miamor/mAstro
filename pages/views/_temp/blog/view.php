<div class="mainpost-view">
	<div class="maintitle floated left dropped">
		<h3 class="b-title"><? echo $title ?> </h3>
		<span class="fa fa-user"></span> by <a href="<? echo $author['link'] ?>"><? echo $author['name'] ?></a>
		on <span class="time"><span class="fa fa-clock-o"></span> <? echo $created ?></span>
	</div>
	<div class="right b-buttons" style="margin:30px 0 0 10px">
<? if ($config->me['is_mod'] == 1) { ?>
		<a class="btn btn-default pull-right" href="<? echo $config->bLink.'/'.$fid.'?mode=new' ?>"><i class="fa fa-plus"></i> New topic</a>
<? }
if ($config->me['is_mod'] == 1 || $config->u == $uid) { ?>
		<a class="btn btn-default pull-right" href="?mode=edit"><i class="fa fa-pencil"></i> Edit</a>
<? } ?>
	</div>
	<div class="clearfix"></div>
	<hr/>
	<div class="maincontent" id="tfirst">
	<table cellspacing="0" cellpadding="0" class="ipbtable no-border" id="1">
		<thead>
			<tr>
				<th class="hidden th-none">
					<div class="time left"><span class="fa fa-clock-o"></span> <? echo $created ?></div>
					<div class="post-count right"><a href="#1">#1</a></div>
					<div class="clearfix"></div>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr valign="top">
				<td class="postmain">
					<div class="post-entry">
						<div class="post-content">
							<? echo ($content) ?>
						</div>
<!--						<div class="post-foot">
							<div class="right">
								<a class="post-btn" href="#quote" id="<? echo $id ?>"><i class="fa fa-quote-left"></i> Quote</a>
								<a class="post-btn" href="#report" id="<? echo $id ?>"><i class="fa fa-exclamation"></i> Report</a>
							</div>
							<div class="clearfix"></div>
						</div> --\>
						<div class="postprofile right">
							<a class="postprofile-avatar left" href="<? echo $author['link'] ?>" data-online="<? echo $author['online'] ?>"><img class="avatar" src="<? echo $author['avatar'] ?>"/></a>
							<a href="<? echo $author['link'] ?>"><? echo $author['name'] ?></a>
							<div class="clearfix"></div>
						</div>-->
						<div class="clearfix"></div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
</div>


<div class="col-lg-10">
</div>

<div class="col-lg-2 advertise no-padding">
</div>
<div class="clearfix"></div>

<div class="treplies tbmargin">
	<div class="maintitle hidden floated dropped">
		<h3>Replies on <? echo $title ?> </h3>
	</div>
	<div class="maincontent t_replies">
	<table width="100%" cellspacing="0" cellpadding="0" class="ipbtable no-border" id="treplies">
		<thead class="hidden">
			<tr>
				<th class="th-none hidden"></th>
				<th class="th-none hidden"></th>
			</tr>
		</thead>
	</table>
	</div>
</div>


<div class="right b-buttons t-btns" style="margin-top:15px">
<? if ($config->me['is_mod'] == 1) { ?>
	<a class="btn btn-default pull-right" href="<? echo $config->bLink.'/'.$fid.'?mode=new' ?>"><i class="fa fa-plus"></i> New topic</a>
<? }
if ($config->me['is_mod'] == 1 || $config->u == $uid) { ?>
	<a class="btn btn-default pull-right" href="?mode=edit"><i class="fa fa-pencil"></i> Edit</a>
<? } ?>
</div>

<div class="clearfix"></div>


<div class="col-lg-1"></div>
<div class="col-lg-10">
<div class="write_reply">
	<div class="maintitle floated dropped">
		<h3><i class="fa fa-comments"></i> Write reply </h3>
	</div>
	<form class="maincontent bootstrap-validator-form" action="?do=reply" id="treply">
		<div style="padding:10px 0">
			<textarea style="height:200px" name="content"></textarea>
			<div class="add-form-submit center" style="margin-top:10px">
				<input type="reset" value="Reset" class="btn btn-default">
				<input type="submit" value="Submit" class="btn btn-success">
			</div>
		</div>
	</form>
</div>
</div>
<div class="col-lg-1"></div>
<div class="clearfix"></div>

<style>
.linenums li{position:relative;border-left:3px solid #EBEFF9;padding:0 0 4px 5px;line-height:20px}
ol.linenums li:hover{background:#EBEFF9}
.linenums{margin:0}
.code_content pre{max-height:300px;overflow:auto}
</style>
