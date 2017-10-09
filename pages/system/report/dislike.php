<? 	$report->voteAr = array('like' => $pLikesAr, 'dislike' => $pDislikesAr);
	$report->vote('dislike');
/*if (in_array($u, $pLikesAr)) rmFromCol('data', 'id', $iid, 'likes');
if (!in_array($u, $pDislikesAr)) pushToCol('data', 'id', $iid, 'dislikes');
else rmFromCol('data', 'id', $iid, 'dislikes');
