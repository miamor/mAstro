<? $pLikesAr = explode(',', $dIn['likes']);
if ($dIn['likes']) $pLikes = count($pLikesAr);
else $pLikes = 0;

echo json_encode($pLikesAr) ?>
