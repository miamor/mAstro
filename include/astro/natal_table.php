<?php
include '../config.php';

include 'constants.php';

$rx1 = safeEscapeString($_GET["rx1"]);

if (get_magic_quotes_gpc()) {
	$longitude = unserialize(stripslashes($_GET["p1"]));
	$hc1 = unserialize(stripslashes($_GET["hc1"]));
} else {
	$longitude = unserialize($_GET["p1"]);
	$hc1 = unserialize($_GET["hc1"]);
}

$longitude[LAST_PLANET + 1] = $hc1[1];
$longitude[LAST_PLANET + 2] = $hc1[10];

// set the content-type
header("Content-type: image/png");

// create the blank image
$overall_size = 160;		//add a planet
$extra_width = 240;		//in order to make total width = 680
$margins = 16;			//left and right margins on the background graphic

$im = @imagecreatetruecolor($overall_size + $extra_width, $overall_size) or die("Cannot initialize new GD image stream");

// specify the colors
$white = imagecolorallocate($im, 255, 255, 255);
$red = imagecolorallocate($im, 255, 0, 0);
$blue = imagecolorallocate($im, 0, 0, 255);
$magenta = imagecolorallocate($im, 255, 0, 255);
$yellow = imagecolorallocate($im, 255, 255, 0);
$cyan = imagecolorallocate($im, 0, 255, 255);
$green = imagecolorallocate($im, 0, 224, 0);
$grey = imagecolorallocate($im, 127, 127, 127);
$black = imagecolorallocate($im, 0, 0, 0);
$lavender = imagecolorallocate($im, 160, 0, 255);
$orange = imagecolorallocate($im, 255, 127, 0);
$light_blue = imagecolorallocate($im, 239, 255, 255);

$pl_name[0] = "Sun";
$pl_name[1] = "Moon";
$pl_name[2] = "Mercury";
$pl_name[3] = "Venus";
$pl_name[4] = "Mars";
$pl_name[5] = "Jupiter";
$pl_name[6] = "Saturn";
$pl_name[7] = "Uranus";
$pl_name[8] = "Neptune";
$pl_name[9] = "Pluto";
$pl_name[10] = "Chiron";
$pl_name[11] = "Lilith";		//add a planet
$pl_name[12] = "True Node";
$pl_name[13] = "P. of Fortune";
$pl_name[14] = "Vertex";
$pl_name[15] = "Ascendant";
$pl_name[16] = "Midheaven";

$pl_glyph[0] = 81;
$pl_glyph[1] = 87;
$pl_glyph[2] = 69;
$pl_glyph[3] = 82;
$pl_glyph[4] = 84;
$pl_glyph[5] = 89;
$pl_glyph[6] = 85;
$pl_glyph[7] = 73;
$pl_glyph[8] = 79;
$pl_glyph[9] = 80;
$pl_glyph[10] = 77;
$pl_glyph[11] = 96;		//add a planet
$pl_glyph[12] = 141;
$pl_glyph[13] = 60;
$pl_glyph[14] = 109;		//Vertex
$pl_glyph[15] = 90;		//Ascendant
$pl_glyph[16] = 88;		//Midheaven

$asp_color[1] = $asp_color['Water'] = $blue;
$asp_color[2] = $asp_color['Fire'] = $red;
$asp_color[3] = $asp_color['Earth'] = $green;
$asp_color[4] = $magenta;
$asp_color[5] = $cyan;
$asp_color[6] = $asp_color['Air'] = $orange;

$asp_glyph[1] = 113;		//0 deg
$asp_glyph[2] = 119;		//180 deg
$asp_glyph[3] = 101;		//120 deg
$asp_glyph[4] = 114;		// 90 deg
$asp_glyph[5] = 111;		//150 deg
$asp_glyph[6] = 116;		// 60 deg

$sign_glyph[1] = 97;
$sign_glyph[2] = 115;
$sign_glyph[3] = 100;
$sign_glyph[4] = 102;
$sign_glyph[5] = 103;
$sign_glyph[6] = 104;
$sign_glyph[7] = 106;
$sign_glyph[8] = 107;
$sign_glyph[9] = 108;
$sign_glyph[10] = 122;
$sign_glyph[11] = 120;
$sign_glyph[12] = 99;

$cell_width = 95;
$cell_height = 25;

$last_planet_num = 16;				//add a planet
$num_planets = $last_planet_num + 1;

$left_margin_planet_table = ($num_planets + 0.5) * $cell_width;

// ------------------------------------------

// create rectangle on blank image
imagefilledrectangle($im, 0, 0, $overall_size + $extra_width, $overall_size, $white);		//705 x 450 - add a planet

// ------------------------------------------

$eles = array_values($elements);
$ele_keys = array_keys($elements);
$quas = array_values($qualities);
$qua_keys = array_keys($qualities);

foreach ($ele_keys as $i => $eK) drawboldtext($im, 11, 0, 10 + $margins, $cell_height * ($i + 1) + 18, $asp_color[$eK], 'arial.ttf', $eK, 0);
foreach ($qua_keys as $i => $qK) drawboldtext($im, 11, 0, $cell_width * ($i + 1) + 15, 18, $black, 'arial.ttf', $qK, 0);

imageline($im, $margins, $cell_height * (0 + 1), $cell_width * 4, $cell_height * (0 + 1), $black);
imageline($im, $margins, 0, $cell_width * 4, 0, $black);
imageline($im, $margins, 0, $margins, $cell_height * 5, $black);
imageline($im, $cell_width * 1, 0, $cell_width * 1, $cell_height * 5, $black);
foreach ($quas as $j => $qAr) {
	$qk = $qua_keys[$j];
	imageline($im, $cell_width * ($j + 2), 0, $cell_width * ($j + 2), $cell_height * 5, $black);
	foreach ($eles as $i => $eAr) {
		$eAr = $eles[$i];
		$ele = $ele_keys[$i];
		imageline($im, $margins, $cell_height * ($i + 2), $cell_width * 4, $cell_height * ($i + 2), $black);
	}
}

$eq = $eP = $qP = array();
foreach ($ele_keys as $i => $eK) $eP[$eK] = $cell_height * ($i + 2) - 7;
foreach ($qua_keys as $i => $qK) $qP[$qK] = $cell_width * ($i + 1);
for ($k = 0; $k < 14; $k++) {
	$s_pos = floor($longitude[$k] / 30) + 1;
	$sigi = $sign_name[$s_pos];
	$pln = $pl_name[$k];
	$qn = $signQ[$sigi];
	$en = $signE[$sigi];
	$i = $ele_keys[$en];
	$j = $qua_keys[$qn];
	if (!$eq[$en.$qn]) $eq[$en.$qn] = 0;
	$eq[$en.$qn]++;
	$l = $eq[$en.$qn];
//	drawboldtext($im, 10, 0, $cell_width * ($k + 1) + 15, 38, $black, 'arial.ttf', $eP[$en].'~'.$qP[$qn], 0);
	drawboldtext($im, 12, 0, $margins * ($l - 0.7) + $qP[$qn], $eP[$en], $asp_color[$en], 'HamburgSymbols.ttf', chr($pl_glyph[$k]), 0);
}

// draw the image in png format - using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
exit();

?>
