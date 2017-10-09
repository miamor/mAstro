<?php
  include("constants.php");

  $solar_arc = safeEscapeString($_GET["sa"]);

  if ($solar_arc < 0 Or $solar_arc >= 360)
  {
    $solar_arc = 0;
  }

  if (get_magic_quotes_gpc())
  {
    $longitude1 = unserialize(stripslashes($_GET["p1"]));
    $hc1 = unserialize(stripslashes($_GET["hc1"]));

    //$longitude2 = unserialize(stripslashes($_GET["p2"]));
    $longitude3 = unserialize(stripslashes($_GET["p3"]));
  }
  else
  {
    $longitude1 = unserialize($_GET["p1"]);
    $hc1 = unserialize($_GET["hc1"]);

    //$longitude2 = unserialize($_GET["p2"]);
    $longitude3 = unserialize($_GET["p3"]);
  }

  $longitude1[LAST_PLANET + 1] = $hc1[1];
  $longitude1[LAST_PLANET + 2] = $hc1[10];

  $Ascendant1 = $hc1[1];

  for ($i = 0; $i <= LAST_PLANET; $i++)
  {
    $longitude2[$i] = Crunch($longitude1[$i] + $solar_arc);
  }

  $longitude2[LAST_PLANET + 1] = Crunch($hc1[1] + $solar_arc);
  $longitude2[LAST_PLANET + 2] = Crunch($hc1[10] + $solar_arc);


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
  $lavender = imagecolorallocate($im, 160, 0, 255);
  $orange = imagecolorallocate($im, 255, 127, 0);
  $light_blue = imagecolorallocate($im, 239, 255, 255);

// specific colors
  $planet_color1 = $black;		//was $cyan;
  $planet_color2 = $red;
  $planet_color3 = $blue;

  $deg_min_color = $black;		//$white;
  $sign_color = $magenta;

  $size_of_rect = $overall_size;		// size of rectangle in which to draw the wheel
  $diameter = 500;						// diameter of circle drawn
  $outer_outer_diameter = 600;			// diameter of circle drawn
  $outer_diameter_distance = ($outer_outer_diameter - $diameter) / 2;	// distance between outer-outer diameter and diameter
  $inner_diameter_offset = 140;			// diameter of circle drawn

  $dist_from_diameter1 = 40;			// distance inner planet glyph is from circumference of wheel
  $dist_from_diameter1a = 12;			// distance inner planet glyph is from circumference of wheel - for line
  $dist_from_diameter1b = 58;			// distance outer planet glyph is from circumference of wheel
  $dist_from_diameter1c = 28;			// distance outer planet glyph is from circumference of wheel - for line

  $dist_from_diameter2 = 75;			// distance inner planet glyph is from circumference of wheel
  $dist_from_diameter2a = 47;			// distance inner planet glyph is from circumference of wheel - for line
  $dist_from_diameter2b = 93;			// distance outer planet glyph is from circumference of wheel
  $dist_from_diameter2c = 63;			// distance outer planet glyph is from circumference of wheel - for line

  $dist_from_diameter3 = 110;			// distance inner planet glyph is from circumference of wheel
  $dist_from_diameter3a = 82;			// distance inner planet glyph is from circumference of wheel - for line
  $dist_from_diameter3b = 128;			// distance outer planet glyph is from circumference of wheel
  $dist_from_diameter3c = 98;			// distance outer planet glyph is from circumference of wheel - for line

  $radius = $diameter / 2;				// radius of circle drawn
  $center_pt = $size_of_rect / 2;		// center of circle

  $last_planet_num = 14 + 2;				//add a planet
  $num_planets = $last_planet_num + 1;

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
  $pl_glyph[13] = 60;		//Part of Fortune - add a planet
  $pl_glyph[14] = 109;		//Vertex
  $pl_glyph[15] = 90;		//Ascendant
  $pl_glyph[16] = 88;		//Midheaven

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
  imagefilledellipse($im, $center_pt, $center_pt, $outer_outer_diameter + 80, $outer_outer_diameter + 80, $light_blue);

// draw the outer-outer circle of the chartwheel
  imagefilledellipse($im, $center_pt, $center_pt, $outer_outer_diameter, $outer_outer_diameter, $white);
  imageellipse($im, $center_pt, $center_pt, $outer_outer_diameter, $outer_outer_diameter, $black);

// draw the outer circle of the chartwheel
  imagefilledellipse($im, $center_pt, $center_pt, $diameter, $diameter, $light_blue);
  imageellipse($im, $center_pt, $center_pt, $diameter, $diameter, $black);

