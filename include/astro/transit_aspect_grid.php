<?php
//include '../config.php';

include 'constants.php';

$rx1 = safeEscapeString($_GET["rx1"]);
$rx2 = safeEscapeString($_GET["rx2"]);

$ubt1 = safeEscapeString($_GET["ubt1"]);
$ubt2 = safeEscapeString($_GET["ubt2"]);

if ($ubt1 != 0 And $ubt1 != 1)
{
	$ubt1 = 0;
}

if ($ubt2 != 0 And $ubt2 != 1)
{
	$ubt2 = 0;
}

if (get_magic_quotes_gpc())
{
	$longitude1 = unserialize(stripslashes($_GET["p1"]));
	$hc1 = unserialize(stripslashes($_GET["hc1"]));

	$longitude2 = unserialize(stripslashes($_GET["p2"]));
	$hc2 = unserialize(stripslashes($_GET["hc2"]));
}
else
{
	$longitude1 = unserialize($_GET["p1"]);
	$hc1 = unserialize($_GET["hc1"]);

	$longitude2 = unserialize($_GET["p2"]);
	$hc2 = unserialize($_GET["hc2"]);
}

if ($ubt1 == 1)
{
	for ($i = 1; $i <= 12; $i++)
	{
	$hc1[$i] = ($i - 1) * 30;
	}

	$hc1[13] = 0;
}

if ($ubt2 == 1)
{
	for ($i = 1; $i <= 12; $i++)
	{
	$hc2[$i] = ($i - 1) * 30;
	}

	$hc2[13] = 0;
}

$longitude1[LAST_PLANET + 1] = $hc1[1];
$longitude1[LAST_PLANET + 2] = $hc1[10];

$longitude2[LAST_PLANET + 1] = $hc2[1];
$longitude2[LAST_PLANET + 2] = $hc2[10];


// set the content-type
header("Content-type: image/png");

// create the blank image
$overall_size = 475;
$extra_width = 255 + 100;		//in order to make total width = 705 + 125
$margins = 20;			//left and right margins on the background graphic

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
$pl_name[11] = "Lilith";
$pl_name[12] = "True Node";
$pl_name[13] = "P. of Fortune";		//add a planet
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
$pl_glyph[11] = 96;
$pl_glyph[12] = 141;
$pl_glyph[13] = 60;		//Part of Fortune - add a planet
$pl_glyph[14] = 109;		//Vertex
$pl_glyph[15] = 90;		//Ascendant
$pl_glyph[16] = 88;		//Midheaven

$asp_color[1] = $blue;
$asp_color[2] = $red;
$asp_color[3] = $green;
$asp_color[4] = $magenta;
$asp_color[5] = $cyan;
$asp_color[6] = $orange;

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

$cell_width = 25;
$cell_height = 25;

$last_planet_num = SE_TNODE + 4;
$num_planets = $last_planet_num + 1;

if ($ubt1 == 1)
{
	$num_to_use = $last_planet_num - 4;
	$left_margin_planet_table = ($num_planets - 4 + 0.5) * $cell_width;
}
else {
	$num_to_use = $last_planet_num;
	$left_margin_planet_table = ($num_planets + 0.5) * $cell_width;
}


// ------------------------------------------

// create rectangle on blank image
imagefilledrectangle($im, 0, 0, $overall_size + $extra_width, $overall_size, $white);		//705 x 475 - add a planet

// MUST BE HERE - I DO NOT KNOW WHY - MAYBE TO PRIME THE PUMP
imagettftext($im, 10, 0, 0, 0, $black, 'arial.ttf', " ");

// ------------------------------------------

// draw the grid - horizontal lines
for ($i = 0; $i <= $last_planet_num - 4 + 1; $i++) imageline($im, $margins, $cell_height * ($i + 1), $margins + $cell_width * ($num_to_use + 1), $cell_height * ($i + 1), $black);

