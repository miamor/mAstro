<div class="topics-list col-lg-9">
<h2 class="left col-lg-8" style="margin:0 0 20px"><? echo $fInfo['title'] ?></h2>
<? if ($config->me['is_mod'] == 1) { ?>
<div class="right t-btns col-lg-4">
	<a class="btn btn-default pull-right" href="?mode=new"><i class="fa fa-plus"></i> New topic</a>
</div>
<? } ?>
<div class="clearfix"></div>


<? if ($topicTop) { ?>

<div class="main-featured">
	<div class="rows appear">
		<? $tO = $topicTop; ?>
		<div class="blocks col-lg-7">
			<article class="xlarge">
				<!--<span class="cat cat-title cat-515"><a href="http://lovedia.vn/category/du-bao-tuong-lai">Dự báo tương lai 12 cung hoàng đạo</a></span>-->
				<a href="<? echo $tO['link'] ?>" class="image-link"><img src="<? echo $tO['thumb'] ?>" class="wp-post-image" alt="<? echo $tO['title'] ?>" title="<? echo $tO['title'] ?>"></a>
				<h3><a href="<? echo $tO['link'] ?>" title="<? echo $tO['title'] ?>"><? echo $tO['title'] ?></a></h3>
			</article>
		</div>
		

		<div class="blocks col-lg-5 no-padding">
<? foreach ($topicsListTop as $tK => $tO) { ?>
			<article class="<? if ($tK == 0) echo 'large'; else echo 'small col-lg-6' ?> no-padding">
				<!--<span class="cat cat-title cat-515"><a href="http://lovedia.vn/category/du-bao-tuong-lai">Dự báo tương lai 12 cung hoàng đạo</a></span>-->
				<a href="<? echo $tO['link'] ?>" class="image-link"><img src="<? echo $tO['thumb'] ?>" class="wp-post-image" alt="<? echo $tO['title'] ?>" title="<? echo $tO['title'] ?>"></a>
				<h3><a href="<? echo $tO['link'] ?>" title="<? echo $tO['title'] ?>"><? echo $tO['title'] ?></a></h3>
			</article>

<? } ?>
		</div>
		<div class="clearfix"></div>
	</div>

<div class="clearfix"></div>

<div class="col-lg-12 blocks tbmargin no-padding">
	<table cellspacing="0" cellpadding="0" class="maincontent rows appear no-border ipbtable topic-list-box topics">
		<thead class="hidden">
			<tr>
				<th class="forum2">Topics</th>
			</tr>
		</thead>
		<tbody>
<? if (count($topicsList) > 0) {
	foreach ($topicsList as $tO) { ?>
			<tr valign="top">
				<td class="row2 topic-title">
					<article class="high">
					<a href="<? echo $tO['link'] ?>" class="image-link"><img src="<? echo $tO['thumb'] ?>" class="wp-post-image" alt="<? echo $tO['title'] ?>" title="<? echo $tO['title'] ?>"></a>
					<h3 class="topictitle">
						<a class="atopictitle" href="<? echo $tO['link'] ?>" title="<? echo $tO['title'] ?>"><? echo $tO['title'] ?></a>
					</h3>
					<div class="topic-caption">
						<div class="topic-stat">
							<div class="left">
								<span class="topic4r stat4r"><i class="fa fa-clock-o" title="<? echo $tO['created'] ?>"></i></span>
								<span class="topic4r stat4r"> Author: <a href="<? echo $tO['author']['link'] ?>"><strong><? echo $tO['author']['name'] ?></strong></a></span>
							</div>
							<div class="right">
								<span class="post4r stat4r"><i class="fa fa-eye"></i> <strong><? echo $tO['views'] ?></strong></span>
								<span class="post4r stat4r" style="margin-left:10px"><i class="fa fa-comments-o"></i> <strong><? echo $tO['replies'] ?></strong></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="topic-info">
							<div class="preview">
								<div class="cut"><? echo $tO['content'] ?>...</div>
							</div>
						</div>
					</div>
					</article>
				</td>
			</tr>
<? 	}
} ?>
		</tbody>
	</table>
</div>

<div class="clearfix"></div>

</div> <!-- .main-featured -->

<? } ?>
</div>

<div class="topics-sidebar col-lg-3">
</div>