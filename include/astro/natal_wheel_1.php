<?php
//include '../config.php';

include 'constants.php';

function Sort_planets_by_descending_longitude ($num_planets, $longitude, &$sort, &$sort_pos) {
// load all $longitude() into sort() and keep track of the planet numbers in $sort_pos()
	for ($i = 0; $i <= $num_planets - 1; $i++) {
		$sort[$i] = $longitude[$i];
		$sort_pos[$i] = $i;
	}

// do the actual sort
	for ($i = 0; $i <= $num_planets - 2; $i++) {
		for ($j = $i + 1; $j <= $num_planets - 1; $j++) {
			if ($sort[$j] > $sort[$i]) {
				$temp = $sort[$i];
				$temp1 = $sort_pos[$i];

				$sort[$i] = $sort[$j];
				$sort_pos[$i] = $sort_pos[$j];

				$sort[$j] = $temp;
				$sort_pos[$j] = $temp1;
			}
		}
	}
}

function Count_planets_in_each_house ($num_planets, $sort, $sort_pos, &$nopih, &$spot_filled) {
// count the number of planets in each house
// unset any variables not initialized elsewhere in the program
// reset the number of planets in each house
// make $spot_filled times 15 (instead of 12) just to be sure (to cover overflow)
	unset($spot_filled);

	for ($i = 1; $i <= 12; $i++) $nopih[$i] = 0;

// run through all the planets and see how many planets are in each house
	for ($i = 0; $i <= $num_planets - 1; $i++) {
		// get sign planet is in, since the sign and the house are the same
		$p_num = $sort_pos[$i];
		$temp = floor($sort[$p_num] / 30) + 1;
		$nopih[$temp]++;
	}
}

function display_planet_glyph ($angle_to_use, $radii, &$xy) {
	$cw_pl_glyph = 16;
	$ch_pl_glyph = 16;
	$gap_pl_glyph = -10;

// take into account the width and height of the glyph, defined below
// get distance we need to shift the glyph so that the absolute middle of the glyph is the start point
	$center_pos_x = -$cw_pl_glyph / 2;
	$center_pos_y = $ch_pl_glyph / 2;

// get the offset we have to move the center point to in order to be properly placed
	$offset_pos_x = $center_pos_x * cos($angle_to_use);
	$offset_pos_y = $center_pos_y * sin($angle_to_use);

// now get the final X, Y coordinates
	$xy[0] = $center_pos_x + $offset_pos_x + ((-$radii + $gap_pl_glyph) * cos($angle_to_use));
	$xy[1] = $center_pos_y + $offset_pos_y + (($radii - $gap_pl_glyph) * sin($angle_to_use));

	return ($xy);
}