// draw the inner circle of the chartwheel
  imagefilledellipse($im, $center_pt, $center_pt, $diameter - ($inner_diameter_offset * 2), $diameter - ($inner_diameter_offset * 2), $white);
  imageellipse($im, $center_pt, $center_pt, $diameter - ($inner_diameter_offset * 2), $diameter - ($inner_diameter_offset * 2), $black);

// ------------------------------------------

// draw the dividing lines between the signs
  $offset_from_start_of_sign = $Ascendant1 - (floor($Ascendant1 / 30) * 30);

  for ($i = $offset_from_start_of_sign; $i <= $offset_from_start_of_sign + 330; $i = $i + 30)
  {
    $x1 = -$radius * cos(deg2rad($i));
    $y1 = -$radius * sin(deg2rad($i));

    $x2 = -($radius + $outer_diameter_distance) * cos(deg2rad($i));
    $y2 = -($radius + $outer_diameter_distance) * sin(deg2rad($i));

    imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);
  }

// ------------------------------------------

//draw the horizontal line for the Ascendant
  $x1 = -($radius - $inner_diameter_offset) * cos(deg2rad(0));
  $y1 = -($radius - $inner_diameter_offset) * sin(deg2rad(0));

  $x2 = -($radius - 10) * cos(deg2rad(0));
  $y2 = -($radius - 10) * sin(deg2rad(0));

  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $blue);

//draw the arrow for the Ascendant
  $x1 = -($radius - 10);
  $y1 = 30 * sin(deg2rad(0));

  $x2 = -($radius - 30);
  $y2 = 30 * sin(deg2rad(-20));
  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $blue);

  $y2 = 30 * sin(deg2rad(20));
  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $blue);

// ------------------------------------------

// draw the lines for the house cusps
  $spoke_length = 20;
  for ($i = 1; $i <= 12; $i = $i + 1)
  {
    $angle = $Ascendant1 - $hc1[$i];
    $x1 = -$radius * cos(deg2rad($angle));
    $y1 = -$radius * sin(deg2rad($angle));

    $x2 = -($radius - $inner_diameter_offset) * cos(deg2rad($angle));
    $y2 = -($radius - $inner_diameter_offset) * sin(deg2rad($angle));

    if ($i != 1 And $i != 10)
    {
      imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);
    }

    // display the house cusp numbers themselves
    display_house_cusp_number($i, -$angle, $radius - $inner_diameter_offset, $xy);
    imagettftext($im, 10, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $black, 'arial.ttf', $i);
  }

// ------------------------------------------

// draw the near-vertical line for the MC
  $angle = $Ascendant1 - $hc1[10];
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

  $x2 = -($radius - 10) * cos(deg2rad($angle));
  $y2 = -($radius - 10) * sin(deg2rad($angle));

  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $blue);

// draw the arrow for the 10th house cusp (MC)
  $x1 = $x2 + (30 * cos(deg2rad($angle1)));
  $y1 = $y2 + (30 * sin(deg2rad($angle1)));

  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $blue);

  $x1 = $x2 - (30 * cos(deg2rad($angle2)));
  $y1 = $y2 + (30 * sin(deg2rad($angle2)));

  imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $blue);

// ------------------------------------------

// draw the spokes of the wheel
  $spoke_length = 9;
  $minor_spoke_length = 4;
  $cnt = 0;
  for ($i = $offset_from_start_of_sign; $i <= $offset_from_start_of_sign + 359; $i = $i + 1)
  {
    $x1 = -$radius * cos(deg2rad($i));
    $y1 = -$radius * sin(deg2rad($i));

    if ($cnt % 5 == 0)
    {
      $x2 = -($radius - $spoke_length) * cos(deg2rad($i));
      $y2 = -($radius - $spoke_length) * sin(deg2rad($i));
    }
    else
    {
      $x2 = -($radius - $minor_spoke_length) * cos(deg2rad($i));
      $y2 = -($radius - $minor_spoke_length) * sin(deg2rad($i));
    }

    $cnt = $cnt + 1;
    imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);
  }

// ------------------------------------------

