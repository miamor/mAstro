<div class="right t-btns">
	<a class="btn btn-default pull-right" href="?f=<? echo $f ?>&mode=new"><i class="fa fa-plus"></i> New topic</a>
</div>
<div class="clearfix"></div>

<div class="borderwrap">
	<div class="maintitle floated dropped">
		<h3>Thông báo </h3>
	</div>
	<div class="maincontent sticky">
	<table cellspacing="0" cellpadding="0" class="ipbtable topic-list-box">
		<thead>
			<tr>
				<th class="icon"></th>
				<th class="forum2">Announcement & Sticky</th>
				<th class="last last-post2">Last Posts</th>
			</tr>
		</thead>
		<tbody>
<? foreach ($topicsList[0] as $tO) { ?>
			<tr>
				<td class="row2 centered">
					<div style="background-image:url(http://i56.servimg.com/u/f56/18/59/49/93/th/lg110.png);" class="topicthumbnail"></div>
				</td>
				<td class="row2 topic-title" data-type="Announcement:">
					<img class="icon-status" title="No new posts" src="http://i39.servimg.com/u/f39/18/59/49/93/13653312.png" alt="No new posts"> <a class="topictitle" href="<? echo $tO['link'] ?>" title="<? echo $tO['title'] ?>"><? echo $tO['title'] ?></a> 
					<div class="topic-stat">
						<img src="http://i39.servimg.com/u/f39/18/59/49/93/file-210.png" alt="topic" title="topic"> 
						<span class="topic4r stat4r">Tác giả: <a href="<? echo $tO['author']['link'] ?>"><strong><? echo $tO['author']['name'] ?></strong></a></span>
						<span class="topic4r stat4r">Gửi lúc: <? echo $tO['created'] ?></span>
						<span class="post4r stat4r">Trả lời: <strong><? echo $tO['replies'] ?></strong></span>
						<span class="post4r stat4r">Lượt xem: <strong><? echo $tO['views'] ?></strong></span>
					</div>
				</td>
				<td class="row1 lastaction">
					<span class="lastpost-avatar">
						<img src="<? echo $tO['lastpost']['author']['avatar'] ?>" alt="">
					</span>
					<div class="stat4r">
						on <? echo $tO['lastpost']['created'] ?><br><a href="<? echo $tO['lastpost']['author']['link'] ?>" class="gensmall"><strong><? echo $tO['lastpost']['author']['name'] ?></strong></a>
						<a href="<? echo $tO['link'].'#'.$tO['posts'] ?>"><img src="http://i39.servimg.com/u/f39/18/59/49/93/2014-011.png" alt="View latest post" title="View latest post"></a>
					</div>
				</td>
			</tr>
<? } ?>
		</tbody>
	</table>
	</div>
</div>

<div class="borderwrap tbmargin">
	<div class="maintitle">
		<h2>Topics</h2>
	</div>
	<table cellspacing="0" cellpadding="0" class="maincontent ipbtable topic-list-box topics">
		<thead>
			<tr>
				<th class="icon"></th>
				<th class="forum2">Topics</th>
				<th class="last last-post2">Last Posts</th>
			</tr>
		</thead>
		<tbody>
<? foreach ($topicsList[1] as $tO) { ?>
			<tr>
				<td class="row2 centered">
					<div style="background-image:url(http://i78.servimg.com/u/f78/17/70/81/78/inet-n10.jpg);" class="topicthumbnail"></div>
				</td>
				<td class="row2 topic-title">
					<img class="icon-status" title="No new posts" src="http://i39.servimg.com/u/f39/18/59/49/93/13653310.png" alt="No new posts">
					<a class="topictitle" href="<? echo $tO['link'] ?>" title="<? echo $tO['title'] ?>"><? echo $tO['title'] ?></a> 
					<div class="topic-stat">
						<img src="http://i39.servimg.com/u/f39/18/59/49/93/file-210.png" alt="topic" title="topic"> 
						<span class="topic4r stat4r">Tác giả: <a href="<? echo $tO['author']['link'] ?>"><strong><? echo $tO['author']['name'] ?></strong></a></span>
						<span class="topic4r stat4r">Gửi lúc: <? echo $tO['created'] ?></span>
						<span class="post4r stat4r">Trả lời: <strong><? echo $tO['replies'] ?></strong></span>
						<span class="post4r stat4r">Lượt xem: <strong><? echo $tO['views'] ?></strong></span>
					</div>
				</td>
				<td class="row1 lastaction">
					<span class="lastpost-avatar">
						<img src="<? echo $tO['lastpost']['author']['avatar'] ?>" alt="">
					</span>
					<div class="stat4r">
						on <? echo $tO['lastpost']['created'] ?><br><a href="<? echo $tO['lastpost']['author']['link'] ?>" class="gensmall"><strong><? echo $tO['lastpost']['author']['name'] ?></strong></a>
						<a href="<? echo $tO['link'].'#'.$tO['posts'] ?>"><img src="http://i39.servimg.com/u/f39/18/59/49/93/2014-011.png" alt="View latest post" title="View latest post"></a>
					</div>
				</td>
			</tr>
<? } ?>
		</tbody>
	</table>
</div>
