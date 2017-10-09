<?php
  include("constants.php");
  $last_planet_num = LAST_PLANET + 2;

  $rx1 = safeEscapeString($_GET["rx1"]);
  $ubt1 = safeEscapeString($_GET["ubt1"]);
  $rx2 = safeEscapeString($_GET["rx2"]);
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

// set the content-type
  header("Content-type: image/png");

// create the blank image
  $overall_size_h = 730;
  $overall_size_v = 400;
  $im = @imagecreatetruecolor($overall_size_h, $overall_size_v) or die("Cannot initialize new GD image stream");

// specify the colors
  $white = imagecolorallocate($im, 255, 255, 255);
  $red = imagecolorallocate($im, 255, 0, 0);
  $blue = imagecolorallocate($im, 0, 0, 255);
  $green = imagecolorallocate($im, 0, 224, 0);
  $black = imagecolorallocate($im, 0, 0, 0);
  $orange = imagecolorallocate($im, 255, 127, 0);
  $light_blue = imagecolorallocate($im, 192, 224, 255);
  $light_pink = imagecolorallocate($im, 255, 192, 224);

// specific colors
  $planet_color = $black;

//variables
  $x_offset = 5;
  $y_line_dist1 = 100;
  $y_line_dist2 = 300;
  $y_line_sign_dist1 = 30;
  $y_line_sign_dist2 = 385;
  $h_dist = ($overall_size_h - (2 * $x_offset)) / 360;
  $sign_dist = $h_dist * 30;
  $cw_sign_glyph = 16;

  $num_planets = $last_planet_num + 1;


// ------------------------------------------

// create colored rectangle on blank image
  imagefilledrectangle($im, 0, 0, $overall_size_h, $overall_size_v, $white);

// MUST BE HERE - I DO NOT KNOW WHY - MAYBE TO PRIME THE PUMP
  imagettftext($im, 10, 0, 0, 0, $black, 'arial.ttf', " ");


// ------------------------------------------


// put the signs across the top and bottom of the horizontal lines
  for ($i = 1; $i <= 12; $i++)
  {
    $x1 = $i * $sign_dist - ($sign_dist / 2) - ($cw_sign_glyph / 2);

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

    ImageTTFText($im, 16, 0, $x1 + $x_offset, $y_line_sign_dist1, $clr_to_use, 'HamburgSymbols.ttf', chr($sign_glyph[$i]));
    ImageTTFText($im, 16, 0, $x1 + $x_offset, $y_line_sign_dist2, $clr_to_use, 'HamburgSymbols.ttf', chr($sign_glyph[$i]));
  }


// ------------------------------------------


// create colored rectangles for each house - person 1
  for ($i = 1; $i <= 12; $i++)
  {
    if ($i % 2 == 0)
    {
      $color_to_use = $light_pink;
    }
    else
    {
      $color_to_use = $light_blue;
    }

    $array = imagettfbbox(10, 0, 'arial.ttf', $i);
	$width_of_text = $array[4] - $array[6];

    if (abs($hc1[$i] - $hc1[$i + 1]) < 180)
    {
      $x1 = $hc1[$i] * $h_dist;
      $x2 = $hc1[$i + 1] * $h_dist;
      imagefilledrectangle($im, $x1 + $x_offset, $y_line_dist1 - 10, $x2 + $x_offset, $y_line_dist1 + 10, $color_to_use);

      imagettftext($im, 10, 0, (($x1 + $x2) / 2) + $x_offset - ($width_of_text / 2), $y_line_dist1 + 30, $black, 'arial.ttf', $i);
    }
    else
    {
      // account for wrap-around
      $x1 = $hc1[$i] * $h_dist;
      $x2 = 360 * $h_dist;
      imagefilledrectangle($im, $x1 + $x_offset, $y_line_dist1 - 10, $x2 + $x_offset, $y_line_dist1 + 10, $color_to_use);

      imagettftext($im, 10, 0, (($x1 + $x2) / 2) + $x_offset - ($width_of_text / 2), $y_line_dist1 + 30, $black, 'arial.ttf', $i);

      $x1 = 0 * $h_dist;
      $x2 = $hc1[$i + 1] * $h_dist;
      imagefilledrectangle($im, $x1 + $x_offset, $y_line_dist1 - 10, $x2 + $x_offset, $y_line_dist1 + 10, $color_to_use);

      if ($x1 != $x2)
      {
        imagettftext($im, 10, 0, (($x1 + $x2) / 2) + $x_offset - ($width_of_text / 2), $y_line_dist1 + 30, $black, 'arial.ttf', $i);
      }
    }
  }