// put signs around chartwheel
  $cw_sign_glyph = 14;
  $ch_sign_glyph = 12;
  $gap_sign_glyph = -20;

  for ($i = 1; $i <= 12; $i++)
  {
    $angle_to_use = deg2rad((($i - 1) * 30) + 15 - $Ascendant1);

    $center_pos_x = -$cw_sign_glyph / 2;
    $center_pos_y = $ch_sign_glyph / 2;

    $offset_pos_x = $center_pos_x * cos($angle_to_use);
    $offset_pos_y = $center_pos_y * sin($angle_to_use);

    $x1 = $center_pos_x + $offset_pos_x + ((-$radius + $gap_sign_glyph) * cos($angle_to_use));
    $y1 = $center_pos_y + $offset_pos_y + (($radius - $gap_sign_glyph) * sin($angle_to_use));

    if ($i == 1 Or $i == 5 Or $i == 9)
    {
      $clr_to_use = $red;
    }
    elseif ($i == 2 Or $i == 6 Or $i == 10)
    {
      $clr_to_use = $green;
    }
    elseif ($i == 3 Or $i == 7 Or $i == 11)
    {
      $clr_to_use = $orange;
    }
    elseif ($i == 4 Or $i == 8 Or $i == 12)
    {
      $clr_to_use = $blue;
    }

    drawboldtext($im, 16, 0, $x1 + $center_pt, $y1 + $center_pt, $clr_to_use, 'HamburgSymbols.ttf', chr($sign_glyph[$i]), 1);
  }

// ------------------------------------------

// put planets in chartwheel - person 1 - add planet glyphs around circle
  // sort longitudes in descending order from 360 down to 0
  Sort_planets_by_descending_longitude($num_planets, $longitude1, $sort1, $sort_pos1);

  $flag = False;
  for ($i = $num_planets - 1; $i >= 0; $i--)
  {
    // $sort1() holds longitudes in descending order from 360 down to 0
    // $sort_pos1() holds the planet number corresponding to that longitude
    $angle_to_use = deg2rad($sort1[$i] - $Ascendant1);         // needed for placing info on chartwheel

    if ($flag == False)
    {
      display_planet_glyph($angle_to_use, $radius - $dist_from_diameter1, $xy);
    }
    else
    {
      display_planet_glyph($angle_to_use, $radius - ($dist_from_diameter1b), $xy);
    }

    imagettftext($im, 16, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $planet_color1, 'HamburgSymbols.ttf', chr($pl_glyph[$sort_pos1[$i]]));

    //draw line from planet to circumference
    if ($flag == False)
    {
      $x1 = (-$radius + $dist_from_diameter1a) * cos($angle_to_use);
      $y1 = ($radius - $dist_from_diameter1a) * sin($angle_to_use);
      $x2 = (-$radius + 6) * cos($angle_to_use);
      $y2 = ($radius - 6) * sin($angle_to_use);
    }
    else
    {
      $x1 = (-$radius + $dist_from_diameter1c) * cos($angle_to_use);
      $y1 = ($radius - $dist_from_diameter1c) * sin($angle_to_use);
      $x2 = (-$radius + 6) * cos($angle_to_use);
      $y2 = ($radius - 6) * sin($angle_to_use);
    }

    imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);

    $flag = !$flag;
  }

// ------------------------------------------

// put planets in chartwheel - solar arcs - add planet glyphs around circle
  // sort longitudes in descending order from 360 down to 0
  Sort_planets_by_descending_longitude($num_planets, $longitude2, $sort2, $sort_pos2);

  $flag = False;
  for ($i = $num_planets - 1; $i >= 0; $i--)
  {
    // $sort2() holds longitudes in descending order from 360 down to 0
    // $sort_pos2() holds the planet number corresponding to that longitude
    $angle_to_use = deg2rad($sort2[$i] - $Ascendant1);         // needed for placing info on chartwheel

    if ($flag == False)
    {
      display_planet_glyph($angle_to_use, $radius - $dist_from_diameter2, $xy);
    }
    else
    {
      display_planet_glyph($angle_to_use, $radius - ($dist_from_diameter2b), $xy);
    }

    imagettftext($im, 16, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $planet_color2, 'HamburgSymbols.ttf', chr($pl_glyph[$sort_pos2[$i]]));

    //draw line from planet to circumference
    if ($flag == False)
    {
      $x1 = (-$radius + $dist_from_diameter2a) * cos($angle_to_use);
      $y1 = ($radius - $dist_from_diameter2a) * sin($angle_to_use);
      $x2 = (-$radius + 6) * cos($angle_to_use);
      $y2 = ($radius - 6) * sin($angle_to_use);
    }
    else
    {
      $x1 = (-$radius + $dist_from_diameter2c) * cos($angle_to_use);
      $y1 = ($radius - $dist_from_diameter2c) * sin($angle_to_use);
      $x2 = (-$radius + 6) * cos($angle_to_use);
      $y2 = ($radius - 6) * sin($angle_to_use);
    }

    imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);

    $flag = !$flag;
  }

