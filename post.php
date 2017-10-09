<? include 'include/config.php';

include 'include/html_dom.php';
/*
	// connect to database
	$host = "localhost";
	$db_name = "astro";
	$username = "root";
	$password = "";
	$mysqli = new mysqli($host, $username, $password, $db_name);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
	$mysqli->set_charset("utf8");

// start crawling
$urlAr = array(
	'http://astromatrix.org/Category/Sun-Planet-Aspects/',
//	'http://astromatrix.org/Category/Moon-Planet-Aspects/',
//	'http://astromatrix.org/Category/Mercury-Planet-Aspects/',
//	'http://astromatrix.org/Category/Venus-Planet-Aspects/',
//	'http://astromatrix.org/Category/Mars-Planet-Aspects/',
//	'http://astromatrix.org/Category/Jupiter-Planet-Aspects/',
//	'http://astromatrix.org/Category/Saturn-Planet-Aspects/',
//	'http://astromatrix.org/Category/Uranus-Planet-Aspects/',
//	'http://astromatrix.org/Category/Neptune-Planet-Aspects/',
//	'http://astromatrix.org/Category/Pluto-Planet-Aspects/',
//	'http://astromatrix.org/Category/Ascendant-Planet-Aspects/',
//	'http://astromatrix.org/Category/Midheaven-Planet-Aspects/',
);
foreach ($urlAr as $urls) {
		$uAr = $tAr = array();
		$html = new simple_html_dom();
		$html->load_file($urls);
		foreach ($html->find('.categoryBlock') as $div) {
			foreach ($div->find('a') as $a) {
				$txt = $a->plaintext;
					$uAr[] = $a->href;
					$tAr[] = $txt;
			}
		}
		$html->clear(); 
		unset($html);
		foreach ($uAr as $k => $url) {
			$tit = $tAr[$k];
			echo "<h2>{$tit}</h2>";
			$code = trendCode($tit);
			echo "<b>$code</b><br/>";
			$content = "";
			$html = new simple_html_dom();
			$html->load_file($url);
		foreach ($html->find('.item') as $div) {
			foreach ($div->find('span') as $span) {
				$content = $span->plaintext;
				$cAr = preg_split("/{$tit}/", $content);
				$content = $cAr[1];
				$content = str_replace(array("'", '"'), array("\'", "\'"), $content);
				echo $content;
				echo "<hr/>";
				// write to database
				$select = $mysqli->query("SELECT `id` FROM `data` WHERE `sid` = '7' AND `lang` = 'us' AND `code` = 'moon-sesquiqueadrate-midheaven' LIMIT 0,1");
				if ($select->num_rows < 1 && $content != 'Planet Aspects/')
					$mysqli->query("INSERT INTO `data` (`sid`, `lang`, `code`, `content`) VALUES ('7', 'us', '{$code}', '{$content}') ");
			}
			// reset
			$html->clear(); 
			unset($html);
		}
	}
}

/*
function Find_Specific ($p1, $p2, $cont) {
	$string = "";
	$len = strlen($p1);

	//put entire file contents into an array, line by line
	$ar = array_filter(explode('<br/>', $cont));
	$ar = array_values($ar);
	$file_array = $ar;
//	print_r($ar);
	$k = 0;
	foreach ($ar as $i => $v) {
		if ($v == $p1) $k = $i;
	}
	for ($j = 0; $j <= $k; $j++) unset($ar[$j]);
//	array_splice($ar, 2, 1);
//	print_r($ar);
//	$p2 = '<b>1. Cung Mọc Ma Kết và Mặt trời Bạch Dương</b>';
//	echo $p2;
	foreach ($ar as $i => $v) {
//		echo $v.'~~~<hr/>';
		if (!$p2 || $v != $p2) $string .= $ar[$i].'<br/>';
		else break;
	}

	// look through each line searching for $phrase_to_look_for
//	for ($i = 0; $i < count($file_array); $i++) {
//		if ($file_array[$i - 1] == $p1) {
//			while ($file_array[$i] != $p2) $string .= $file_array[$i].'<br/>';
//			while ($file_array[$i] != $p2) {
//				$string .= $file_array[$i].'<br/>';
//				$i++;
//			}
//			break;
//		}
//	}
	return $string;
}

// start crawling
$planetAr = array('Neptune', 'Lilith', 'Mars', 'Jupiter');
foreach ($planetAr as $planet) {
//	$planet = 'Moon';
	$urlAr = array(
		'http://freespiritedmind.com/blog/?s='.trendCode($planet),
		'http://freespiritedmind.com/blog/page/2/?s='.trendCode($planet)
	);
	foreach ($urlAr as $url) {
		$uAr = $tAr = array();
	//	$url = 'http://freespiritedmind.com/blog/?s='.trendCode($planet);
		$html = new simple_html_dom();
		$html->load_file($url);
		foreach ($html->find('h2.post-title') as $div) {
			foreach ($div->find('a') as $a) {
				$txt = $a->plaintext;
				if (substr_count($txt, 'House') && substr_count($txt, $planet)) {
					$uAr[] = $a->href;
					$tAr[] = $txt;
				}
			}
		}
		$html->clear(); 
		unset($html);

		foreach ($uAr as $k => $url) {
			$tit = $tAr[$k];
			echo "<h2>{$tit}</h2>";
		//	$hcode = preg_split("/IN THE (.*) HOUSE/", $tit);
		//	print_r($hcode);
			$hcode = explode(" House", explode("in the ", $tit)[1])[0];
			$code = trendCode($planet)."-in-{$hcode}-house";
			echo "<b>$code</b><br/>";
			$content = "";
			$html = new simple_html_dom();
			$html->load_file($url);
			foreach ($html->find('.post-content') as $div) {
				$content = $div->plaintext;
				echo $content;
				echo "<hr/>";
				// write to database
			//	$content = content($content);
				$mysqli->query("INSERT INTO `data` (`sid`, `lang`, `code`, `content`) VALUES ('5', 'us', '{$code}', '{$content}') ");
			}
			// reset
			$html->clear(); 
			unset($html);
		}
	}
}
/*
$signAr = array('ARIES', 'TAURUS', 'GEMINI', 'CANCER', 'LEO', 'VIRGO', 'LIBRA', 'SCORPIO', 'SAGITTARIUS', 'CAPRICORN', 'AQUARIUS', 'PISCES');
$planetAr = array('Sun', 'Jupiter', 'Moon', 'Venus', 'Mercury', 'Mars', 'Saturn', 'Pluto', 'Uranus', 'Neptune');
$houseAr = array('1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th');
$aspectAr = array('blending with', 'harmonizing with', 'discordant to');
$asAr = array('Conjunct', 'Opposite', 'Sextile', 'Square', 'Trine');
$nAr = array('ISTJ', 'ISTP', 'ESTP', 'ESTJ', 'ISFP', 'ESFP', 'ESFJ', 'INFJ', 'INFP', 'ENFP', 'ENFJ', 'INTJ', 'ISFJ', 'INTP', 'ENTP', 'ENTJ');
$codeAr = array('job', 'relationship', 'famous');

/*
foreach ($llA as $i => $ll) {
	$lAr = preg_split('/(n|s|e|w)/', $ll);
	$deg = $lAr[0];
	$min = $lAr[1];
	preg_match('/(n|s|e|w)/', $ll, $m);
	$txt = $m[0];
	if ($i == 0) $k = 'lat';
	else $k = 'long';
	$lnglat[$k] = array('deg' => $deg, 'min' => $min, 'txt' => $txt);
}
print_r($lnglat);

/*
$base = 'https://zoroscopes.wordpress.com/sach-d%e1%bb%8bch/love-signs/';

$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_URL, $base);
curl_setopt($curl, CURLOPT_REFERER, $base);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$str = curl_exec($curl);
curl_close($curl);

$html_base = new simple_html_dom();
$html_base->load($str);

//get all category links
foreach ($html_base->find('.entry-content') as $div) {
	foreach ($div->find('li') as $li) {
		$txt = $li->plaintext;
		$txt = mb_substr($txt, 0, -6);
		foreach ($li->find('a') as $a) {
			$urlAr[$txt] = $a->href;
			$uAr[] = $a->href;
			$tAr[] = $txt;
		}
	}
}
$html_base->clear(); 
unset($html_base);

for ($k = 142; $k <= 178; $k+=2) {
//	$code = mb_substr($txt, 23);
//	$code = 'love-'.strtolower($signAr[$i-1]);
	$iB = $k;
	if ($iB == 49) $iE = $iB;
	else if ($iB == 101 || $iB == 139 || $iB == 156 || $iB == 173) $iE = $iB + 2;
	else $iE = $iB + 1;
	if ($iB == 142) $code = 'love-f-scorpio-m-sagittarius';
	if ($iB == 144) $code = 'love-m-scorpio-f-sagittarius';
	if ($iB == 146) $code = 'love-f-scorpio-m-capricorn';
	if ($iB == 148) $code = 'love-m-scorpio-f-capricorn';
	if ($iB == 150) $code = 'love-f-scorpio-m-aquarius';
	if ($iB == 152) $code = 'love-m-scorpio-f-aquarius';
	if ($iB == 154) $code = 'love-m-scorpio-f-pisces';
	if ($iB == 156) $code = 'love-f-sagittarius-m-sagittarius';
	if ($iB == 159) $code = 'love-f-sagittarius-m-capricorn';
	if ($iB == 161) $code = 'love-m-sagittarius-f-capricorn';
	if ($iB == 163) $code = 'love-m-sagittarius-f-aquarius';
	if ($iB == 165) $code = 'love-m-sagittarius-f-pisces';
	if ($iB == 167) $code = 'love-f-capricorn-m-capricorn';
	if ($iB == 169) $code = 'love-f-capricorn-m-aquarius';
	if ($iB == 171) $code = 'love-m-capricorn-f-aquarius';
	if ($iB == 173) $code = 'love-m-capricorn-f-pisces';
	if ($iB == 176) $code = 'love-f-aquarius-m-aquarius';
	if ($iB == 178) $code = 'love-m-aquarius-f-pisces';
for ($i = $iB; $i <= $iE; $i++) {
	$url = $uAr[$i];
	$txt = $tAr[$i];
	if ($i == $iE) echo '<hr/>'.$txt.'~~~~'.$url.'<br/><br/>';
	if ($i == $iB) $content = '';
	$strongAr = $quoteAr = array();

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_REFERER, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	$str = curl_exec($curl);
	curl_close($curl);

	$html = new simple_html_dom();
	$html->load($str);

	$p_1 = 'Đọc Nội quy trước khi đọc tại ĐÂY.';
	$p_2 = 'Đọc Nội quy trước khi đọc ở ĐÂY.';
	$p_3 = 'Vui lòng đọc Hướng dẫn trước khi đọc tạiĐÂY.';
	$p_4 = 'Cách tính cung dựa trên quyển LOVE SIGNS của Linda Goodman.';
	$p_5 = 'Trích dịch từ quyển LOVE SIGNS của Linda Goodman. Những đại từ “tôi” trong bài ý chỉ tác gia Linda Goodman, không phải người dịch.';
	$p_6 = 'Cách tính cung như trên dựa vào quyển LOVE SIGNS của Linda Goodman.';
	$p_7 = 'Còn tiếp…';
	$invalid = array($p_1, $p_2, $p_3, $p_4, $p_5, $p_6, $p_7);
	foreach ($html->find('.entry-thumbnail') as $thumb) $thumbAr[] = $thumb->src;
	foreach ($html->find('.entry-content') as $div) {
		foreach ($div->find('blockquote') as $quote) {
			$pQ = '';
			foreach ($quote->find('p[style="text-align:justify;"]') as $p) $pQ .= $p->plaintext.'<br/>';
			$pQ = htmlentities($pQ, null, 'utf-8');
			$pQ = str_replace("&nbsp;", "", $pQ);
			$pQ = html_entity_decode($pQ);
			$pQ = preg_replace('/\s+/', ' ', $pQ);
			$quoteAr[] = $pQ;
		}
		foreach ($div->find('p[style="text-align:justify;"]') as $p) {
			$pCont = $p->plaintext;
			foreach ($p->find('strong') as $strong) 
				$strongAr[] = $strong->plaintext;
			if (!in_array($pCont, $invalid)) 
				$content .= $pCont.'<br/>';
		}
	}
	foreach ($invalid as $in) $content = str_replace($in, "", $content);
	$content = htmlentities($content, null, 'utf-8');
	$content = str_replace("&nbsp;", "", $content);
//	$content = preg_replace('/&nbsp;|Trích dịch từ quyển LOVE SIGNS của Linda Goodman. Những đại từ “tôi” trong bài ý chỉ tác gia Linda Goodman, không phải người dịch./', ' ', $content);
	$content = html_entity_decode($content);
	$content = preg_replace('/\s+/', ' ', $content);
	foreach ($strongAr as $strong) $content = str_replace($strong.'<br/>', '<b>'.$strong.'</b><br/>', $content);
	foreach ($quoteAr as $quote) $content = str_replace($quote, '<blockquote>'.$quote.'</blockquote>', $content);
//	if ($i == 1) $p1 = 'Đọc Nội quy trước khi đọc ở ĐÂY.';
//	else $p1 = 'Cách tính cung dựa trên quyển LOVE SIGNS của Linda Goodman.';
//	$p1 = 'Vui lòng đọc Hướng dẫn trước khi đọc tạiĐÂY.';
	if (check($content, $p_1) > 0) $p1 = $p_1;
	if (check($content, $p_2) > 0) $p1 = $p_2;
	if (check($content, $p_3) > 0) $p1 = $p_3;
	if (check($content, $p_4) > 0) $p1 = $p_4;
//	$content = Find_Specific($p1, '', $content);
	$cont = $content;
	$codee = trendCode($code);
	$cou = countRecord('data', "`code` = '{$codee}' AND `lang` = 'vn' ");
	if ($i == $iE && $cont) {
		echo $codee.' - '.$cou.'<br/>';
		echo $cont.'<hr/>';
		if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `sid`, `time`", " '{$codee}', 'vn', '{$cont}', 4, '{$current}' ");
		else changeValue('data', "`code` = '{$codee}' AND `lang` = 'vn' ", "`content` = '{$cont}' ");
	}

	$html->clear(); 
	unset($html);
}

}


/*
$url = 'http://forum.matngu12chomsao.com/threads/leo-qua-cac-ngay-sinh-full-tu-ngay-12-update-page-3-4.9655/';
$content = '';
$strongAr = $quoteAr = array();
$html = new simple_html_dom();
$html->load_file($url);
$day = 23;
$month = 7;
foreach ($html->find('blockquote.messageText') as $quote) {
	foreach ($quote->find('img.LbImage') as $img) {
		$img = $img->src;
		$cont = '<img src="'.$img.'"/>';
		$d = "{$day}";
		$m = "{$month}";
		if ($day < 10) $d = '0'.$day;
		if ($month < 10) $m = '0'.$month;
		$dm = $d.$m;
		$code = $dm;
		$codee = trendCode($code);
		$cou = countRecord('data', "`code` = '{$codee}' AND `lang` = 'vn' ");
		if ($cont) {
			echo $codee.' - '.$cou.'<br/>';
			echo $cont.'<hr/>';
			if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'vn', '{$cont}', '{$current}' ");
			else changeValue('data', "`code` = '{$codee}' AND `lang` = 'vn' ", "`content` = '{$cont}' ");
		}
		if ($day == 31) $day = 1;
		else $day++;
	}
}


/*
$house = 0;
$urlAr = array(
//* With houses
//	'sun' => 'mat-troi-trong-cac-nha-ban-se-toa-sang-o-dau-p', // Done
//	'moon' => 'http://lovedia.vn/di-tim-ben-do-tam-hon-cua-ban-qua-vi-tri-cua-mat-trang-trong-nha-p', // Done
//	'mercury' => 'sao-thuy-hanh-tinh-cua-tu-duy-va-giao-tiep-ki-3' // Done
//	'venus' => 'sao-kim-hanh-tinh-cua-ve-dep-va-tinh-yeu-ki-3' // Done
//	'jupiter' => 'sao-moc-ngoi-sao-cua-su-may-man-va-lac-quan-ki-3' // Done
//* With signs
//	'mercury' => 'sao-thuy-hanh-tinh-cua-tu-duy-va-giao-tiep-ki-' // Done
//	'venus' => 'sao-kim-hanh-tinh-cua-ve-dep-va-tinh-yeu-ki-' // Done
//	'jupiter' => 'sao-moc-ngoi-sao-cua-su-may-man-va-lac-quan-ki-' // Done
	'mars' => 'sao-hoa-hanh-tinh-do-dam-me-phan-' // Done
);
if ($house == 1) $partAr = array('sun', 'moon');
else $partAr = array('mercury', 'venus', 'jupiter', 'mars');
$planet = '';
foreach ($urlAr as $uK => $urlCode) {
	if (in_array($uK, $partAr)) $uAr = array('http://lovedia.vn/'.$urlCode.'1.html', 'http://lovedia.vn/'.$urlCode.'2.html');
	else $uAr = array('http://lovedia.vn/'.$urlCode.'.html');
	$planet = $uK;
}
$content = '';
$strongAr = $quoteAr = array();
foreach ($uAr as $url) {
	$html = new simple_html_dom();
	$html->load_file($url);
	foreach ($html->find('div[itemprop="articleBody"]') as $div) {
		foreach ($div->find('blockquote') as $quote) 
			$quoteAr[] = $quote->plaintext;
//		foreach ($div->find('p[style="text-align: justify;"]') as $p) {
		foreach ($div->find('p') as $p) {
			$pCont = $p->plaintext;
			foreach ($p->find('strong') as $strong) 
				$strongAr[] = $strong->plaintext;
			$content .= $pCont.'<br/>';
		}
	}
}
if ($house != 1 && $planet == 'jupiter') {
	$strongAr[19] = 'Sao Mộc ở Song Ngư';
	unset($strongAr[20]);
}
foreach ($strongAr as $strong) $content = str_replace($strong.'<br/>', '<b>'.$strong.'</b><br/>', $content);
foreach ($quoteAr as $quote) $content = str_replace($quote, '', $content);
$content = '{begin}<br/>'.$content.'{end}';
$content = htmlentities($content, null, 'utf-8');
$content = str_replace("&nbsp;", "", $content);
$content = html_entity_decode($content);
$content = preg_replace('/\s+/', ' ', $content);
print_r($strongAr);
echo '<hr/>';
if ($house != 1) {
	if ($planet == 'mercury') {
		$L = 10;
		unset($strongAr[17]);
		unset($strongAr[23]);
	} else if ($planet == 'mars') {
		$L = 8;
		unset($strongAr[13]);
		unset($strongAr[14]);
		unset($strongAr[22]);
	} else {
		$L = 7;
		unset($strongAr[12]);
	}
	for ($l = 0; $l < $L; $l++) unset($strongAr[$l]);
} else {
	unset($strongAr[0]);
	if ($planet == 'venus') unset($strongAr[13]);
	else unset($strongAr[1]);
	if (in_array($planet, $partAr)) {
		unset($strongAr[8]);
		if ($planet == 'sun') unset($strongAr[9]);
	}
}
$strongAr = array_values($strongAr);
print_r($strongAr);
echo '<hr/>';
foreach ($strongAr as $i => $strong) {
//	if ($i >= 2 || (!in_array($planet, $partAr) || $i >= 11) ) {
		$k = $i;
		$j = $i + 1;
		$p1 = $strongAr[$i];
		if ($strongAr[$j]) $p2 = '<b>'.$strongAr[$j].'</b>';
		else $p2 = '{end}';
		$cont = Find_Specific('<b>'.$p1.'</b>', $p2, $content);
		$cont = substr($cont, 0, -5);
		$hname = $houseAr[$k];
		if ($house == 1) $code = $planet.'-in-'.$hname.'-house';
		else $code = $planet.'-in-'.$signAr[$i];
		$codee = trendCode($code);
		$cou = countRecord('data', "`code` = '{$codee}' AND `lang` = 'vn' ");
		if ($cont) {
			echo $codee.' - '.$cou.' - '.$p1.' | '.$p2.'<br/>';
			echo $cont.'<hr/>';
			if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'vn', '{$cont}', '{$current}' ");
			else changeValue('data', "`code` = '{$codee}' AND `lang` = 'vn' ", "`content` = '{$cont}' ");
		}
//	}
}


/*
$book = 'http://hermetic.com/crowley/astrology/your-place-among-the-stars/';
$html = new simple_html_dom();
$html->load_file($book);
$content = '';
$strongAr = array();
//$strongAr = array('Kim Ngưu – Bạch Dương');
foreach ($html->find('ul.nolistyle') as $ul) {
	foreach ($ul->find('a') as $a) {
		$url = $a->href;
		$urlAr[] = $url;
	}
}
foreach ($urlAr as $url) {
//for ($i = 100; $i < 200; $i++) {
	$url = $urlAr[$i];
	$code = trendCode(explode('.', $url)[0]);
	$url = $book.$url;
	$page = new simple_html_dom();
	$page->load_file($url);
	$cont = '';
	foreach ($page->find('div.content') as $div) {
		foreach ($div->find('p') as $p) {
			$cont .= $p->plaintext.'<br/>';
		}
	}
	$planet = explode('-in-', $code)[0];
	$sign = explode('-in-', $code)[1];
	$cont = '{begin}<br/>'._content($cont);
	$p2 = 'The following well known persons were also born with '.ucfirst($planet).' in the sign '.ucfirst($sign).':';
	$p2_ = 'The following well known persons were also born with the '.ucfirst($planet).' in the sign '.ucfirst($sign).':';
	if (check($p2, $cont)) $p2 = $p2;
	else $p2 = $p2_;
	$cont = Find_Specific('{begin}', $p2, $cont);
	$cou = countRecord('data', "`code` = '{$code}' AND `lang` = 'us' AND `sid` = '3' ");
	echo $code.' - '.$cou.' - '.$p2.'<br/>';
	echo $cont.'<hr/>';
	if ($cou <= 0) insert('data', "`code`, `lang`, `sid`, `content`, `time`", " '{$code}', 'us', '3', '{$cont}', '{$current}' ");
	else changeValue('data', "`code` = '{$code}' AND `lang` = 'us' AND `sid` = '3' ", "`content` = '{$cont}' ");
}


/*
$urlAr = array(
//	'aries' => 'http://www.12cunghoangdao.com.vn/bach-duong-hop-voi-cung-nao.html', // Done
//	'taurus' => 'http://www.12cunghoangdao.com.vn/nua-kia-cua-kim-nguu-se-la-ai-trong-12-chom-sao.html', // Done
// 	'gemini' => 'http://www.12cunghoangdao.com.vn/trong-tinh-yeu-cung-song-tu-hop-voi-cung-nao.html', // Done
//	'cancer' => 'http://www.12cunghoangdao.com.vn/cu-giai-ket-doi-voi-sao-nao-se-khien-nguoi-khac-ghen-ty.html', // Done
//	'leo' => 'http://www.12cunghoangdao.com.vn/su-tu-ket-doi-voi-chom-sao-nao-la-dinh-nhat.html', // Done
//	'virgo' => 'http://www.12cunghoangdao.com.vn/luong-duyen-tien-dinh-xu-nu-can-phai-sanh-doi-cung-ai.html', // Done
//	'libra' => 'http://www.12cunghoangdao.com.vn/thien-binh-hop-voi-cung-nao.html', // Done
//	'scorpio' => 'http://www.12cunghoangdao.com.vn/bo-cap-la-thanh-mai-truc-ma-voi-chom-sao-nao.html', // Done
//	'sagittarius' => 'http://www.12cunghoangdao.com.vn/nhan-ma-ket-doi-voi-chom-sao-nao-la-tuyet-cu-meo-nhat.html', // Done
//	'capricorn' => 'http://www.12cunghoangdao.com.vn/ma-ket-se-toan-tam-toan-y-voi-ai-trong-12-chom-sao.html', // Done
//	'aquarius' => 'http://www.12cunghoangdao.com.vn/bao-binh-ket-doi-cung-sao-nao-la-tuyet-nhat.html', // Done
//	'pisces' => 'http://www.12cunghoangdao.com.vn/dinh-menh-song-ngu-nen-ket-doi-voi-chom-sao-nao.html', // Done
);
foreach ($urlAr as $uK => $url) {
$sunCode = $uK;
$sun = mb_convert_case($lang[strtoupper($sunCode)], MB_CASE_TITLE, "UTF-8");
$html = new simple_html_dom();
$html->load_file($url);
$content = '';
$strongAr = array();
//$strongAr = array('Kim Ngưu – Bạch Dương');
foreach ($html->find('div.post-single-content') as $div) {
	foreach ($div->find('p') as $p) {
		$pCont = $p->plaintext;
		foreach ($p->find('strong') as $strong) 
			$strongAr[] = $strong->plaintext;
		$content .= $pCont.'<br/>';
	}
}
foreach ($strongAr as $strong) $content = str_replace($strong, '<b>'.$strong.'</b>', $content);
foreach ($signAr as $si) $siVi = mb_convert_case($lang[$si], MB_CASE_TITLE, "UTF-8");
$content = '{begin}<br/>'.$content.'{end}';
$content = htmlentities($content, null, 'utf-8');
$content = str_replace("&nbsp;", "", $content);
$content = str_replace('<br />', '</p><p>', $content);
$content = html_entity_decode($content);
$content = preg_replace('/\s+/', ' ', $content);
//echo $content;
print_r($strongAr);
echo '<br/><hr/>';

	// love
	for ($i = 0; $i <12; $i++) {
		$j = $i + 1;
		$k = $i + 2;
		$si = $signAr[$i];
		$siNext = $signAr[$j];
		$siNextN = $signAr[$k];
		$siVi = mb_convert_case($lang[$si], MB_CASE_TITLE, "UTF-8");
		$siNextVi = mb_convert_case($lang[$siNext], MB_CASE_TITLE, "UTF-8");
		$siNextNVi = mb_convert_case($lang[$siNextN], MB_CASE_TITLE, "UTF-8");
		$p1 = '<b>'.$strongAr[$i].'</b>';
		$p2 = '<b>'.$strongAr[$j].'</b>';
//		$p1 = '<b>'.$sun.' – '.$siVi.'</b>';
//		$p2 = '<b>'.$sun.' – '.$siNextVi.'</b>';
		if ($uK == 'gemini') {
			$p1 = '<b>'.$strongAr[$i + 2].'</b>';
			$p2 = '<b>'.$strongAr[$j + 2].'</b>';
		}
		if ($i == 11) $p2 = '{end}';
		echo $p1.'~~~~~~~~~'.$p2.'<br/>';
		$segment = Find_Specific($p1, $p2, $content);
		$segment = substr($segment, 0, -5);
		$codee = trendCode('love-'.$sunCode.'-'.$si);
		$cou = countRecord('data', "`code` = '{$codee}' AND `lang` = 'vn' ");
		if ($segment) {
			echo $codee.' - '.$cou.'<br/>';
			echo $segment.'<hr/>';
			if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'vn', '{$segment}', '{$current}' ");
			else changeValue('data', "`code` = '{$codee}' AND `lang` = 'vn' ", "`content` = '{$segment}' ");
		}
	}
}

/*
$urlAr = array(
	'aries' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh/81/5-tinh-cach-vua-giong-vua-khac-trong-cung-bach-duong.htm',
	'taurus' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh/82/lat-tay-nhung-con-nguoi-khac-nhau-trong-cung-kim-nguu.htm',
	'gemini' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh/83/song-tu-phuc-tap-bi-lat-tay-moi-phan-tinh-cach.htm',
	'cancer' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh/84/chia-khoa-de-hieu-tat-tan-tat-ve-cu-giai.htm',
	'leo' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh/85/5-tinh-cach-dac-biet-cua-cung-su-tu.htm',
	'virgo' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh%2F86%2Fgoc-nhin-da-chieu-cho-tinh-cach-cua-xu-nu.htm',
	'libra' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh/88/di-tim-nhung-con-nguoi-that-cua-thien-binh.htm',
	'scorpio' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh/89/di-tim-nhung-con-nguoi-khac-biet-trong-cung-bo-cap.htm',
	'sagittarius' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh/90/5-con-nguoi-khac-nhau-cung-co-ten-nhan-ma.htm',
	'capricorn' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh/93/mo-xe-chi-tiet-moi-tinh-cach-cua-ma-ket.htm',
	'aquarius' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh/95/la-lam-voi-5-tinh-cach-khac-nhau-cua-bao-binh.htm',
	'pisces' => 'http://quizz.kenh14.vn/thu-vien-chiem-tinh/96/tim-hieu-chi-tiet-ve-cac-song-ngu-bi-an.htm',
);
foreach ($urlAr as $uK => $url) {
$sunCode = $uK;
$html = new simple_html_dom();
$html->load_file($url);
$content = '';
$strongAr = array();
foreach ($html->find('.body') as $div) {
	foreach ($div->find('p') as $p) {
		$pCont = $p->plaintext;
		foreach ($p->find('strong') as $strong) 
			$strongAr[] = $strong->plaintext;
		$content .= $pCont.'<br/>';
	}
}
foreach ($strongAr as $strong) $content = str_replace($strong, '<b>'.$strong.'</b>', $content);
foreach ($signAr as $si) $siVi = mb_convert_case($lang[$si], MB_CASE_TITLE, "UTF-8");
$content = '{begin}<br/>'.$content.'{end}';
$content = htmlentities($content, null, 'utf-8');
$content = str_replace("&nbsp;", "", $content);
$content = html_entity_decode($content);
$content = preg_replace('/\s+/', ' ', $content);
//echo $content;
print_r($strongAr);
echo '<br/><br/>';

for ($i = 0; $i <= 3; $i++) {
	$sAr = array();
	if ($i != 1) {
		$j = $i + 1;
		if ($i == 0) $k = 1;
		else $k = $i;
		$date = preg_split("/\(|\)/", $strongAr[$i])[1];
		$dAr = explode(" &ndash; ", $date);
		foreach ($dAr as $dK => $dO) {
			$dO = explode('/', $dO);
			$d = $dO[0];
			$m = $dO[1];
			if ($d < 10) $d = '0'.$d;
			if ($m < 10) $m = '0'.$m;
			$dO = $d.$m;
			$dAr[$dK] = $dO;
		}
//		insert('zodiac', "`sign`, `segment`, `start`, `end`", " '{$sunCode}', '{$k}', '{$dAr[0]}', '{$dAr[1]}' ");
	}
}

for ($i = 1; $i <= 4; $i++) {
	if ($i == 1 || $i == 4) {
		$date = preg_split("/\(|\)/", $strongAr[$i])[1];
		$dAr = explode(" &ndash; ", $date);
		foreach ($dAr as $dK => $dO) {
			$dO = explode('/', $dO);
			$d = $dO[0];
			$m = $dO[1];
			if ($d < 10) $d = '0'.$d;
			if ($m < 10) $m = '0'.$m;
			$dO = $d.$m;
			$dAr[$dK] = $dO;
		}
		if ($i == 1) $k = 1;
		else $k = -1;
//		insert('zodiac', "`sign`, `vertex`, `start`, `end`", " '{$sunCode}', '{$k}', '{$dAr[0]}', '{$dAr[1]}' ");
	}
}
echo '<br/><hr/>';

// segment
for ($i = 0; $i <= 3; $i++) {
	if ($i != 1) {
		$j = $i + 1;
		if ($i == 0) $k = 1;
		else $k = $i;
		$segment = Find_Specific('<b>'.$strongAr[$i].'</b>', '<b>'.$strongAr[$j].'</b>', $content);
		$segment = substr($segment, 0, -5);
		$codee = 's'.$k.'-'.$sunCode;
		$cou = countRecord('data', "`code` = '{$codee}' AND `lang` = 'vn' ");
		if ($segment) {
			echo $codee.' - '.$cou.'<br/>';
			echo $segment.'<hr/>';
			if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'vn', '{$segment}', '{$current}' ");
			else changeValue('data', "`code` = '{$codee}' AND `lang` = 'vn' ", "`content` = '{$segment}' ");
		}
	}
}
for ($i = 1; $i <= 4; $i++) {
	if ($i == 1 || $i == 4) {
		$j = $i + 1;
		$p1 = $strongAr[$i];
		if ($i == 1) {
			$p2 = '<b>'.$strongAr[$j].'</b>';
			$k = 1;
		} else {
			$p2 = '{end}';
			$k = -1;
		}
//		insert('zodiac', "`sign`, `vertex`", " '{$sunCode}', '{$k}' ");
		$top = Find_Specific('<b>'.$p1.'</b>', $p2, $content);
		$top = substr($top, 0, -5);
		$codee = 'v'.$k.'-'.$sunCode;
		$cou = countRecord('data', "`code` = '{$codee}' AND `lang` = 'vn' ");
		if ($top) {
			echo $codee.' - '.$cou.'<br/>';
			echo $top.'<hr/>';
			if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'vn', '{$top}', '{$current}' ");
			else changeValue('data', "`code` = '{$codee}' AND `lang` = 'vn' ", "`content` = '{$top}' ");
		}
	}
}
}



/*$url = 'http://lovedia.vn/mat-trang-song-tu-va-su-ket-hop-voi-12-cung-mat-troi.html';
$moon = 'Song Tử';
$moonCode = 'gemini';
$html = new simple_html_dom();
$html->load_file($url);
$content = '';
$strongAr = array();
foreach ($html->find('.post-content[itemprop="articleBody"]') as $div) {
	foreach ($div->find('p[style="text-align: justify;"]') as $p) {
		$pCont = $p->plaintext;
		foreach ($p->find('strong') as $strong) 
			$strongAr[] = $strong->plaintext;
		$content .= $pCont.'<br/>';
	}
}
foreach ($strongAr as $strong) $content = str_replace($strong, '<b>'.$strong.'</b>', $content);
foreach ($signAr as $si) {
	$siVi = mb_convert_case($lang[$si], MB_CASE_TITLE, "UTF-8");
	$content = str_replace('Mặt trăng '.$moon.' và Mặt trời '.$siVi.' ', 'Mặt trăng '.$moon.' và Mặt trời '.$siVi, $content);
}
$content = '{begin}<br/>'.$content.'{end}';
//echo $content;
// Overview 
$overview = Find_Specific('{begin}', '<b>1. Mặt trăng '.$moon.' và Mặt trời Bạch Dương</b>', $content);
//$overview = Find_Specific('{begin}', '<b>Mặt trăng '.$moon.' và Mặt trời Bạch Dương</b>', $content);
$overview = substr($overview, 0, -5);
$codee = 'moon-'.$moonCode;
$cou = countRecord('data', "`code` = '{$codee}' AND `lang` = 'vn' ");
if ($overview) {
	echo $codee.' - '.$cou.'<br/>';
	echo $overview.'<hr/>';
	if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'vn', '{$overview}', '{$current}' ");
	else changeValue('data', "`code` = '{$codee}' AND `lang` = 'vn' ", "`content` = '{$overview}' ");
}
// Combinations 
//for ($kj = 0; $kj < 12; $kj++) {
	$kj = 9;
	$sign = $signAr[$kj];
	$kk = $kj + 1;
	$hh = $kk + 1;
	$signNext = $signAr[$kk];
	$code = trendCode('moon-'.$moonCode.'-sun-'.$sign);
	$signVi = mb_convert_case($lang[$sign], MB_CASE_TITLE, "UTF-8");
	$signNextVi = mb_convert_case($lang[$signNext], MB_CASE_TITLE, "UTF-8");
	if ($signNext) $see = '<b>'.$hh.'. Mặt trăng '.$moon.' và Mặt trời '.$signNextVi.'</b>';
//	if ($signNext) $see = '<b>Mặt trăng '.$moon.' và Mặt trời '.$signNextVi.'</b>';
	else $see = '{end}';
//	$see = '<b>Mặt trăng và Mặt trời cung Ma Kết</b>';
	echo '<b>'.$kk.'. Mặt trăng '.$moon.' và Mặt trời '.$signVi.'</b> | '.$see.'<br/>';
	$content = Find_Specific('<b>'.$kk.'. Mặt trăng '.$moon.' và Mặt trời '.$signVi.'</b>', $see, $content);
//	$content = Find_Specific('<b>Mặt trăng '.$moon.' và Mặt trời '.$signVi.'</b>', $see, $content);
	$cont = substr($content, 0, -5);
	$codee = trendCode($code);
	$cou = countRecord('data', "`code` = '{$codee}' AND `lang` = 'vn' ");
	if ($cont) {
		echo $code.' - '.$cou.'<br/>';
		echo $cont.'<hr/>';
		if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'vn', '{$cont}', '{$current}' ");
		else changeValue('data', "`code` = '{$codee}' AND `lang` = 'vn' ", "`content` = '{$cont}' ");
	}
//}

foreach ($signAr as $SI) {
	$si = strtolower($SI);
	$change = changeValue('data', "`code` = 'moon-{$si}' ", "`code` = 'moon-in-{$si}' ");
	if ($change) echo 'Done<br/>';
}

/*
//$url = 'http://lovedia.vn/cung-moc-song-ngu-va-su-ket-hop-voi-12-cung-mat-troi.html'; // <~~ This has not been crawled.
$url = 'http://lovedia.vn/cung-moc-thien-binh-va-su-ket-hop-voi-12-cung-mat-troi.html';
$rising = 'Thiên Bình';
$risingCode = 'libra';
$html = new simple_html_dom();
$html->load_file($url);
$content = '';
$strongAr = array();
foreach ($html->find('.post-content[itemprop="articleBody"]') as $div) {
	foreach ($div->find('p[style="font-weight: inherit; font-style: inherit; color: #111111; text-align: justify;"]') as $i => $p) {
		$pCont = $p->plaintext;
		foreach ($p->find('strong') as $j => $strong) 
			$strongAr[] = $strong->plaintext;
		foreach ($p->find('b') as $j => $strong) 
			$strongAr[] = $strong->plaintext;
		$content .= $pCont.'<br/>';
	}
}
foreach ($strongAr as $strong) $content = str_replace($strong, '<b>'.$strong.'</b>', $content) .'<br/>';
$content = '{begin}<br/>'.$content.'{end}';
$string = htmlentities($content, null, 'utf-8');
$content = str_replace("&nbsp;", " ", $string);
//$content = preg_replace('~(?<!&nbsp;)&nbsp;(?!&nbsp;)~i', ' ', $string);
$content = html_entity_decode($content);
$content = preg_replace('/\s+/', ' ', $content);

foreach ($signAr as $si) {
	$siVi = mb_convert_case($lang[$si], MB_CASE_TITLE, "UTF-8");
	$content = str_replace('Cung Mọc '.$rising.' và Mặt trời '.$siVi.' ', 'Cung Mọc '.$rising.' và Mặt trời '.$siVi, $content);
}
//$content = str_replace('Bọ Cạp', 'Dis', $content);
//echo $content;
// Overview 
//$overview = Find_Specific('{begin}', '<b>Cung Mọc '.$rising.' và Mặt trời Bạch Dương</b>', $content);
$overview = Find_Specific('{begin}', '<b>1. Cung Mọc '.$rising.' và Mặt trời Bạch Dương</b>', $content);
$overview = substr($overview, 0, -5);
$codee = 'rising-'.$risingCode;
$cou = countRecord('data', "`code` = '{$codee}' AND `lang` = 'vn' ");
if ($overview) {
	echo $codee.' - '.$cou.'<br/>';
	echo $overview.'<hr/>';
	if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'vn', '{$overview}', '{$current}' ");
	else changeValue('data', "`code` = '{$codee}' AND `lang` = 'vn' ", "`content` = '{$overview}' ");
}
for ($k = 0; $k < 12; $k++) {
	$sign = $signAr[$k];
	$code = trendCode('rising-'.$risingCode.'-sun-'.$sign);
	$signVi = mb_convert_case($lang[$sign], MB_CASE_TITLE, "UTF-8");
	$signNext = $signAr[$k+1];
	$signNextVi = mb_convert_case($lang[$signNext], MB_CASE_TITLE, "UTF-8");
	$kk = $k + 1;
	$hh = $kk + 1;
	if ($signNext) $see = '<b>'.$hh.'. Cung Mọc '.$rising.' và Mặt trời '.$signNextVi.'</b>';
//	if ($signNext) $see = '<b>Cung Mọc '.$rising.' và Mặt trời '.$signNextVi.'</b>';
	else $see = '{end}';
	$cc = Find_Specific('<b>'.$kk.'. Cung Mọc '.$rising.' và Mặt trời '.$signVi.'</b>', $see, $content);
//	$overview = Find_Specific('<b>Cung Mọc '.$rising.' và Mặt trời '.$signVi.'</b>', $see, $content);
	echo '<b>'.$kk.'. Cung Mọc '.$rising.' và Mặt trời '.$signVi.'</b> | '.$see.'<br/>';
	$cont = substr($cc, 0, -5);
	$codee = trendCode($code);
	$cou = countRecord('data', "`code` = '{$codee}' AND `lang` = 'vn' ");
	if ($cont) {
		echo $code.' - '.$cou.'<br/>';
		echo $cont.'<hr/>';
		if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'vn', '{$cont}', '{$current}' ");
		else changeValue('data', "`code` = '{$codee}' AND `lang` = 'vn' ", "`content` = '{$cont}' ");
	}
}

/*for ($i = 0; $i < count($signAr); $i++) {
	$sign = $signAr[$i];
	$code = $sign .' rising';
	$ii = $i + 1;
	$file = "lib/astro/natal_files/rising.txt";
	$string = Find_Specific_Report_Paragraph($code, $file);
	$cont = trim( str_replace("<br />", "", str_replace("'", "\'", (preg_replace("/$code\<br \/\>/", '', nl2br($string)))) ) );
//	$cont = trim( str_replace("<br />", "<br/>", nl2br(file_get_contents($file))) );
//	$cont = Find_Specific($code, '*', $cont);
	$codee = 'rising-'.strtolower($sign);
	$cou = countRecord('data', "`code` = '{$codee}' ");
	if ($cont) {
		echo $code.' - '.$codee.' - '.$cou.'<br/>';
		echo $cont.'<hr/>';
		if ($cou <= 0) $ins = insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'us', '{$cont}', '{$current}' ");
	}
}

/*$mbti = $getRecord -> GET('data', "`id` = 884 ");
foreach ($mbti as $mO) {
	$cont = _content('{begin}
'.$mO['content'].'
{end}');
//	print_r($ar);
//	echo $cont.'<br/>';
//	foreach ($nAr as $nO) {
	$no = $mO['code'];
	$nO = strtoupper($no);
//		echo $nO.'<br/>';
		$overview = _content(Find_Specific('{begin}', 'Các '.$nO.' nổi tiếng', $cont));
		$job = _content(Find_Specific($nO.' VÀ SỰ NGHIỆP', 'PHÁT TRIỂN NHÂN CÁCH CỦA '.$nO, $cont));
		$rules = _content(Find_Specific('PHÁT TRIỂN NHÂN CÁCH CỦA '.$nO, $nO.' VÀ CÁC MỐI QUAN HỆ', $cont));
		$famous = _content(Find_Specific('Các '.$nO.' nổi tiếng', $nO.' VÀ SỰ NGHIỆP', $cont));
		$relationship = _content(Find_Specific($nO.' VÀ CÁC MỐI QUAN HỆ', '{end}', $cont));
//		$job = preg_split("/{$nO} VÀ SỰ NGHIỆP|PHÁT TRIỂN NHÂN CÁCH CỦA {$nO}/", $mO['content'])[1];
		echo $job;
		if (countRecord('data', "`code` = '{$no}-job' ") <= 0)
			$ins = insert('data', "`code`, `lang`, `content`, `time`", " '{$no}-job', 'vn', '{$job}', '{$current}' ");
		if (countRecord('data', "`code` = '{$no}-relationship' ") <= 0)
			$ins = insert('data', "`code`, `lang`, `content`, `time`", " '{$no}-relationship', 'vn', '{$relationship}', '{$current}' ");
		if (countRecord('data', "`code` = '{$no}-famous' ") <= 0)
			$ins = insert('data', "`code`, `lang`, `content`, `time`", " '{$no}-famous', 'vn', '{$famous}', '{$current}' ");
		if (countRecord('data', "`code` = '{$no}-rules' ") <= 0)
			$ins = insert('data', "`code`, `lang`, `content`, `time`", " '{$no}-rules', 'vn', '{$rules}', '{$current}' ");
		if (countRecord('data', "`code` LIKE '{$no}-%' ") >= 4)
			$edit = changeValue('data', "`code` = '{$no}' ", "`content` = '{$overview}' ");
//	}
	echo '<hr/>';
}

/*$ins = insert('data', "`code`, `lang`, `sid`, `thumb`, `content`", " 'rising-gemini-sun-pisces', 'vn', '3', '', 'Sự kết hợp này có thể mang đến chút khó khăn trong cuộc sống. Bạn có vẻ như luôn hành động sai lầm vào những thời điểm sai lầm. Không phải là bạn không thể làm được mọi thứ cho đúng đắn, vấn đề là cả trí óc lẫn cơ thể bạn luôn bị điều khiển bởi hai nguồn lực đối lập, một lý trí và một cảm xúc, cùng với đó là sự thiếu cân bằng trong nội tâm.

Bạn thực sự rất thông minh và là một nhà ngoại giao tốt, nhưng có vẻ những gì bạn nói ra không hoàn toàn có tính xác thực. Thật không may cho những người nói chuyện với bạn khi họ hoàn toàn tin sái cổ. Bạn có thể hơi thiếu tự tin và sẽ gặp nhiều trở ngại trong quá trình tìm kiếm thành công.

Một cách chắc chắn nhất cho sự kết hợp này đến với thành công, đó là rèn luyện để có sự phán xét chính xác trong quá trình tư duy. Hãy luôn có quan điểm chắc chắn trước khi làm việc gì, dù điều này sẽ cần thời gian luyện tập. Hơn nữa, bạn cũng nên học cách giải quyết những mâu thuẫn trong suy nghĩ của bản thân với một thái độ hợp lý.

Công việc phù hợp nhất với bạn là những ngành nghề liên quan đến lĩnh vực nghệ thuật hoặc giao tiếp, biểu diễn. Ngày nay là thời điểm của công nghệ và các website, đó chính là nơi bạn có thể phát triển và tìm kiếm những người cùng chung chí hướng từ khắp nơi trên thế giới. Thật tốt nếu bạn tìm được những người bạn sẵn sàng giúp đỡ mặc cho lối sống khác người của bạn.

Là một người khá lãng mạn, song trong lòng bạn luôn là sự đấu tranh dữ dội giữa mong muốn có được một người tình quan tâm, giỏi chăm sóc và một người yêu luôn kích thích và khiến bạn thú vị về mặt trí tuệ.  Điều này có thể khiến bạn trải qua nhiều mối tình trong đời và có những cuộc đấu tranh cảm xúc mãnh liệt. Hãy cố gắng cởi mở hơn và tìm kiếm một người có đầy đủ cả hai đặc tính trên.
'");

if ($ins) echo 'Done!';

/*for ($i = 0; $i < count($planetAr); $i++) {
	$plan = $planetAr[$i];
	for ($k = 0; $k < count($asAr); $k++) {
		$aspect = $asAr[$k];
		for ($j = 0; $j < count($planetAr); $j++) {
			$planet = $planetAr[$j];
			$code = ucwords(strtolower($plan)) .' '.$aspect.' '. ucwords(strtolower($planet));
			$ii = $i + 1;
			$file = "lib/astro/transit_files/" . strtolower($plan) . "_tr.txt";
			$string = Find_Specific_Report_Paragraph($code, $file);
//			$cont = str_replace("'", "\'", (preg_replace("/$code\<br \/\>/", '', nl2br($string))));
			$cont = trim( str_replace("<br />", "", str_replace("'", "\'", (preg_replace("/$code\<br \/\>/", '', nl2br($string)))) ) );
			$codee = trendCode($code);
			$cou = countRecord('data', "`code` = '{$codee}' ");
			if ($cont) {
				echo $code.' - '.$cou.'<br/>';
				echo $cont.'<hr/>';
				if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'us', '{$cont}', '{$current}' ");
//				else changeValue('data', "`code` = '{$code}' ", "`en` = '{$cont}' ");
			}
		}
	}
}

for ($i = 0; $i < count($planetAr); $i++) {
	$plan = $planetAr[$i];
	for ($k = 0; $k < count($aspectAr); $k++) {
		$aspect = $aspectAr[$k];
		for ($j = 0; $j < count($planetAr); $j++) {
			$planet = $planetAr[$j];
			$code = ucwords(strtolower($plan)) .' '.$aspect.' '. ucwords(strtolower($planet));
			$ii = $i + 1;
			$file = "lib/astro/natal_files/" . strtolower($plan) . ".txt";
			$string = Find_Specific_Report_Paragraph($code, $file);
//			$cont = str_replace("'", "\'", (preg_replace("/$code\<br \/\>/", '', nl2br($string))));
			$cont = trim( str_replace("<br />", "", str_replace("'", "\'", (preg_replace("/$code\<br \/\>/", '', nl2br($string)))) ) );
			$codee = trendCode($code);
			$cou = countRecord('data', "`code` = '{$codee}' ");
			if ($cont) {
				echo $code.' - '.$codee.' - '.$cou.'<br/>';
				echo $cont.'<hr/>';
				if ($cou <= 0) $ins = insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'us', '{$cont}', '{$current}' ");
//				else changeValue('data', "`code` = '{$code}' ", "`en` = '{$cont}' ");
			} 
		}
	}
}

for ($i = 0; $i < count($houseAr); $i++) {
	$house = $houseAr[$i];
	for ($j = 0; $j < count($planetAr); $j++) {
		$planet = $planetAr[$j];
		$code = ucwords(strtolower($planet)) .' in '. ucwords(strtolower($house)).' house';
		$codee = trendCode($code);
		$cou = countRecord('data', "`code` = '{$codee}' ");
		echo $code.' - '.$cou.'<br/>';
		$ii = $i + 1;
		$file = "natal_files/house_" . $ii . ".txt";
		$string = Find_Specific_Report_Paragraph($code, $file);
//			$cont = str_replace("'", "\'", (preg_replace("/$code\<br \/\>/", '', nl2br($string))));
			$cont = trim( str_replace("<br />", "", str_replace("'", "\'", (preg_replace("/$code\<br \/\>/", '', nl2br($string)))) ) );
		echo $cont.'<hr/>';
		if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'us', '{$cont}', '{$current}' ");
//		else changeValue('data', "`code` = '{$codee}' ", "`en` = '{$cont}' ");
	}
}

$viAr = $getRecord -> GET('data');
foreach ($viAr as $viO) {
	$code = trendCode($viO['code']);
	if ($viO['code'] != $code) {
		$change = changeValue('data', "`id` = '{$viO['id']}' ", "`code` = '{$code}' ");
		if ($change) echo 'Done!<br/>';
		else echo 'Error!<br/>';
	}
}

for ($i = 0; $i < count($signAr); $i++) {
	$sign = $signAr[$i];
	for ($j = 0; $j < count($planetAr); $j++) {
		$planet = $planetAr[$j];
		$code = ucwords(strtolower($planet)) .' in '. ucwords(strtolower($sign));
		$codee = trendCode($code);
		$cou = countRecord('data', "`code` = '{$codee}' ");
		echo $code.' - '.$cou.'<br/>';
		$ii = $i + 1;
		$file = "natal_files/sign_" . $ii . ".txt";
		$string = Find_Specific_Report_Paragraph($code, $file);
//		$cont = str_replace("'", "\'", (preg_replace("/$code\<br \/\>/", '', nl2br($string))));
		$cont = trim( str_replace("<br />", "", str_replace("'", "\'", (preg_replace("/$code\<br \/\>/", '', nl2br($string)))) ) );
		echo $cont.'<hr/>';
		if ($cou <= 0) insert('data', "`code`, `lang`, `content`, `time`", " '{$codee}', 'us', '{$cont}', '{$current}' ");
//		else changeValue('data', "`code` = '{$code}' ", "`en` = '{$cont}' ");
	}
}

*/

?>