// draw the grid - vertical lines
for ($i = 0; $i <= $num_to_use + 1; $i++) imageline($im, $margins + $cell_width * $i, $cell_height * ($last_planet_num - 4 + 2), $margins + $cell_width * $i, $cell_height, $black);

// ------------------------------------------

// draw in the planet glyphs
for ($i = 0; $i <= $num_to_use; $i++) {
	drawboldtext($im, 18, 0, $margins + $i * $cell_width, $cell_height, $black, 'HamburgSymbols.ttf', chr($pl_glyph[$i]), 0);		//across the top

	// display planet data in the right-hand table
	if ($i <= $last_planet_num - 4) drawboldtext($im, 16, 0, $margins + $left_margin_planet_table, $cell_height + $cell_height * ($i + 1), $red, 'HamburgSymbols.ttf', chr($pl_glyph[$i]), 0);
	else drawboldtext($im, 16, 0, $margins + $left_margin_planet_table, $cell_height + $cell_height * ($i + 1), $black, 'HamburgSymbols.ttf', chr($pl_glyph[$i]), 0);
	imagettftext($im, 10, 0, $margins + $left_margin_planet_table + $cell_width * 2, $cell_height + $cell_height * ($i + 1) - 3, $blue, 'arial.ttf', $pl_name[$i]);

	$sign_num1 = floor($longitude1[$i] / 30) + 1;
	drawboldtext($im, 14, 0, $margins + $left_margin_planet_table + $cell_width * 5, $cell_height + $cell_height * ($i + 1), $black, 'HamburgSymbols.ttf', chr($sign_glyph[$sign_num1]), 0);
	imagettftext($im, 10, 0, $margins + $left_margin_planet_table + $cell_width * 6, $cell_height + $cell_height * ($i + 1) - 3, $blue, 'arial.ttf', Convert_Longitude($longitude1[$i]) . " " . $rx1[$i]);

	$sign_num2 = floor($longitude2[$i] / 30) + 1;
	if ($i <= $last_planet_num - 4) {
		drawboldtext($im, 14, 0, $margins + $left_margin_planet_table + $cell_width * 10, $cell_height + $cell_height * ($i + 1), $red, 'HamburgSymbols.ttf', chr($sign_glyph[$sign_num2]), 0);
		imagettftext($im, 10, 0, $margins + $left_margin_planet_table + $cell_width * 11, $cell_height + $cell_height * ($i + 1) - 3, $blue, 'arial.ttf', Convert_Longitude($longitude2[$i]) . " " . $rx2[$i]);
	}
}

// ------------------------------------------

// display the aspect glyphs in the aspect grid
for ($i = 0; $i <= $last_planet_num; $i++) {
	if ($ubt1 == 1 And $i > SE_TNODE) continue;

	for ($j = 0; $j <= $last_planet_num - 4; $j++) {
		$q = 0;
		$da = Abs($longitude2[$j] - $longitude1[$i]);

		if ($da > 180) $da = 360 - $da;

		// set orb - 2 if Sun or Moon, 2 if not Sun or Moon
		if ($i == 0 Or $i == 1 Or $j == 0 Or $j == 1) $orb = 2;
		else $orb = 2;

		// is there an aspect within orb?
		if ($da <= $orb) $q = 1;
		else if (($da <= (60 + $orb)) And ($da >= (60 - $orb))) $q = 6;
		else if (($da <= (90 + $orb)) And ($da >= (90 - $orb))) $q = 4;
		else if (($da <= (120 + $orb)) And ($da >= (120 - $orb))) $q = 3;
		else if (($da <= (150 + $orb)) And ($da >= (150 - $orb))) $q = 5;
		else if ($da >= (180 - $orb)) $q = 2;

		if ($q > 0) drawboldtext($im, 14, 0, $margins + $cell_width * ($i + 0.15), $cell_height + $cell_height * ($j + 1 - 0.20), $asp_color[$q], 'HamburgSymbols.ttf', chr($asp_glyph[$q]), 0);
	}
}


// draw the image in png format - using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
exit();


?>
