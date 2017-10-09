<? $pDislikesAr = explode(',', $dIn['dislikes']);
if ($dIn['dislikes']) $pDislikes = count($pDislikesAr);
else $pDislikes = 0;

echo json_encode($pDislikesAr) ?>