// ------------------------------------------


// create colored rectangles for each house - person 2
  for ($i = 1; $i <= 12; $i++)
  {
    if ($i % 2 == 0)
    {
      $color_to_use = $light_pink;
    }
    else
    {
      $color_to_use = $light_blue;
    }

    $array = imagettfbbox(10, 0, 'arial.ttf', $i);
	$width_of_text = $array[4] - $array[6];

    if (abs($hc2[$i] - $hc2[$i + 1]) < 180)
    {
      $x1 = $hc2[$i] * $h_dist;
      $x2 = $hc2[$i + 1] * $h_dist;
      imagefilledrectangle($im, $x1 + $x_offset, $y_line_dist2 - 10, $x2 + $x_offset, $y_line_dist2 + 10, $color_to_use);

      imagettftext($im, 10, 0, (($x1 + $x2) / 2) + $x_offset - ($width_of_text / 2), $y_line_dist2 - 20, $black, 'arial.ttf', $i);
    }
    else
    {
      // account for wrap-around
      $x1 = $hc2[$i] * $h_dist;
      $x2 = 360 * $h_dist;
      imagefilledrectangle($im, $x1 + $x_offset, $y_line_dist2 - 10, $x2 + $x_offset, $y_line_dist2 + 10, $color_to_use);

      imagettftext($im, 10, 0, (($x1 + $x2) / 2) + $x_offset - ($width_of_text / 2), $y_line_dist2 - 20, $black, 'arial.ttf', $i);

      $x1 = 0 * $h_dist;
      $x2 = $hc2[$i + 1] * $h_dist;
      imagefilledrectangle($im, $x1 + $x_offset, $y_line_dist2 - 10, $x2 + $x_offset, $y_line_dist2 + 10, $color_to_use);

      if ($x1 != $x2)
      {
        imagettftext($im, 10, 0, (($x1 + $x2) / 2) + $x_offset - ($width_of_text / 2), $y_line_dist2 - 20, $black, 'arial.ttf', $i);
      }
    }
  }


// ------------------------------------------


// draw both horizonal lines
  imagesetthickness($im, 2);
  imageline($im, $x_offset, $y_line_dist1, $overall_size_h - $x_offset, $y_line_dist1, $black);
  imageline($im, $x_offset, $y_line_dist2, $overall_size_h - $x_offset, $y_line_dist2, $black);
  imagesetthickness($im, 1);


// ------------------------------------------


// draw deg lines across the length of the horizontal lines
  $spoke_length = 9;
  $minor_spoke_length = 4;
  for ($i = 0; $i <= 360; $i = $i + 1)
  {
    if ($i % 30 == 0)
    {
      $y1 = -$spoke_length;
      $y2 = $spoke_length * 2;
    }
    elseif ($i % 5 == 0)
    {
      $y1 = -$spoke_length;
      $y2 = $spoke_length;
    }
    else
    {
      $y1 = -$minor_spoke_length;
      $y2 = $minor_spoke_length;
    }

    imageline($im, $i * $h_dist + $x_offset, $y_line_dist1 + $y1, $x_offset + $i * $h_dist, $y_line_dist1 + $y2, $black);

    if ($i % 30 == 0)
    {
      $y1 = -$spoke_length * 2;
      $y2 = $spoke_length;
    }
    imageline($im, $i * $h_dist + $x_offset, $y_line_dist2 + $y1, $x_offset + $i * $h_dist, $y_line_dist2 + $y2, $black);
  }


// ------------------------------------------