function display_house_cusp_number ($num, $angle, $radii, &$xy) {
	if ($num < 10) $char_width = 10;
	else $char_width = 16;
	$half_char_width = $char_width / 2;
	$char_height = 12;
	$half_char_height = $char_height / 2;

//puts center of character right on circumference of circle
	$xpos0 = -$half_char_width;
	$ypos0 = $char_height;

	if ($num == 1)
	{
		$x_adj = -cos(deg2rad($angle)) * $char_width;
		$y_adj = sin(deg2rad($angle)) * $char_height;
	}
	else if ($num == 2)
	{
		$x_adj = -cos(deg2rad($angle)) * $half_char_width;
		$y_adj = sin(deg2rad($angle)) * $char_height;
	}
	else if ($num == 3)
	{
		$xpos0 = $half_char_width;
		$x_adj = -cos(deg2rad($angle)) * $half_char_width;
		$y_adj = sin(deg2rad($angle)) * $half_char_height;
	}
	else if ($num == 4)
	{
		$xpos0 = $char_width;
		$x_adj = -cos(deg2rad($angle)) * $half_char_width;
		$y_adj = sin(deg2rad($angle)) * $half_char_height;
	}
	else if ($num == 5)
	{
		$xpos0 = $char_width;
		$x_adj = -cos(deg2rad($angle)) * $half_char_width;
		$ypos0 = $half_char_height;
		$y_adj = sin(deg2rad($angle)) * $half_char_height;
	}
	else if ($num == 6)
	{
		$xpos0 = $char_width;
		$x_adj = -cos(deg2rad($angle)) * $half_char_width;
		$ypos0 = -$half_char_height;
		$y_adj = sin(deg2rad($angle)) * $half_char_height;
	}
	else if ($num == 7)
	{
		$x_adj = -cos(deg2rad($angle)) * $char_width;
		$ypos0 = -$half_char_height;
		$y_adj = -sin(deg2rad($angle)) * $half_char_height;
	}
	else if ($num == 8)
	{
		$x_adj = -cos(deg2rad($angle)) * $char_width;
		$ypos0 = -$half_char_height;
		$y_adj = sin(deg2rad($angle)) * $half_char_height;
	}
	else if ($num == 9)
	{
		$xpos0 = -$char_width;
		$x_adj = -cos(deg2rad($angle)) * $char_width;
		$ypos0 = -$half_char_height;
		$y_adj = sin(deg2rad($angle)) * $half_char_height;
	}
	else if ($num == 10)
	{
		$xpos0 = -$char_width;
		$x_adj = -cos(deg2rad($angle)) * $char_width;
		$ypos0 = $half_char_height;
		$y_adj = sin(deg2rad($angle)) * $char_height;
	}
	else if ($num == 11)
	{
		$xpos0 = -$char_width;
		$x_adj = -cos(deg2rad($angle)) * $char_width;
		$y_adj = sin(deg2rad($angle)) * $char_height;
	}
	else if ($num == 12)
	{
		$x_adj = -cos(deg2rad($angle)) * $char_width;
		$y_adj = sin(deg2rad($angle)) * $half_char_height;
	}

	$xy[0] = $xpos0 + $x_adj - ($radii * cos(deg2rad($angle)));
	$xy[1] = $ypos0 + $y_adj + ($radii * sin(deg2rad($angle)));;

	return ($xy);
}


$retrograde = safeEscapeString($_GET["rx1"]);

if (get_magic_quotes_gpc()) {
	$longitude = unserialize(stripslashes($_GET["p1"]));
	$hc = unserialize(stripslashes($_GET["hc1"]));
} else {
	$longitude = unserialize($_GET["p1"]);
	$hc = unserialize($_GET["hc1"]);
}

$Ascendant = $hc[1];


// set the content-type
header("Content-type: image/png");

// create the blank image
$overall_size = 640;
$im = @imagecreatetruecolor($overall_size, $overall_size) or die("Cannot initialize new GD image stream");

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
//$black = imagecolorallocate($im, 26, 26, 26);
$lavender = imagecolorallocate($im, 160, 0, 255);
$orange = imagecolorallocate($im, 255, 127, 0);
$light_blue = imagecolorallocate($im, 245, 255, 255);
$brown = imagecolorallocate($im, 115, 25, 25);
$pink = imagecolorallocate($im, 218, 20, 80);
$pinkred = imagecolorallocate($im, 253, 17, 88);
$dark = imagecolorallocate($im, 192, 0, 62);
$purple = imagecolorallocate($im, 220, 20, 200);
$indigo = imagecolorallocate($im, 94, 4, 92);

// specific colors
$planet_color = $black;		//was $cyan;
$deg_min_color = $black;		//$white;
$sign_color = $magenta;

$size_of_rect = $overall_size;		// size of rectangle in which to draw the wheel
$diameter = 500;						// diameter of circle drawn
$outer_outer_diameter = $diameter + 100;			// diameter of circle drawn
$outer_diameter_distance = ($outer_outer_diameter - $diameter) / 2;	// distance between outer-outer diameter and diameter
$inner_diameter_offset = 90;			// diameter of circle drawn
$dist_from_diameter1 = 40;			// distance inner planet glyph is from circumference of wheel
$dist_from_diameter1a = 12;			// distance inner planet glyph is from circumference of wheel - for line
$dist_from_diameter2 = 58;			// distance outer planet glyph is from circumference of wheel
$dist_from_diameter2a = 28;			// distance outer planet glyph is from circumference of wheel - for line
$radius = $diameter / 2;				// radius of circle drawn
$center_pt = $size_of_rect / 2;		// center of circle

$last_planet_num = 14;				//add a planet
$num_planets = $last_planet_num + 1;
$max_num_pl_in_each_house = 6;
$deg_in_each_house = 30;

