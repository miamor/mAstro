<div class="ol-thead">
	<div class="lasttopic-title col-lg-6 no-padding-right">Title</div>
	<div class="col-lg-1 center">Views</div>
	<div class="col-lg-1 center">Replies</div>
	<div class="col-lg-2 no-padding-right">Forum</div>
	<div class="col-lg-2 no-padding-right" style="text-align:right">Last post by</div>
	<div class="clearfix"></div>
</div>
<ol class="olList group_poster">
<? foreach ($topicsAr as $tO) { ?>
<li>
	<div class="lasttopic-title col-lg-6 no-padding-right">
		<a title="Last post: <? echo $tO['last_post'] ?>" href="<? echo $tO['link'] ?>"><? echo $tO['title'] ?></a>
		<div class="tooltip_data" style="display:none">
			<p><span style="color:red">Tiêu đề</span>: <? echo $tO['title'] ?></p>
			<p><span style="color:blue">Gửi lúc</span>: <? echo $tO['created'] ?></p>
		</div>
	</div>
	<div class="col-lg-1 center">
		<? echo $tO['views'] ?>
	</div>
	<div class="col-lg-1 center">
		<? echo $tO['replies'] ?>
	</div>
	<div class="col-lg-2 no-padding-right">
		<a href="<? echo $tO['cat']['link'] ?>"><? echo $tO['cat']['title'] ?></a>
	</div>
	<div class="col-lg-2 no-padding-right" style="text-align:right">
		<a href="<? echo $tO['lastpost']['author']['link'] ?>"><? echo $tO['lastpost']['author']['name'] ?></a>
	</div>
	<div class="clearfix"></div>
</li>
<? } ?>
</ol>
