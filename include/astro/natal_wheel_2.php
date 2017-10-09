<?
include '../config.php';

include 'constants.php';

  $retrograde = safeEscapeString($_GET["rx1"]);

  if (get_magic_quotes_gpc())
  {
    $longitude = unserialize(stripslashes($_GET["p1"]));
    $hc = unserialize(stripslashes($_GET["hc1"]));
    $house_pos = unserialize(stripslashes($_GET["hpos"]));
  }
  else
  {
    $longitude = unserialize($_GET["p1"]);
    $hc = unserialize($_GET["hc1"]);
    $house_pos = unserialize($_GET["hpos"]);
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
  $yellow = imagecolorallocate($im, 255, 255, 204);
  $cyan = imagecolorallocate($im, 0, 255, 255);
  $green = imagecolorallocate($im, 0, 224, 0);
  $light_green = imagecolorallocate($im, 153, 255, 153);
  $another_green = imagecolorallocate($im, 0, 128, 0);
  $grey = imagecolorallocate($im, 153, 153, 153);
  $black = imagecolorallocate($im, 0, 0, 0);
  $lavender = imagecolorallocate($im, 160, 0, 255);
  $orange = imagecolorallocate($im, 255, 128, 64);
  $light_blue = imagecolorallocate($im, 239, 255, 255);

// specific colors
  $planet_color = $black;		//was $cyan;
  $deg_min_color = $black;		//$white;
  $sign_color = $magenta;

  $size_of_rect = $overall_size;		// size of rectangle in which to draw the wheel
  $diameter = 520;						// diameter of circle drawn
  $outer_outer_diameter = 600;			// diameter of circle drawn
  $outer_diameter_distance = ($outer_outer_diameter - $diameter) / 2;	// distance between outer-outer diameter and diameter
  $inner_diameter_offset = 125;			// diameter of inner circle drawn
  $inner_diameter_offset_2 = 105;		// diameter of nextmost inner circle drawn
  $dist_from_diameter1 = 32;			// distance inner planet glyph is from circumference of wheel
  $dist_from_diameter1a = 12;			// distance inner planet glyph is from circumference of wheel - for line
  $dist_from_diameter2 = 58;			// distance outer planet glyph is from circumference of wheel
  $dist_from_diameter2a = 28;			// distance outer planet glyph is from circumference of wheel - for line
  $radius = $diameter / 2;				// radius of circle drawn
  $middle_radius = ($outer_outer_diameter + $diameter) / 4 - 3;		//the radius for the middle of the two outer circles
  $center_pt = $size_of_rect / 2;		// center of circle

  $last_planet_num = 14;				//add a planet
  $num_planets = $last_planet_num + 1;
  $spacing = 4;     // spacing between planet glyphs around wheel - this number is really one more than shown here

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
  $pl_glyph[11] = 96;
  $pl_glyph[12] = 141;
  $pl_glyph[13] = 60;
  $pl_glyph[14] = 109;


// FOR DEBUG
  $in_debug = False;

  if ($in_debug == True)
  {
    $Ascendant = 237.166;

    $hc[1] = 237.166;
    $hc[2] = 267.25;
    $hc[3] = 300.37;
    $hc[4] = 334.73;
    $hc[5] = 6.62;
    $hc[6] = 33.84;
    $hc[7] = 57.166;
    $hc[8] = 87.25;
    $hc[9] = 120.37;
    $hc[10] = 154.73;
    $hc[11] = 186.62;
    $hc[12] = 213.84;

    $retrograde = "rrrrrrrrrrrrrrr";

    $longitude[0] = 179.33;
    $longitude[1] = 181.9;
    $longitude[2] = 198.97;
    $longitude[3] = 219.45;
    $longitude[4] = 129.86;
    $longitude[5] = 292.37;
    $longitude[6] = 162.13;
    $longitude[7] = 94.76;
    $longitude[8] = 194.33;
    $longitude[9] = 137.42;
    $longitude[10] = 244.166;
    $longitude[11] = 17.166;
    $longitude[12] = 16.66;
    $longitude[13] = 239.75;
    $longitude[14] = 109.85;

    $house_pos[0] = 10;
    $house_pos[1] = 10;
    $house_pos[2] = 11;
    $house_pos[3] = 12;
    $house_pos[4] = 9;
    $house_pos[5] = 2;
    $house_pos[6] = 10;
    $house_pos[7] = 8;
    $house_pos[8] = 11;
    $house_pos[9] = 9;
    $house_pos[10] = 1;
    $house_pos[11] = 5;
    $house_pos[12] = 5;
    $house_pos[13] = 1;
    $house_pos[14] = 8;

//  $pl_glyph[0] = 81;
//  $pl_glyph[1] = 81;
//  $pl_glyph[2] = 81;
//  $pl_glyph[3] = 81;
//  $pl_glyph[4] = 81;
//  $pl_glyph[5] = 81;
//  $pl_glyph[6] = 81;
//  $pl_glyph[7] = 81;
//  $pl_glyph[8] = 81;
//  $pl_glyph[9] = 81;
//  $pl_glyph[10] = 81;
//  $pl_glyph[11] = 81;
//  $pl_glyph[12] = 81;
//  $pl_glyph[13] = 81;
//  $pl_glyph[14] = 81;
  }

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
  imagefilledellipse($im, $center_pt, $center_pt, $outer_outer_diameter + 80, $outer_outer_diameter + 80, $white);

// draw the outer-outer circle of the chartwheel
  imagefilledellipse($im, $center_pt, $center_pt, $outer_outer_diameter, $outer_outer_diameter, $yellow);
  imageellipse($im, $center_pt, $center_pt, $outer_outer_diameter, $outer_outer_diameter, $black);

// draw the outer circle of the chartwheel
  imagefilledellipse($im, $center_pt, $center_pt, $diameter, $diameter, $white);
  imageellipse($im, $center_pt, $center_pt, $diameter, $diameter, $black);

// draw the inner circle of the chartwheel
  imagefilledellipse($im, $center_pt, $center_pt, $diameter - ($inner_diameter_offset_2 * 2), $diameter - ($inner_diameter_offset_2 * 2), $light_green);
  imagefilledellipse($im, $center_pt, $center_pt, $diameter - ($inner_diameter_offset * 2), $diameter - ($inner_diameter_offset * 2), $white);
  imageellipse($im, $center_pt, $center_pt, $diameter - ($inner_diameter_offset_2 * 2), $diameter - ($inner_diameter_offset_2 * 2), $black);
  imageellipse($im, $center_pt, $center_pt, $diameter - ($inner_diameter_offset * 2), $diameter - ($inner_diameter_offset * 2), $black);

// ------------------------------------------
//FOR DEBUG
//imagettftext($im, 10, 0, 10, 10, $black, 'arial.ttf', $longitude[11]);
//imagettftext($im, 10, 0, 10, 25, $black, 'arial.ttf', $longitude[12]);
// ------------------------------------------

//draw the horizontal line for the Ascendant
  $x1 = -($radius - $inner_diameter_offset) * cos(deg2rad(0));
  $y1 = -($radius - $inner_diameter_offset) * sin(deg2rad(0));

  $x2 = -$radius * cos(deg2rad(0));
  $y2 = -$radius * sin(deg2rad(0));

  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);