// glyphs used for planets - HamburgSymbols.ttf - Sun, Moon - Pluto
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
$pl_glyph[14] = 109;

// glyphs used for planets - HamburgSymbols.ttf - Aries - Pisces
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

// ------------------------------------------

// create colored rectangle on blank image
imagefilledrectangle($im, 0, 0, $size_of_rect, $size_of_rect, $white);

// MUST BE HERE - I DO NOT KNOW WHY - MAYBE TO PRIME THE PUMP
imagettftext($im, 10, 0, 0, 0, $black, 'arial.ttf', " ");

// draw the outer-outer border of the chartwheel
//imagefilledellipse($im, $center_pt, $center_pt, $outer_outer_diameter + 80, $outer_outer_diameter + 80, $light_blue);

// draw the outer-outer circle of the chartwheel
imagefilledellipse($im, $center_pt, $center_pt, $outer_outer_diameter, $outer_outer_diameter, $white);
imageellipse($im, $center_pt, $center_pt, $outer_outer_diameter, $outer_outer_diameter, $black);
//imageellipse($im, $center_pt, $center_pt, 602, 602, $black);

// draw the outer circle of the chartwheel
imagefilledellipse($im, $center_pt, $center_pt, $diameter, $diameter, $light_blue);
imageellipse($im, $center_pt, $center_pt, $diameter, $diameter, $black);


// ------------------------------------------

// draw the lines for the house cusps
$spoke_length = 20;
for ($i = 1; $i <= 12; $i++) {
	$angle = $Ascendant - $hc[$i];
	$x1 = -$radius * cos(deg2rad($angle));
	$y1 = -$radius * sin(deg2rad($angle));

	$x2 = 1 * cos(deg2rad($angle));
	$y2 = 1 * sin(deg2rad($angle));

//	if ($i != 1 And $i != 10) 
		imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);

	// display the house cusp numbers themselves
//	display_house_cusp_number($i, -$angle, $diameter - $inner_diameter_offset * 5.1, $xy);
	display_house_cusp_number($i, -$angle, $radius - $inner_diameter_offset + 5, $xy);
	imagettftext($im, 9, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $black, 'arial.ttf', $i);
}


// ------------------------------------------

//draw the horizontal line for the Ascendant
$x1 = -($radius - 1) * cos(deg2rad(0));
$y1 = -($radius - $inner_diameter_offset) * sin(deg2rad(0));
$x2 = $radius * cos(deg2rad(0));
$y2 = -($radius - 10) * sin(deg2rad(0));
imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $dark);
//draw the horizontal line for the Ascendant - to make border thick
$y1--; $y2--;
imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $dark);
//draw the horizontal line for the Ascendant - to make border thick
//$y1+=2; $y2+=2;
//imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $dark);
$x1-=24; $y1+=7;
//drawboldtext($im, 16, 0, $x1 + $center_pt, $y1 + $center_pt, $dark, 'HamburgSymbols.ttf', chr($pl_glyph[15]), 0);
drawboldtext($im, 10, 0, $x1 + $center_pt - 2, $y1 + $center_pt - 2, $dark, 'arial.ttf', 'AC', 0);
drawboldtext($im, 10, 0, -$x1 + $center_pt - 14, $y1 + $center_pt - 2, $dark, 'arial.ttf', 'DC', 0);

//draw the arrow for the Ascendant
/*$x1 = -($radius - 0);
$y1 = 30 * sin(deg2rad(0));
$x2 = -($radius - 20);
$y2 = 30 * sin(deg2rad(-20));
imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $dark);
$y2 = 30 * sin(deg2rad(20));
imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $dark);
*/
// ------------------------------------------

// draw the near-vertical line for the MC
$angle = $Ascendant - $hc[10];
$dist_mc_asc = $angle;

if ($dist_mc_asc < 0) $dist_mc_asc = $dist_mc_asc + 360;

$value = 90 - $dist_mc_asc;
$angle1 = 65 - $value;
$angle2 = 65 + $value;