// ------------------------------------------

// put planets in chartwheel - transits - add planet glyphs around circle
  // sort longitudes in descending order from 360 down to 0
  Sort_planets_by_descending_longitude_transits($num_planets, $longitude3, $sort3, $sort_pos3);

  $flag = False;
  for ($i = $num_planets - 1 - 4; $i >= 0; $i--)
  {
    if ($sort_pos3[$i] > SE_TNODE)
    {
      continue;
    }

    // $sort3() holds longitudes in descending order from 360 down to 0
    // $sort_pos3() holds the planet number corresponding to that longitude
    $angle_to_use = deg2rad($sort3[$i] - $Ascendant1);         // needed for placing info on chartwheel

    if ($flag == False)
    {
      display_planet_glyph($angle_to_use, $radius - $dist_from_diameter3, $xy);
    }
    else
    {
      display_planet_glyph($angle_to_use, $radius - ($dist_from_diameter3b), $xy);
    }

    imagettftext($im, 16, 0, $xy[0] + $center_pt, $xy[1] + $center_pt, $planet_color3, 'HamburgSymbols.ttf', chr($pl_glyph[$sort_pos3[$i]]));

    //draw line from planet to circumference
    if ($flag == False)
    {
      $x1 = (-$radius + $dist_from_diameter3a) * cos($angle_to_use);
      $y1 = ($radius - $dist_from_diameter3a) * sin($angle_to_use);
      $x2 = (-$radius + 6) * cos($angle_to_use);
      $y2 = ($radius - 6) * sin($angle_to_use);
    }
    else
    {
      $x1 = (-$radius + $dist_from_diameter3c) * cos($angle_to_use);
      $y1 = ($radius - $dist_from_diameter3c) * sin($angle_to_use);
      $x2 = (-$radius + 6) * cos($angle_to_use);
      $y2 = ($radius - 6) * sin($angle_to_use);
    }

    imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $black);

    $flag = !$flag;
  }

// ------------------------------------------

// draw in the aspect lines
  for ($i = 0; $i <= $last_planet_num; $i++)
  {
    for ($j = 0; $j <= $last_planet_num - 4; $j++)
    {
      $q = 0;
      $da = Abs($longitude1[$sort_pos1[$i]] - $longitude3[$sort_pos3[$j]]);

      if ($da > 180)
      {
        $da = 360 - $da;
      }

      // set orb - 2 if Sun or Moon, 2 if not Sun or Moon
      if ($sort_pos1[$i] == 0 Or $sort_pos1[$i] == 1 Or $sort_pos3[$j] == 0 Or $sort_pos3[$j] == 1)
      {
        $orb = 2;
      }
      else
      {
        $orb = 2;
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

        if ($q != 1)
        {
          //non-conjunctions
          $x1 = (-$radius + $inner_diameter_offset) * cos(deg2rad($sort1[$i] - $Ascendant1));
          $y1 = ($radius - $inner_diameter_offset) * sin(deg2rad($sort1[$i] - $Ascendant1));
          $x2 = (-$radius + $inner_diameter_offset) * cos(deg2rad($sort3[$j] - $Ascendant1));
          $y2 = ($radius - $inner_diameter_offset) * sin(deg2rad($sort3[$j] - $Ascendant1));

          imageline($im, $x1 + $center_pt, $y1 + $center_pt, $x2 + $center_pt, $y2 + $center_pt, $aspect_color);
        }
      }
    }
  }


  // draw the image in png format - using imagepng() results in clearer text compared with imagejpeg()
  imagepng($im);
  imagedestroy($im);
  exit();


Function safeEscapeString($string)
{
// replace HTML tags '<>' with '[]'
  $temp1 = str_replace("<", "[", $string);
  $temp2 = str_replace(">", "]", $temp1);

// but keep <br> or <br />
// turn <br> into <br /> so later it will be turned into ""
// using just <br> will add extra blank lines
  $temp1 = str_replace("[br]", "<br />", $temp2);
  $temp2 = str_replace("[br /]", "<br />", $temp1);

  if (get_magic_quotes_gpc())
  {
    return $temp2;
  }
  else
  {
    return mysql_escape_string($temp2);
  }
}