//draw the arrow for the Ascendant
  $x1 = -$radius;
  $y1 = 30 * sin(deg2rad(0));

  $x2 = -($radius - 12);
  $y2 = 12 * sin(deg2rad(-15));
  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);

  $y2 = 12 * sin(deg2rad(15));
  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);

// ------------------------------------------

// draw in the actual house cusp numbers and sign
  for ($i = 1; $i <= 12; $i = $i + 1)
  {
    $angle = -($Ascendant - $hc[$i]);

    $sign_pos = floor($hc[$i] / 30) + 1;
    if ($sign_pos == 1 Or $sign_pos == 5 Or $sign_pos == 9)
    {
      $clr_to_use = $red;
    }
    elseif ($sign_pos == 2 Or $sign_pos == 6 Or $sign_pos == 10)
    {
      $clr_to_use = $another_green;
    }
    elseif ($sign_pos == 3 Or $sign_pos == 7 Or $sign_pos == 11)
    {
      $clr_to_use = $orange;
    }
    elseif ($sign_pos == 4 Or $sign_pos == 8 Or $sign_pos == 12)
    {
      $clr_to_use = $blue;
    }

    // sign glyph
    display_house_cusp($i, $angle, $middle_radius, $xy);
    imagettftext($im, 14, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $clr_to_use, 'HamburgSymbols.ttf', chr($sign_glyph[$sign_pos]));

    // house cusp degree
    if ($i >= 1 And $i <= 6)
    {
      display_house_cusp($i, $angle - 4, $middle_radius, $xy);
    }
    else
    {
      display_house_cusp($i, $angle + 5, $middle_radius, $xy);
    }

    $reduced_pos = Reduce_below_30($hc[$i]);
    $int_reduced_pos = floor($reduced_pos);
    if ($int_reduced_pos < 10)
    {
      $t = "0" . $int_reduced_pos;
    }
    else
    {
      $t = $int_reduced_pos;
    }

    imagettftext($im, 10, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $black, 'arial.ttf', $t . chr(176));

    // house cusp minute
    if ($i >= 1 And $i <= 4)
    {
      display_house_cusp($i, $angle + 4, $middle_radius, $xy);
    }
    elseif ($i == 5 Or $i == 6)
    {
      display_house_cusp($i, $angle + 5, $middle_radius, $xy);
    }
    elseif ($i == 7)
    {
      display_house_cusp($i, $angle - 4, $middle_radius, $xy);
    }
    else
    {
      display_house_cusp($i, $angle - 5, $middle_radius, $xy);
    }

    $reduced_pos = Reduce_below_30($hc[$i]);
    $int_reduced_pos = floor(60 * ($reduced_pos - floor($reduced_pos)));
    if ($int_reduced_pos < 10)
    {
      $t = "0" . $int_reduced_pos;
    }
    else
    {
      $t = $int_reduced_pos;
    }
    imagettftext($im, 10, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $black, 'arial.ttf', $t . chr(39));
  }

