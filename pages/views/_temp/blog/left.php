<? $stmt = $forum->readAll();
$forumsList = $forum->forumsList;
$num = $stmt->rowCount();
foreach ($forumsList[0] as $fOne) { ?>
	<li class="left-menu-one <? if ($f == $fOne['slink']) echo 'active' ?>">
		<span class="right label label-<? if ($fOne['topics'] > 0) echo 'info'; else echo 'default' ?>"><? echo $fOne['topics'] ?></span>
		<a title="<? echo $fOne['title'] ?>" href="<? echo $fOne['link'] ?>">
			<span class="txt"><? echo $fOne['title'] ?></span>
		</a>
		<ul class="childForums">
<? foreach ($forumsList[$fOne['id']] as $fO) {
	extract($fO) ?>
			<li class="left-menu-one child <? if ($f == $slink) echo 'active' ?>">
				<span class="right label label-<? if ($topics > 0) echo 'info'; else echo 'default' ?>"><? echo $topics ?></span>
				<a title="<? echo $title ?>" href="<? echo $link ?>">
					<span class="txt"><? echo $title ?></span>
				</a>
			</li>
<? } ?>
		</ul>
	</li>
<? } ?>