$x1 = ($radius) * cos(deg2rad($angle));
$y1 = ($radius) * sin(deg2rad($angle));
$x2 = -($radius) * cos(deg2rad($angle));
$y2 = -($radius) * sin(deg2rad($angle));
imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $dark);
// draw the near-vertical line for the MC - to make border thick
$x1--; $y1--; $x2--; $y2--;
imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $dark);
// draw the near-vertical line for the MC - to make border thick
//$x1+=2; $y1+=2; $x2+=2; $y2+=2;
//imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $dark);
$x2-=6; $y2-=6;
//drawboldtext($im, 16, 0, $x2 + $center_pt, $y2 + $center_pt, $dark, 'HamburgSymbols.ttf', chr($pl_glyph[16]), 0);
drawboldtext($im, 10, 0, $x2 + $center_pt - 2, $y2 + $center_pt - 2, $dark, 'arial.ttf', 'MC', 0);
drawboldtext($im, 10, 0, -$x2 + $center_pt - 12, -$y2 + $center_pt + 10, $dark, 'arial.ttf', 'IC', 0);

// draw the arrow for the 10th house cusp (MC)
/*$x1 = $x2 + (30 * cos(deg2rad($angle1)));
$y1 = $y2 + (30 * sin(deg2rad($angle1)));
imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $dark);
$x1 = $x2 - (30 * cos(deg2rad($angle2)));
$y1 = $y2 + (30 * sin(deg2rad($angle2)));
imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $dark);
*/

// ------------------------------------------

// draw the inner circle of the chartwheel
imagefilledellipse($im, $center_pt, $center_pt, $diameter - ($inner_diameter_offset * 2) + 9, $diameter - ($inner_diameter_offset * 2) + 9, $white);
imageellipse($im, $center_pt, $center_pt, $diameter - ($inner_diameter_offset * 2) + 9, $diameter - ($inner_diameter_offset * 2) + 9, $black);

/*/ draw the inner-inner circle of the chartwheel
imagefilledellipse($im, $center_pt, $center_pt, $diameter - ($inner_diameter_offset * 4.6), $diameter - ($inner_diameter_offset * 4.6), $white);
imageellipse($im, $center_pt, $center_pt, $diameter - ($inner_diameter_offset * 4.6), $diameter - ($inner_diameter_offset * 4.6), $black);
*/

// draw the dividing lines between the signs
$offset_from_start_of_sign = $Ascendant - (floor($Ascendant / 30) * 30);

for ($i = $offset_from_start_of_sign; $i <= $offset_from_start_of_sign + 330; $i = $i + 30) {
	$x1 = -$radius * cos(deg2rad($i));
	$y1 = -$radius * sin(deg2rad($i));

	$x2 = -($radius + $outer_diameter_distance) * cos(deg2rad($i));
	$y2 = -($radius + $outer_diameter_distance) * sin(deg2rad($i));

	imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);
}


// ------------------------------------------

// draw the spokes of the wheel
$spoke_length = 5;
$minor_spoke_length = 4;
$cnt = 0;
for ($i = $offset_from_start_of_sign; $i <= $offset_from_start_of_sign + 359; $i = $i + 5) {
	$x1 = -$radius * cos(deg2rad($i));
	$y1 = -$radius * sin(deg2rad($i));
		$x2 = -($radius + $spoke_length) * cos(deg2rad($i));
		$y2 = -($radius + $spoke_length) * sin(deg2rad($i));

/*	if ($cnt % 5 == 0) {
		$x2 = -($radius - $spoke_length) * cos(deg2rad($i));
		$y2 = -($radius - $spoke_length) * sin(deg2rad($i));
	} else {
		$x2 = -($radius - $minor_spoke_length) * cos(deg2rad($i));
		$y2 = -($radius - $minor_spoke_length) * sin(deg2rad($i));
	}
*/
	$cnt = $cnt + 1;
	imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);
}

// ------------------------------------------

