<? $config->addJS('dist', 'blog/forum.js');
$tabs = array (
	'all' => 'Tất cả chủ đề',
	'c' => 'Lập trình C/C++',
	'java' => 'Lập trình Java',
	'php' => 'Lập trình Php',
	'ebook' => 'Tài liệu, ebook',
	'network' => 'Mạng máy tính',
	'source' => 'Dự án, source code',
) ?>
<div class="borderwrap last_topic">
	<div class="maintitle floated clearfix">
		<h2>THỐNG KÊ BÀI VIẾT</h2>
		<div class="contract" id="bcstat" onclick="toggleCategory('cstat');"> </div>
	</div>
	<div class="maincontent" id="cstat">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs h">
			<? foreach ($tabs as $k => $tO) { ?>
				<li <? if ($k == 'all') echo 'class="active"' ?>><a href="#<? echo $k ?>" data-toggle="tab" aria-expanded="false"><? echo $tO ?></a></li>
			<? } ?>
			</ul>
			<div class="tab-content">
				<div class="ol-thead">
					<div class="lasttopic-title col-lg-6 no-padding-right">Title</div>
					<div class="col-lg-1 center">Views</div>
					<div class="col-lg-1 center">Replies</div>
					<div class="col-lg-2 no-padding-right">Forum</div>
					<div class="col-lg-2 no-padding-right" style="text-align:right">Last post by</div>
					<div class="clearfix"></div>
				</div>
			<? foreach ($tabs as $k => $tO) { ?>
				<div class="tab-pane<? if ($k == 'all') echo ' active' ?> box-content topicsLast_div" id="<? echo $k ?>">
					
				</div>
			<? } ?>
				<!-- /.tab-pane -->
			</div>
			<!-- /.tab-content -->
		</div>
	</div>
</div>

<div class="col-lg-9 no-padding">
<? foreach ($forumsList[0] as $fOne) { ?>
<div class="borderwrap">
	<div class="maintitle floated clearfix">
		<h2><a href="<? echo $fOne['link'] ?>"><? echo $fOne['title'] ?></a></h2>
		<div class="contract" id="bc<? echo $fOne['id'] ?>" onclick="toggleCategory('c<? echo $fOne['id'] ?>');"> </div>
	</div>
	<div class="maincontent" id="c<? echo $fOne['id'] ?>">
		<table cellpadding="0" cellspacing="0" class="ipbtable index-box">
			<thead>
				<tr>
					<th class="statusIcon"> </th>
					<th class="forum">Forum</th>
					<th class="tc2"></th>
					<th class="tc3"></th>
					<th class="last post-info">Last Posts</th>
				</tr>
			</thead>
			<tbody>
<? foreach ($forumsList[$fOne['id']] as $fO) {
	extract($fO) ?>
				<tr data-id="<? echo $id ?>" class="childForum zzBox_<? echo $id ?>">
					<td class="centered"><span class="status"><img title="No new posts" src="<? echo $icon ?>" alt="No new posts" class="icon"></span></td>
					<td class="row2 icon">
						<!--<span class="statuss">
							<img title="No new posts" src="<? echo IMG ?>/no-new-posts.png" alt="No new posts">
						</span>-->
						<div class="par forum-name">
							<h3 class="hierarchy"><a href="<? echo $link ?>" class="forumtitle"><? echo $title ?></a></h3>
							<p class="forum-desc"><? echo $content ?></p>
						</div>
						<div class="subforums">
						<? foreach ($forumsList[$id] as $fsO) { ?>
							<div class="subforum2">
								<img class="inlineimg left" style="margin:2px 5px 0 0" src="<? echo IMG ?>/subforum_new.png" style="cursor: pointer;"> 
								<a href="<? echo $fsO['link'] ?>"><? echo $fsO['title'] ?></a>
							</div>
						<? } ?>
						</div>
						<!--<div class="forum-stat">
							<span class="topic4r stat4r">Chủ đề: <strong><? echo $topics ?></strong></span>
							<span class="post4r stat4r">Bài viết: <strong><? echo $posts ?></strong></span>
						</div>-->
					</td>
					<td width="8%" class="tc2 centered"><b><? echo $topics ?></b><div style="font-size:11px">threads</div></td>
					<td width="8%" class="tc3 centered"><b><? echo $posts ?></b><div style="font-size:11px">posts</div></td>
					<td class="row1" style="width:30%;padding-left:20px">
					<? if ($lastpost) { ?>
						<span class="lastpost-avatar"><img src="<? echo $lastpost['author']['avatar'] ?>" alt=""></span>
						<span class="stat4r">
							<a class="last-post-link" href="<? echo $lastpost['tIn']['link'] ?>" title="<? echo $lastpost['tIn']['title'] ?>"><? echo $lastpost['tIn']['title'] ?></a>
							<div class="stat-time"><? echo $lastpost['created'] ?></div>
							<a href="<? echo $lastpost['author']['link'] ?>"><? echo $lastpost['author']['name'] ?></a>
							<a href="<? echo $lastpost['link'] ?>" class="last-post-icon"><img src="<? echo IMG ?>/lastpost1.png" alt="View latest post" title="View latest post"></a>
						</span>
					<? } ?>
					</td>
				</tr>
<? } ?>
			</tbody>
		</table>
	</div>
</div>
<? } ?>
</div>

<div class="col-lg-3">

	<div class="borderwrap">
		<div class="maintitle floated clearfix">
			<h2><i class="fa fa-comments"></i> Most active topics</h2>
			<div class="contract" id="bmr" onclick="toggleCategory('mr');"> </div>
		</div>
		<div class="maincontent" id="mr">
			<div class="tab-pane box-content" style="padding:6px 10px" id="replied">
<ol class="olList group_poster">
<? foreach ($activeTopic as $tO) { ?>
<li>
	<div class="lasttopic-title">
		<a title="<? echo $tO['views'] ?> views" href="<? echo $tO['link'] ?>"><? echo $tO['title'] ?></a>
		<div class="tooltip_data" style="display:none">
			<p><span style="color:red">Tiêu đề</span>: <? echo $tO['title'] ?></p>
			<p><span style="color:blue">Gửi lúc</span>: <? echo $tO['created'] ?></p>
		</div>
	</div>
	<div class="clearfix"></div>
</li>
<? } ?>
</ol>
			</div>
		</div>
	</div>

	<div class="borderwrap">
		<div class="maintitle floated clearfix">
			<h2><i class="fa fa-eye"></i> Most viewed</h2>
			<div class="contract" id="bmv" onclick="toggleCategory('mv');"> </div>
		</div>
		<div class="maincontent" id="mv">
			<div class="tab-pane box-content" style="padding:6px 10px" id="view">
<ol class="olList group_poster">
<? foreach ($viewsTopic as $tO) { ?>
<li>
	<div class="lasttopic-title">
		<a title="<? echo $tO['views'] ?> views" href="<? echo $tO['link'] ?>"><? echo $tO['title'] ?></a>
		<div class="tooltip_data" style="display:none">
			<p><span style="color:red">Tiêu đề</span>: <? echo $tO['title'] ?></p>
			<p><span style="color:blue">Gửi lúc</span>: <? echo $tO['created'] ?></p>
		</div>
	</div>
	<div class="clearfix"></div>
</li>
<? } ?>
</ol>
			</div>
		</div>
	</div>

	<div class="borderwrap">
		<div class="maintitle floated clearfix">
			<h2>Advertisement</h2>
			<div class="contract" id="bad" onclick="toggleCategory('ad');"> </div>
		</div>
		<div class="maincontent" id="ad">
			
		</div>
	</div>
</div>

<div class="clearfix"></div>
