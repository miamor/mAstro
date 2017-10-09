<? 	$report->voteAr = array('like' => $pLikesAr, 'dislike' => $pDislikesAr);
	$report->vote('like');
/*if (!in_array($u, $pLikesAr)) $chart->vote('like');
else $chart->vote('like', -1);
*/