// ------------------------------------------

// draw the lines for the house cusps
  $spoke_length = 20;
  for ($i = 1; $i <= 12; $i = $i + 1)
  {
    $angle = $Ascendant - $hc[$i];
    $x1 = -$radius * cos(deg2rad($angle));
    $y1 = -$radius * sin(deg2rad($angle));

    $x2 = -($radius - $inner_diameter_offset) * cos(deg2rad($angle));
    $y2 = -($radius - $inner_diameter_offset) * sin(deg2rad($angle));

    if ($i != 1 And $i != 10)
    {
      imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $grey);
    }

    // display the house numbers themselves
    display_house_number($i, -$angle, $radius - $inner_diameter_offset, $xy);
    imagettftext($im, 10, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $black, 'arial.ttf', $i);
  }

// ------------------------------------------

// draw the near-vertical line for the MC
  $angle = $Ascendant - $hc[10];
  $dist_mc_asc = $angle;

  if ($dist_mc_asc < 0)
  {
    $dist_mc_asc = $dist_mc_asc + 360;
  }

  $value = 90 - $dist_mc_asc;
  $angle1 = 65 - $value;
  $angle2 = 65 + $value;

  $x1 = -($radius - $inner_diameter_offset) * cos(deg2rad($angle));
  $y1 = -($radius - $inner_diameter_offset) * sin(deg2rad($angle));

  $x2 = -$radius * cos(deg2rad($angle));
  $y2 = -$radius * sin(deg2rad($angle));

  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);

// draw the arrow for the 10th house cusp (MC)
  $x1 = $x2 + (15 * cos(deg2rad($angle1)));
  $y1 = $y2 + (15 * sin(deg2rad($angle1)));
  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);

  $x1 = $x2 - (15 * cos(deg2rad($angle2)));
  $y1 = $y2 + (15 * sin(deg2rad($angle2)));
  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);

// ------------------------------------------