Function Sort_planets_by_descending_longitude($num_planets, $longitude, &$sort, &$sort_pos)
{
// load all $longitude() into sort() and keep track of the planet numbers in $sort_pos()
  for ($i = 0; $i <= $num_planets - 1; $i++)
  {
    $sort[$i] = $longitude[$i];
    $sort_pos[$i] = $i;
  }

// do the actual sort
  for ($i = 0; $i <= $num_planets - 1; $i++)
  {
    for ($j = $i + 1; $j <= $num_planets; $j++)
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


Function Sort_planets_by_descending_longitude_transits($num_planets, $longitude, &$sort, &$sort_pos)
{
// load all $longitude() into sort() and keep track of the planet numbers in $sort_pos()
  for ($i = 0; $i <= $num_planets - 1 - 4; $i++)
  {
    $sort[$i] = $longitude[$i];
    $sort_pos[$i] = $i;
  }

// do the actual sort
  for ($i = 0; $i <= $num_planets - 2 - 4; $i++)
  {
    for ($j = $i + 1; $j <= $num_planets -1 - 4; $j++)
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


Function display_planet_glyph($angle_to_use, $radii, &$xy)
{
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


Function display_house_cusp_number($num, $angle, $radii, &$xy)
{
  if ($num < 10)
  {
    $char_width = 10;
  }
  else
  {
  	$char_width = 16;
  }
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
  elseif ($num == 2)
  {
    $x_adj = -cos(deg2rad($angle)) * $half_char_width;
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
    $y_adj = sin(deg2rad($angle)) * $half_char_height;
  }
  elseif ($num == 5)
  {
    $xpos0 = $char_width;
    $x_adj = -cos(deg2rad($angle)) * $half_char_width;
    $ypos0 = $half_char_height;
    $y_adj = sin(deg2rad($angle)) * $half_char_height;
  }
  elseif ($num == 6)
  {
    $xpos0 = $char_width;
    $x_adj = -cos(deg2rad($angle)) * $half_char_width;
    $ypos0 = -$half_char_height;
    $y_adj = sin(deg2rad($angle)) * $half_char_height;
  }
  elseif ($num == 7)
  {
    $x_adj = -cos(deg2rad($angle)) * $char_width;
    $ypos0 = -$half_char_height;
    $y_adj = -sin(deg2rad($angle)) * $half_char_height;
  }
  elseif ($num == 8)
  {
    $x_adj = -cos(deg2rad($angle)) * $char_width;
    $ypos0 = -$half_char_height;
    $y_adj = sin(deg2rad($angle)) * $half_char_height;
  }
  elseif ($num == 9)
  {
    $xpos0 = -$char_width;
    $x_adj = -cos(deg2rad($angle)) * $char_width;
    $ypos0 = -$half_char_height;
    $y_adj = sin(deg2rad($angle)) * $half_char_height;
  }
  elseif ($num == 10)
  {
    $xpos0 = -$char_width;
    $x_adj = -cos(deg2rad($angle)) * $char_width;
    $ypos0 = $half_char_height;
    $y_adj = sin(deg2rad($angle)) * $char_height;
  }
  elseif ($num == 11)
  {
    $xpos0 = -$char_width;
    $x_adj = -cos(deg2rad($angle)) * $char_width;
    $y_adj = sin(deg2rad($angle)) * $char_height;
  }
  elseif ($num == 12)
  {
    $x_adj = -cos(deg2rad($angle)) * $char_width;
    $y_adj = sin(deg2rad($angle)) * $half_char_height;
  }

  $xy[0] = $xpos0 + $x_adj - ($radii * cos(deg2rad($angle)));
  $xy[1] = $ypos0 + $y_adj + ($radii * sin(deg2rad($angle)));;

  return ($xy);
}


Function drawboldtext($image, $size, $angle, $x_cord, $y_cord, $clr_to_use, $fontfile, $text, $boldness)
{
  $_x = array(1, 0, 1, 0, -1, -1, 1, 0, -1);
  $_y = array(0, -1, -1, 0, 0, -1, 1, 1, 1);

  for($n = 0; $n <= $boldness; $n++)
  {
    ImageTTFText($image, $size, $angle, $x_cord+$_x[$n], $y_cord+$_y[$n], $clr_to_use, $fontfile, $text);
  }
}


Function Crunch($x)
{
  if ($x >= 0)
  {
    $y = $x - floor($x / 360) * 360;
  }
  else
  {
    $y = 360 + ($x - ((1 + floor($x / 360)) * 360));
  }

  return $y;
}

?>
