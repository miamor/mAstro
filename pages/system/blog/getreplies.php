<? header('Content-Type: application/json');

$topic->getRep();
$repList = $topic->repList;
$ar = array('data' => '');

foreach ($repList as $rK => $rO) {
	$rK += 2; extract($rO);
	$ar['data'][] = array(
			'<div class="thead"><a class="hidden" href="'. $author['link'] .'">'.$author['name'].'</a></div>
			<a title="'.$author['name'].'" href="'. $author['link'] .'" class="postprofile-avatar" data-online="'. $author['online'] .'"><img class="avatar" src="'.$author['avatar'].'"></a>',
			'<div id="postmain" valign="top" id="'.$rK.'">
					<div class="thead">
						<div class="time left"><span class="fa fa-clock-o"></span> '.$created.'</div>
						<div class="post-count right"><a href="#'.$rK.'">#'.$rK.'</a></div>
						<div class="clearfix"></div>
					</div>
					<div class="post-entry">
						<div class="post-content">'.$content.'</div>
						<div class="post-foot">
							<div class="right">
								<a class="post-btn" href="#quote" id="r'. $id .'"><i class="fa fa-quote-left"></i> Quote</a>
								<a class="post-btn" href="#report" id="r'. $id .'"><i class="fa fa-exclamation"></i> Report</a>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>',
			'p'.$rK
			);
}
echo json_encode($ar);