// put planets in chartwheel
  // sort longitudes in descending order from 360 down to 0
  Sort_planets_by_descending_longitude($num_planets, $longitude, $sort, $sort_pos);

  // count how many planets are in each house
  Count_planets_in_each_house($num_planets, $house_pos, $sort_pos, $sort, $nopih, $home);

  for ($i = 0; $i <= 359; $i++)
  {
    $spot_filled[$i] = 0;
  }

  $house_num = 0;

  // add planet glyphs around circle
  for ($i = $num_planets - 1; $i >= 0; $i--)
  // FOR DEBUG
  //for ($i = 2; $i >= 0; $i--)
  {
    // $sort() holds longitudes in descending order from 360 down to 0
    // $sort_pos() holds the planet number corresponding to that longitude
    $temp = $house_num;
    $house_num = $house_pos[$sort_pos[$i]];              // get the house this planet is in

    if ($temp != $house_num)
    {
      // this planet is in a different house than the last one - this planet is the first one in this house, in other words
      $planets_done = 1;
    }

    // get index for this planet as to where it should be in the possible xx different positions around the wheel
    $from_cusp = Crunch($sort[$i] - $hc[$house_num]);
    $to_next_cusp = Crunch($hc[$house_num + 1] - $sort[$i]);
    $next_cusp = $hc[$house_num + 1];

    $angle = $sort[$i];
    $how_many_more_can_fit_in_this_house = floor($to_next_cusp / ($spacing + 1));


// FOR DEBUG
//if ($i ==2)
//{
//imagettftext($im, 10, 0, 10, 10, $black, 'arial.ttf', $angle);
//imagettftext($im, 10, 0, 10, 20, $black, 'arial.ttf', $from_cusp);
//imagettftext($im, 10, 0, 10, 30, $black, 'arial.ttf', $to_next_cusp);
//imagettftext($im, 10, 0, 10, 40, $black, 'arial.ttf', $next_cusp);
//imagettftext($im, 10, 0, 10, 50, $black, 'arial.ttf', $house_num);
//imagettftext($im, 10, 0, 10, 60, $black, 'arial.ttf', $nopih[$house_num]);
//imagettftext($im, 10, 0, 10, 70, $black, 'arial.ttf', $planets_done);
//imagettftext($im, 10, 0, 10, 80, $black, 'arial.ttf', $how_many_more_can_fit_in_this_house);

//imagettftext($im, 10, 0, 10, 100, $black, 'arial.ttf', $sort[0]);
//imagettftext($im, 10, 0, 10, 110, $black, 'arial.ttf', $sort[1]);
//imagettftext($im, 10, 0, 10, 120, $black, 'arial.ttf', $sort[2]);
//imagettftext($im, 10, 0, 10, 130, $black, 'arial.ttf', $sort[3]);
//}

    if ($nopih[$house_num] - $planets_done > $how_many_more_can_fit_in_this_house)
    {
      // problem - adjust this planet backwards so others can fit
      $angle = Crunch($next_cusp - (($nopih[$house_num] - $planets_done) * ($spacing + 1)));

// FOR DEBUG
//if ($i ==2)
//{
//imagettftext($im, 10, 0, 10, 150, $black, 'arial.ttf', $angle);
//}

    }

    while (Check_for_overlap($angle, $spot_filled, $spacing) == True)
    {
      $angle = $angle + 1;
    }

    // mark this position as being filled
    $spot_filled[round($angle)] = 1;
    $spot_filled[Crunch(round($angle) - 1)] = 1;	// allows for a little better separation between Mars and Sun on 3/13/1966 test example

    // take the above index and convert it into an angle
    $planet_angle[$sort_pos[$i]] = $angle;              // needed for aspect lines
    $angle_to_use = Crunch($angle - $Ascendant);     	// needed for placing info on chartwheel
    $our_angle = $angle_to_use;			                // in degrees

    $angle_to_use = deg2rad($angle_to_use);

    // denote that we have done at least one planet in this house (actually count the planets in this house that we have done)
    $planets_done++;

    display_planet_glyph($our_angle, $angle_to_use, $radius - $dist_from_diameter1, $xy, 0);
    imagettftext($im, 16, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $planet_color, 'HamburgSymbols.ttf', chr($pl_glyph[$sort_pos[$i]]));

    // display degrees of longitude for each planet
    $reduced_pos = Reduce_below_30($sort[$i]);
    $int_reduced_pos = floor($reduced_pos);
    if ($int_reduced_pos < 10)
    {
      $t = "0" . $int_reduced_pos;
    }
    else
    {
      $t = $int_reduced_pos;
    }

    display_planet_glyph($our_angle, $angle_to_use, $radius - $dist_from_diameter1 - 20, $xy, 1);
    imagettftext($im, 10, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $planet_color, 'arial.ttf', $t . chr(176));

    // display planet sign
    $sign_pos = floor($sort[$i] / 30) + 1;
    display_planet_glyph($our_angle, $angle_to_use, $radius - $dist_from_diameter1 - 40, $xy, 2);
    if ($sign_pos == 1 Or $sign_pos == 5 Or $sign_pos == 9)
    {
      $clr_to_use = $red;
    }
    elseif ($sign_pos == 2 Or $sign_pos == 6 Or $sign_pos == 10)
    {
      $clr_to_use = $another_green;
    }
    elseif ($sign_pos == 3 Or $sign_pos == 7 Or $sign_pos == 11)
    {
      $clr_to_use = $orange;
    }
    elseif ($sign_pos == 4 Or $sign_pos == 8 Or $sign_pos == 12)
    {
      $clr_to_use = $blue;
    }
    imagettftext($im, 10, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $clr_to_use, 'HamburgSymbols.ttf', chr($sign_glyph[$sign_pos]));

    // display minutes of longitude for each planet
    $int_reduced_pos = floor(60 * ($reduced_pos - floor($reduced_pos)));
    if ($int_reduced_pos < 10)
    {
      $t = "0" . $int_reduced_pos;
    }
    else
    {
      $t = $int_reduced_pos;
    }
    display_planet_glyph($our_angle, $angle_to_use, $radius - $dist_from_diameter1 - 60, $xy, 1);
    imagettftext($im, 10, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $planet_color, 'arial.ttf', $t . chr(39));

    // display Rx symbol
    if (strtoupper(mid($retrograde, $sort_pos[$i] + 1, 1)) == "R")
    {
      display_planet_glyph($our_angle, $angle_to_use, $radius - $dist_from_diameter1 - 77, $xy, 3);
      imagettftext($im, 10, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $red, 'HamburgSymbols.ttf', chr(62));
    }
  }