// put planets in chartwheel - person 1
  // sort longitudes in descending order from 360 down to 0
  Sort_planets_by_descending_longitude($num_planets, $longitude1, $sort1, $sort_pos1);

  $flag = False;
  for ($i = $num_planets - 1; $i >= 0; $i--)
  {
    if ($ubt1 == 1 And $sort_pos1[$i] > SE_TNODE)
    {
      continue;
    }

    // $sort1[] holds longitudes in descending order from 360 down to 0
    // $sort_pos1[] holds the planet number corresponding to that longitude
    $x1 = ($sort1[$i] * $h_dist) - ($cw_sign_glyph / 2);

    if ($flag == False)
    {
      imagettftext($im, 16, 0, $x1 + $x_offset, $y_line_dist1 - 20, $planet_color, 'HamburgSymbols.ttf', chr($pl_glyph[$sort_pos1[$i]]));
    }
    else
    {
      imagettftext($im, 16, 0, $x1 + $x_offset, $y_line_dist1 - 38, $planet_color, 'HamburgSymbols.ttf', chr($pl_glyph[$sort_pos1[$i]]));
    }


    //draw line from baseline to planet
    $x1 = $sort1[$i] * $h_dist;
    if ($flag == False)
    {
      imageline($im, $x1 + $x_offset, $y_line_dist1 - 18, $x1 + $x_offset, $y_line_dist1, $black);
    }
    else
    {
      imageline($im, $x1 + $x_offset, $y_line_dist1 - 34, $x1 + $x_offset, $y_line_dist1, $black);
    }

    $flag = !$flag;
  }


// ------------------------------------------


// put planets in chartwheel - person 2
  // sort longitudes in descending order from 360 down to 0
  Sort_planets_by_descending_longitude_solar_arcs($num_planets, $longitude2, $sort2, $sort_pos2);

  $flag = False;
  for ($i = $num_planets - 1; $i >= 0; $i--)
  {
    if ($ubt2 == 1 And $sort_pos2[$i] > SE_TNODE)
    {
      continue;
    }

    // $sort2[] holds longitudes in descending order from 360 down to 0
    // $sort_pos2[] holds the planet number corresponding to that longitude
    $x1 = ($sort2[$i] * $h_dist) - ($cw_sign_glyph / 2);

    if ($flag == False)
    {
      imagettftext($im, 16, 0, $x1 + $x_offset, $y_line_dist2 + 37, $planet_color, 'HamburgSymbols.ttf', chr($pl_glyph[$sort_pos2[$i]]));
    }
    else
    {
      imagettftext($im, 16, 0, $x1 + $x_offset, $y_line_dist2 + 55, $planet_color, 'HamburgSymbols.ttf', chr($pl_glyph[$sort_pos2[$i]]));
    }


    //draw line from baseline to planet
    $x1 = $sort2[$i] * $h_dist;
    if ($flag == False)
    {
      imageline($im, $x1 + $x_offset, $y_line_dist2 + 18, $x1 + $x_offset, $y_line_dist2, $black);
    }
    else
    {
      imageline($im, $x1 + $x_offset, $y_line_dist2 + 36, $x1 + $x_offset, $y_line_dist2, $black);
    }

    $flag = !$flag;
  }


// ------------------------------------------


// draw in the aspect lines
  for ($i = 0; $i <= $last_planet_num; $i++)
  {
    for ($j = 0; $j <= $last_planet_num; $j++)
    {
      $q = 0;
      $da = Abs($longitude1[$sort_pos1[$i]] - $longitude2[$sort_pos2[$j]]);

      if ($da > 180)
      {
        $da = 360 - $da;
      }

      $orb = 1;

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

        if ($q != 0)
        {
          $x1 = $sort1[$i] * $h_dist;
          $x2 = $sort2[$j] * $h_dist;

          if ($sort_pos1[$i] <= SE_CHIRON And $sort_pos2[$j] <= SE_CHIRON)
          {
            imageline($im, $x1 + $x_offset, $y_line_dist1, $x2 + $x_offset, $y_line_dist2, $aspect_color);
          }
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
// load all $longitude[] into sort[] and keep track of the planet numbers in $sort_pos[]
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



Function Sort_planets_by_descending_longitude_solar_arcs($num_planets, $longitude, &$sort, &$sort_pos)
{
// load all $longitude[] into sort[] and keep track of the planet numbers in $sort_pos[]
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

?>