// put signs around chartwheel
$cw_sign_glyph = 14;
$ch_sign_glyph = 12;
$gap_sign_glyph = -20;
for ($i = 1; $i <= 12; $i++) {
	$angle_to_use = deg2rad((($i - 1) * 30) + 15 - $Ascendant);

	$center_pos_x = -$cw_sign_glyph / 2;
	$center_pos_y = $ch_sign_glyph / 2;

	$offset_pos_x = $center_pos_x * cos($angle_to_use);
	$offset_pos_y = $center_pos_y * sin($angle_to_use);

	$x1 = $center_pos_x + $offset_pos_x + ((-$radius + $gap_sign_glyph) * cos($angle_to_use));
	$y1 = $center_pos_y + $offset_pos_y + (($radius - $gap_sign_glyph) * sin($angle_to_use));

	if ($i == 1 Or $i == 5 Or $i == 9) 
		$clr_to_use = $red;
	else if ($i == 2 Or $i == 6 Or $i == 10)
		$clr_to_use = $green;
	else if ($i == 3 Or $i == 7 Or $i == 11)
		$clr_to_use = $orange;
	else if ($i == 4 Or $i == 8 Or $i == 12)
		$clr_to_use = $blue;
	drawboldtext($im, 16, 0, $x1 + $center_pt, $y1 + $center_pt, $clr_to_use, 'HamburgSymbols.ttf', chr($sign_glyph[$i]), 0);
//	imagettftext($im, 16, 0, $x1 + $center_pt, $y1 + $center_pt, $clr_to_use, 'HamburgSymbols.ttf', chr($sign_glyph[$i]));
}

// ------------------------------------------

// put planets in chartwheel
// sort longitudes in descending order from 360 down to 0
Sort_planets_by_descending_longitude($num_planets, $longitude, $sort, $sort_pos);

// count how many planets are in each house
Count_planets_in_each_house($num_planets, $sort, $sort_pos, $nopih, $spot_filled);

$house_num = 0;

// add planet glyphs around circle
$flag = False;
for ($i = $num_planets - 1; $i >= 0; $i--) {
	// $sort() holds longitudes in descending order from 360 down to 0
	// $sort_pos() holds the planet number corresponding to that longitude
	$temp = $house_num;
	$house_num = floor($sort[$i] / 30) + 1;			  // get house (sign) planet is in

	if ($temp != $house_num) {
		// this planet is in a different house than the last one - this planet is the first one in this house, in other words
		$planets_done = 1;
	}

	// get index for this planet as to where it should be in the possible xx different positions around the wheel
	$from_cusp = Reduce_below_30($sort[$i]);
	if (($from_cusp >= 360 - 1 / 36000) And ($from_cusp <= 360 + 1 / 36000)) 
		$from_cusp = 0;

	$indexy = floor($from_cusp * $max_num_pl_in_each_house / $deg_in_each_house);

	// adjust the index as needed based on other planets in the same house, etc.
	if ($indexy >= $max_num_pl_in_each_house - $nopih[$house_num]) {
		if ($max_num_pl_in_each_house - $indexy - $nopih[$house_num] + $planets_done <= 0) {
			if ($indexy - $nopih[$house_num] + $planets_done < 0)
				$indexy = $max_num_pl_in_each_house - $nopih[$house_num];
			else {
				if ($spot_filled[(($house_num - 1) * $max_num_pl_in_each_house) + $indexy] == 0)
					$indexy = $max_num_pl_in_each_house - $nopih[$house_num] + $planets_done - 1;
				else $indexy = $max_num_pl_in_each_house - $nopih[$house_num];
			}
		}
		if ($indexy < 0) $indexy = 0;
	}

	// see if this spot around the wheel has already been filled
	while ($spot_filled[(($house_num - 1) * $max_num_pl_in_each_house) + $indexy] == 1) {
		// yes, so push the planet up one position
		$indexy++;
	}

	// mark this position as being filled
	$spot_filled[(($house_num - 1) * $max_num_pl_in_each_house) + $indexy] = 1;

	// set the final index
	$chart_idx = ($house_num - 1) * $max_num_pl_in_each_house + $indexy;

	// take the above index and convert it into an angle
	//$planet_angle[$sort_pos[$i]] = ($chart_idx * (3 * $deg_in_each_house) / (3 * $max_num_pl_in_each_house)) + ($deg_in_each_house / (2 * $max_num_pl_in_each_house));	// needed for aspect lines
	$planet_angle[$sort_pos[$i]] = $sort[$i];

	$angle_to_use = $planet_angle[$sort_pos[$i]] - $Ascendant;		 // needed for placing info on chartwheel

	// denote that we have done at least one planet in this house (actually count the planets in this house that we have done)
	$planets_done++;

	// display the planet in the wheel
	$angle_to_use = deg2rad($angle_to_use);

//	if ($flag == False)
		display_planet_glyph($angle_to_use, $radius - $dist_from_diameter1, $xy);
//	else display_planet_glyph($angle_to_use, $radius - ($dist_from_diameter2), $xy);

	imagettftext($im, 14, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $planet_color, 'HamburgSymbols.ttf', chr($pl_glyph[$sort_pos[$i]]));

	// display degrees of longitude for each planet
	if (strtoupper(mid($retrograde, $sort_pos[$i] + 1, 1)) == "R") 
		$t = sprintf("%.1f", Reduce_below_30($sort[$i])) . " r";
	else $t = sprintf("%.1f", Reduce_below_30($sort[$i]));

	//draw line from planet to circumference
//	if ($flag == False) {
		$x1 = (-$radius + $dist_from_diameter1a - 5) * cos($angle_to_use);
		$y1 = ($radius - $dist_from_diameter1a + 5) * sin($angle_to_use);
		$x2 = (-$radius) * cos($angle_to_use);
		$y2 = ($radius) * sin($angle_to_use);
/*	} else {
		$x1 = (-$radius + $dist_from_diameter2a) * cos($angle_to_use);
		$y1 = ($radius - $dist_from_diameter2a) * sin($angle_to_use);
		$x2 = (-$radius + 6) * cos($angle_to_use);
		$y2 = ($radius - 6) * sin($angle_to_use);
	}
*/
	imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $blue);


	$x1 = (-$radius + $dist_from_diameter1a * 6.8) * cos($angle_to_use);
	$y1 = ($radius - $dist_from_diameter1a * 6.8) * sin($angle_to_use);
	$x2 = (-$radius + 6 + 84) * cos($angle_to_use);
	$y2 = ($radius - 6 - 84) * sin($angle_to_use);
	imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);

	$flag = !$flag;
}