// ------------------------------------------

// draw in the aspect lines
  for ($i = 0; $i <= $last_planet_num - 1; $i++)
  {
    for ($j = $i + 1; $j <= $last_planet_num; $j++)
    {
      $q = 0;
      $da = Abs($longitude[$sort_pos[$i]] - $longitude[$sort_pos[$j]]);

      if ($da > 180)
      {
        $da = 360 - $da;
      }

      // set orb - 8 if Sun or Moon, 6 if not Sun or Moon
      if ($sort_pos[$i] == SE_SUN Or $sort_pos[$i] == SE_MOON Or $sort_pos[$j] == SE_SUN Or $sort_pos[$j] == SE_MOON)
      {
        $orb = 8;
      }
      else
      {
        $orb = 6;
      }

      // is there an aspect within orb?
      if ($da <= $orb)
      {
        $q = 1;
      }
      elseif (($da <= (60 + $orb)) And ($da >= (60 - $orb)))
      {
        $q = 6;
      }
      elseif (($da <= (90 + $orb)) And ($da >= (90 - $orb)))
      {
        $q = 4;
      }
      elseif (($da <= (120 + $orb)) And ($da >= (120 - $orb)))
      {
        $q = 3;
      }
      elseif (($da <= (150 + $orb)) And ($da >= (150 - $orb)))
      {
        $q = 5;
      }
      elseif ($da >= (180 - $orb))
      {
        $q = 2;
      }

      if ($q > 0)
      {
        if ($q == 1 Or $q == 3 Or $q == 6)
        {
          $aspect_color = $green;
        }
        elseif ($q == 4 Or $q == 2)
        {
          $aspect_color = $red;
        }
        elseif ($q == 5)
        {
          $aspect_color = $blue;
        }

        if ($q != 1 And $sort_pos[$i] != SE_VERTEX And $sort_pos[$j] != SE_VERTEX And $sort_pos[$i] != SE_LILITH And $sort_pos[$j] != SE_LILITH And $sort_pos[$i] != SE_POF And $sort_pos[$j] != SE_POF)
        {
          //non-conjunctions
          $x1 = (-$radius + $inner_diameter_offset) * cos(deg2rad($planet_angle[$sort_pos[$i]] - $Ascendant));
          $y1 = ($radius - $inner_diameter_offset) * sin(deg2rad($planet_angle[$sort_pos[$i]] - $Ascendant));
          $x2 = (-$radius + $inner_diameter_offset) * cos(deg2rad($planet_angle[$sort_pos[$j]] - $Ascendant));
          $y2 = ($radius - $inner_diameter_offset) * sin(deg2rad($planet_angle[$sort_pos[$j]] - $Ascendant));

          imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $aspect_color);
        }
      }
    }
  }


  // draw the image in png format - using imagepng() results in clearer text compared with imagejpeg()
  imagepng($im);
  imagedestroy($im);
  exit();