// ------------------------------------------

// draw in the aspect lines
for ($i = 0; $i <= $last_planet_num - 1; $i++) {
	for ($j = $i + 1; $j <= $last_planet_num; $j++) {
		$q = 0;
		$da = Abs($longitude[$sort_pos[$i]] - $longitude[$sort_pos[$j]]);

		if ($da > 180) $da = 360 - $da;

		// set orb - 8 if Sun or Moon, 6 if not Sun or Moon
		if ($sort_pos[$i] == 0 Or $sort_pos[$i] == 1 Or $sort_pos[$j] == 0 Or $sort_pos[$j] == 1)
			$orb = 8;
		else $orb = 6;

		// is there an aspect within orb?
		if ($da <= $orb) $q = 1;
		else if (($da <= (60 + $orb)) And ($da >= (60 - $orb)))
			$q = 6;
		else if (($da <= (90 + $orb)) And ($da >= (90 - $orb)))
			$q = 4;
		else if (($da <= (120 + $orb)) And ($da >= (120 - $orb)))
			$q = 3;
		else if (($da <= (150 + $orb)) And ($da >= (150 - $orb)))
			$q = 5;
		else if ($da >= (180 - $orb))
			$q = 2;

		if ($q > 0) {
			$dashed = false;
			if ($q == 1 Or $q == 3 Or $q == 6) $aspect_color = $blue;
			else if ($q == 4 Or $q == 2) $aspect_color = $red;
			else if ($q == 5) {
				$aspect_color = $green;
				$dashed = true;
			}

			if ($q != 1) {
				//non-conjunctions
				$x1 = (-$radius + $inner_diameter_offset) * cos(deg2rad($planet_angle[$sort_pos[$i]] - $Ascendant));
				$y1 = ($radius - $inner_diameter_offset) * sin(deg2rad($planet_angle[$sort_pos[$i]] - $Ascendant));
				$x2 = (-$radius + $inner_diameter_offset) * cos(deg2rad($planet_angle[$sort_pos[$j]] - $Ascendant));
				$y2 = ($radius - $inner_diameter_offset) * sin(deg2rad($planet_angle[$sort_pos[$j]] - $Ascendant));

				if ($dashed == true) imagedashedline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $aspect_color);
				else imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $aspect_color);
			}
		}
	}
}


// draw the image in png format - using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
exit();