Function Sort_planets_by_descending_longitude($num_planets, $longitude, &$sort, &$sort_pos)
{
// load all $longitude() into sort() and keep track of the planet numbers in $sort_pos()
  for ($i = 0; $i <= $num_planets - 1; $i++)
  {
    $sort[$i] = $longitude[$i];
    $sort_pos[$i] = $i;
  }

// do the actual sort
  for ($i = 0; $i <= $num_planets - 2; $i++)
  {
    for ($j = $i + 1; $j <= $num_planets - 1; $j++)
    {
      if ($sort[$j] > $sort[$i])
      {
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


Function Count_planets_in_each_house($num_planets, $house_pos, &$sort_pos, &$sort, &$nopih, &$home)
{
// reset and count the number of planets in each house
  for ($i = 1; $i <= 12; $i++)
  {
    $nopih[$i] = 0;
  }

// run through all the planets and see how many planets are in each house
  for ($i = 0; $i <= $num_planets - 1; $i++)
  {
    // get house planet is in
    $temp = $house_pos[$sort_pos[$i]];
    $nopih[$temp]++;
    $home[$i] = $temp;
  }

  // now check for Aries planets in same house as Pisces planets that do not start a new house
  while ($home[$num_planets - 1] == $home[0])
  {
    $temp1 = $sort[$num_planets - 1];
    $temp2 = $sort_pos[$num_planets - 1];
    $temp3 = $home[$num_planets - 1];

    for ($i = $num_planets - 1; $i >= 1; $i--)
    {
      $sort[$i] = $sort[$i - 1];
      $sort_pos[$i] = $sort_pos[$i - 1];
      $home[$i] = $home[$i - 1];
    }

    $sort[0] = $temp1;
    $sort_pos[0] = $temp2;
    $home[0] = $temp3;
  }
}


Function display_house_number($num, $angle, $radii, &$xy)
{
  if ($num < 10)
  {
    $char_width = 10;
  }
  else
  {
  	$char_width = 18;
  }
  $half_char_width = $char_width / 2;
  $char_height = 12;
  $half_char_height = $char_height / 2;

//puts center of character right on circumference of circle
  $xpos0 = -$half_char_width;
  $ypos0 = $char_height;

  if ($num == 1)
  {
    $x_adj = -cos(deg2rad($angle)) * $half_char_width;
    $y_adj = sin(deg2rad($angle)) * $char_height;
  }
  elseif ($num == 2)
  {
    $x_adj = -cos(deg2rad($angle));// * $char_width;
    $y_adj = sin(deg2rad($angle)) * $char_height;
  }
  elseif ($num == 3)
  {
    $xpos0 = $half_char_width;
    $x_adj = -cos(deg2rad($angle)) * $half_char_width;
    $y_adj = sin(deg2rad($angle)) * $half_char_height;
  }
  elseif ($num == 4)
  {
    $xpos0 = $char_width;
    $x_adj = -cos(deg2rad($angle)) * $half_char_width;
    $ypos0 = $half_char_height;
    $y_adj = sin(deg2rad($angle)) * $half_char_height;
  }
  elseif ($num == 5)
  {
    $xpos0 = $half_char_width;
    $x_adj = -cos(deg2rad($angle)) * $half_char_width;
    $ypos0 = $half_char_height;
    $y_adj = sin(deg2rad($angle)) * $half_char_height;
  }
  elseif ($num == 6)
  {
    $xpos0 = $half_char_width;
    $x_adj = -cos(deg2rad($angle));	// * $half_char_width;
    //$ypos0 = -$half_char_height;
    $y_adj = sin(deg2rad($angle)) * char_height;
  }
  elseif ($num == 7)
  {
    $x_adj = -cos(deg2rad($angle)) * $char_width;
    $ypos0 = -$half_char_height;
    $y_adj = -sin(deg2rad($angle)) * $char_height;
  }
  elseif ($num == 8)
  {
    $x_adj = -cos(deg2rad($angle)) * $half_char_width;
    $ypos0 = -$half_char_height;
    $y_adj = sin(deg2rad($angle));		// * $half_char_height;
  }
  elseif ($num == 9)
  {
    $xpos0 = -$char_width;
    $x_adj = -cos(deg2rad($angle)) * $char_width;
    $ypos0 = -$half_char_height;
    $y_adj = sin(deg2rad($angle));	// * $half_char_height;
  }
  elseif ($num == 10)
  {
    $xpos0 = -$char_width;
    $x_adj = -cos(deg2rad($angle)) * $char_width;
    $ypos0 = $half_char_height;
    $y_adj = sin(deg2rad($angle)) * $half_char_height;
  }
  elseif ($num == 11)
  {
    $xpos0 = -$half_char_width;
    $x_adj = -cos(deg2rad($angle)) * $half_char_width;
    $y_adj = sin(deg2rad($angle)) * $char_height;
  }
  elseif ($num == 12)
  {
    $x_adj = -cos(deg2rad($angle)) * $half_char_width;
    $y_adj = sin(deg2rad($angle)) * $char_height;
  }

  $xy[0] = $xpos0 + $x_adj - ($radii * cos(deg2rad($angle + 12)));
  $xy[1] = $ypos0 + $y_adj + ($radii * sin(deg2rad($angle + 12)));;

  return ($xy);
}



Function display_planet_glyph($our_angle, $angle_to_use, $radii, &$xy, $code)
{
// $code = 0 for planet glyph, 1 for text, 2 for sign glyph, 3 for Rx symbol
// $our_angle in degree, $angle_to_use in radians
  $this_angle = Crunch($our_angle);

  if ($this_angle >= 1 And $this_angle <= 181)
  {
    if ($code == 0)
    {
      $cw_pl_glyph = 17;
      $ch_pl_glyph = 17;
    }
    elseif ($code == 1)
    {
      $cw_pl_glyph = 14;
      $ch_pl_glyph = 12;
    }
    elseif ($code == 2)
    {
      $cw_pl_glyph = 14;
      $ch_pl_glyph = 12;
    }
    else
    {
      $cw_pl_glyph = 8;
      $ch_pl_glyph = 10;
    }
  }
  else
  {
    if ($code == 0)
    {
      $cw_pl_glyph = 13;
      $ch_pl_glyph = 17;
    }
    elseif ($code == 1)
    {
      $cw_pl_glyph = 8;
      $ch_pl_glyph = 8;
    }
    elseif ($code == 2)
    {
      $cw_pl_glyph = 8;
      $ch_pl_glyph = 8;
    }
    else
    {
      $cw_pl_glyph = 6;
      $ch_pl_glyph = 10;
    }
  }

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


Function display_house_cusp($num, $angle, $radii, &$xy)
{
  $char_width = 18;
  $half_char_width = $char_width / 2;
  $char_height = 12;
  $half_char_height = $char_height / 2;

//puts center of character right on circumference of circle
  $xpos0 = -$half_char_width;
  $ypos0 = $half_char_height;

  $x_adj = -cos(deg2rad($angle));
  $y_adj = sin(deg2rad($angle));

  $xy[0] = $xpos0 + $x_adj - ($radii * cos(deg2rad($angle)));
  $xy[1] = $ypos0 + $y_adj + ($radii * sin(deg2rad($angle)));;

  return ($xy);
}


Function Check_for_overlap($angle, $spot_filled, $spacing)
{
// spacing is really 1 more than we enter with, but we use assign $spacing = 1 less for easier math below
  $result = False;

  for ($i = $angle - $spacing; $i <= $angle + $spacing; $i++)
  {
    if ($spot_filled[Crunch(round($i))] == 1)
    {
      $result = True;
      break;
    }
  }

  return $result;
}

?>
