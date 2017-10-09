<?php
  include ('header_moon.html');

  $num_days = 5;

  $start_month = gmdate("m");
  $start_day = gmdate("d");
  $start_year = gmdate("Y");

  $hour2 = gmdate("H");
  $minute2 = gmdate("i");

  $timezone2 = 0;

  // Unset any variables not initialized elsewhere in the program
  unset($PATH,$out,$pl_name,$t_longitude, $t_speed);

  $swephsrc = 'sweph';
  $sweph = 'sweph';

  putenv("PATH=$PATH:$swephsrc");


  include("constants.php");			// this is here because we must name the planet names, 0 - 12, Sun - True Node


  Moon_Aspectarian($pl_name, $start_month, $start_day, $start_year, $num_days, $timezone, $pl_ephem_number, $aspects_defined);

  @mail(EMAIL, "Moon Aspects", "");

  include("footer.html");
  exit();


Function Moon_Aspectarian($pl_name, $init_month, $init_day, $init_year, $num_days, $timezone, $pl_ephem_number, $aspects_defined)
{
  $num_t_planets = 13;

  $current_tz = $timezone;

  //find Julian day for transit date (at midnight)
  $starting_JD = gregoriantojd($init_month, $init_day, $init_year) - 0.5;
  $ending_JD = $starting_JD + $num_days - 1;

  unset($moon_asp_details, $num_moon_aspects);
  $num_moon_aspects = 0;
  global $num_moon_aspects, $moon_asp_details;

  //find when Moon enters new sign
  for ($x = 0; $x <= 11; $x++)
  {
    $p1_idx = $pl_ephem_number[1];		//Moon index into Swiss ephemeris - for calculating new planet position
    Get_when_planet_is_at_certain_degree_VOC($x, $p1_idx, $pl_name, $starting_JD, $ending_JD, $current_tz);
  }

  //start aspectarian - transit to transit
  for ($x = 1; $x <= 1; $x++)
  {
    for ($y = 0; $y <= $num_t_planets - 1; $y++)
    {
      if ($y != 1 And $y != 11 And $y != 12)
      {
        $p1_idx = $pl_ephem_number[$x];		//planet index into Swiss ephemeris - for calculating new planet position
        $p2_idx = $pl_ephem_number[$y];

        Print_Moon_Aspectarian($x, $y, $p1_idx, $p2_idx, $pl_name, $aspects_defined, $starting_JD, $ending_JD, $num_days, $current_tz);
      }
    }
  }

  //sort the aspects found according to earliest time
  for ($x = 1; $x <= $num_moon_aspects - 1; $x++)
  {
    for ($y = $x + 1; $y <= $num_moon_aspects; $y++)
    {
      if ($moon_asp_details[0][$y] < $moon_asp_details[0][$x])
      {
        $temp1 = $moon_asp_details[0][$x];
        $temp2 = $moon_asp_details[1][$x];

        $moon_asp_details[0][$x] = $moon_asp_details[0][$y];
        $moon_asp_details[1][$x] = $moon_asp_details[1][$y];

        $moon_asp_details[0][$y] = $temp1;
        $moon_asp_details[1][$y] = $temp2;
      }
    }
  }

  // display the Moons aspects
  echo "<table align='center' width='50%'><tr><td><font size='2'>";
  for ($x = 1; $x <= $num_moon_aspects; $x++)
  {
    $flag = 0;
    if ($x < $num_moon_aspects)
    {
      if (stristr($moon_asp_details[1][$x + 1], "enters the sign of") == false)
      {
        if (stristr($moon_asp_details[1][$x], "enters the sign of") == false)
        {
          $what_to_print = $moon_asp_details[1][$x];
        }
        else
        {
          $what_to_print = "<b><font color='#ff0000'>**</font>" . $moon_asp_details[1][$x] . "</b>";
        }
      }
      else
      {
        $what_to_print = "<font color='#0000ff'><b>VC </b></font>" . $moon_asp_details[1][$x] . "<br>";
        $flag = 1;
      }
    }
    else
    {
      if (stristr($moon_asp_details[1][$x], "enters the sign of") == false)
      {
        $what_to_print = $moon_asp_details[1][$x];
      }
      else
      {
        $what_to_print = "<b><font color='#ff0000'>**</font>" . $moon_asp_details[1][$x] . "</b>";
      }
    }

    if ($flag == 1)
    {
      echo $what_to_print . "<br><br>";
    }
    else
    {
      echo $what_to_print . "<br>";
      if (jdtogregorian($moon_asp_details[0][$x] + 0.5) != jdtogregorian($moon_asp_details[0][$x + 1] + 0.5))
      {
        echo "<br>";
      }
    }
  }

  echo "<font></td></tr></table><br />";
}

Function Print_Moon_Aspectarian($p1, $p2, $p1_idx, $p2_idx, $pl_name, $aspects_defined, $starting_JD, $ending_JD, $num_days, $current_tz)
{
//Moon aspectarian
  global $num_moon_aspects, $moon_asp_details;

  for ($x = $starting_JD; $x <= $ending_JD; $x++)
  {
    //check for any exact aspect - major aspects only
    for ($q = 1; $q <= 7; $q++)			//$q is aspect number
    {
      if ($q != 2 And $q != 6)
      {
        $angle = $aspects_defined[$q];
        $secant_results = Secant_Method($x, $x + 1, 0.00007, 100, $angle, $p1_idx, $p2_idx, $p2);
        $Result_JD = $secant_results[0];

        $rnd_off = sprintf("%.3f", $Result_JD);
        if ($rnd_off >= $x And $rnd_off < $x + 1)
        {
          $first_date = ConvertJDtoDateandTime($Result_JD, $current_tz);
          $num_moon_aspects = $num_moon_aspects + 1;
          $moon_asp_details[0][$num_moon_aspects] = $Result_JD;
          $moon_asp_details[1][$num_moon_aspects] = Assemble_aspect_string($p1, $q, $p2, $pl_name, $aspects_defined, $first_date, $secant_results);
          break;
        }
      }
    }
  }
}


Function Secant_Method($earlier_jd, $later_jd, $e, $m, $angle, $p1_idx, $p2_idx, $p2)
{
  for ($n = 1; $n <= $m; $n++)
  {
    //get positions of both planets on JD = later_jd and JD = earlier_jd
    $result = Get_2_Planets_geo($later_jd, $p1_idx, $p2_idx);
    $y1 = $result[0];
    $speed1 = $result[1];
    $y2 = $result[2];
    $speed2 = $result[3];

    $result = Get_2_Planets_geo($earlier_jd, $p1_idx, $p2_idx);
    $y3 = $result[0];
    $y4 = $result[2];

    //get distance from exact aspect for both planets on JD = later_jd
    $dayy = $y2 - $y1;
    $da = abs($y2 - $y1);
    if ($da > 180)
    {
      $da = 360 - $da;
    }
    $dist1 = $da - $angle;
    if ($dayy <= -180 Or ($dayy >= 0 And $dayy < 180))
    {
      $dist1 = -$dist1;
    }

    //get distance from exact aspect for both planets on JD = earlier_jd
    $dayy = $y4 - $y3;
    $da = abs($y4 - $y3);
    if ($da > 180)
    {
      $da = 360 - $da;
    }
    $dist2 = $da - $angle;
    if ($dayy <= -180 Or ($dayy >= 0 And $dayy < 180))
    {
      $dist2 = -$dist2;
    }

    if ($dist1 - $dist2 == 0)
    {
      $later_jd = ($later_jd + $earlier_jd) / 2;
      $d = 0;
    }
    else
    {
      $d = (($later_jd - $earlier_jd) / ($dist1 - $dist2)) * $dist1;
    }

    if (abs($dist1 - $dist2) > 20 And $n >= 2)
    {
      //keep from looping needlessly AND
      //protect against case where dist1 = -dist2, which gives false aspect
      //example 21 March 2006 - Moon 120 Mars - there is no trine, but an opposition
      $later_jd = 0;
      break;
    }

    if (abs($d) < $e)
    {
      break;
    }

    $earlier_jd = $later_jd;

    if (abs($d) >= 1.001)
    {
      //out of range - there is no aspect in this time frame (1 day)
      $later_jd = 0;
      break;
    }
    else
    {
      $later_jd = $later_jd - $d;
    }
  }

  $results[0] = $later_jd;
  $results[1] = $y1;
  $results[2] = $speed1;
  $results[3] = $y2;
  $results[4] = $speed2;

  return $results;
}


Function Get_1_Planet_geo($jd, $p_idx)
{
  //get longitude of planet indicated by $p_idx
  $swephsrc = 'sweph';
  $sweph = 'sweph';

  //to account for ephemeris time (delta t added in) instead of universal time
  //I suppose I could fetch delta t exactly, but I do not think it is worth it
  $ejd = $jd + 0.00075388 / 2;

  unset($out,$t_long);
  exec ("swetest -edir$sweph -bj$ejd -p$p_idx -eswe -fls -g, -head", $out);

  // Each line of output data from swetest is exploded into array $row, giving these elements:
  // 0 = longitude
  // 1 = speed
  foreach ($out as $key => $line)
  {
    $row = explode(',',$line);
    $t_long[$key] = $row[0];
    $t_speed[$key] = $row[1];
  };

  $long_speed[0] = $t_long[0];
  $long_speed[1] = $t_speed[0];

  return $long_speed;
}


Function ConvertJDtoDateandTime($Result_JD, $current_tz)
{
  //returns date and time in local time, e.g. 9/3/2007 4:59 am
  //get calendar day - must adjust for the way the PHP function works by adding 0.5 days to the JD of interest
  $jd_to_use = $Result_JD + $current_tz / 24;

  $JDDate = jdtogregorian($jd_to_use + 0.5);

  $fraction = $jd_to_use - floor($jd_to_use);

  if ($fraction < 0.5)
  {
    $am_pm = "pm";
  }
  else
  {
    $fraction = $fraction - 0.5;
    $am_pm = "am";
  }

  $hh = $fraction * 24;
  if ($hh < 1)
  {
    $hh = $hh + 12;
  }

  $mm = $hh - floor($hh);

  if (floor($mm * 60) < 10)
  {
    return $JDDate . " " . floor($hh) . ":0" . floor($mm * 60) . " " . $am_pm . " GMT";
  }
  else
  {
    return $JDDate . " " . floor($hh) . ":" . floor($mm * 60) . " " . $am_pm . " GMT";
  }
}


Function Assemble_aspect_string($x, $q, $y, $pl_name, $aspects_defined, $first_date, $secant_results)
{
  $t = $pl_name[$x] . Attach_sign($x, $secant_results[1], $secant_results[2]) . $aspects_defined[$q] . " " . $pl_name[$y] . Attach_sign($y, $secant_results[3], $secant_results[4]) . " on " . $first_date;

  return $t;
}


Function Attach_sign($p_num, $t_longitude, $t_speed)
{
  $pos = $t_longitude;
  $rx = "  ";
  if ($t_speed < 0)
  {
    $rx = " R";
  }

  $sign_num = floor($pos / 30);

  $zodiac_signs = "AriTauGemCanLeoVirLibScoSagCapAquPis";

  return " in " . substr($zodiac_signs, $sign_num * 3, 3) . " <font color='#ff0000'>" . $rx . "</font> ";			//end with a space
}


Function Get_when_planet_is_at_certain_degree_VOC($deg_idx, $p1_idx, $pl_name, $starting_JD, $ending_JD, $current_tz)
{
//aspectarian for when a planet hits a certain degree of the zodiac
  global $num_moon_aspects, $moon_asp_details;

  $degr = $deg_idx * 30;
  for ($x = $starting_JD; $x <= $ending_JD; $x++)
  {
    $angle = 0;
    $secant_results = Secant_Method_one_degree($x, $x + 1, 0.00007, 100, $angle, $p1_idx, $degr);
    $Result_JD = $secant_results[0];
    $name_of_sign = Get_Name_of_Sign($secant_results[1] + 1);		//add 1 to the longitude so we dont get rounding errors

    $rnd_off = sprintf("%.3f", $Result_JD);
    if ($rnd_off >= $x And $rnd_off < $x + 1)
    {
      $first_date = ConvertJDtoDateandTime($Result_JD, $current_tz);
      $num_moon_aspects = $num_moon_aspects + 1;
      $moon_asp_details[0][$num_moon_aspects] = $Result_JD;
      $moon_asp_details[1][$num_moon_aspects] = "t. Moon enters the sign of $name_of_sign at $first_date";
    }
  }
}


Function Secant_Method_one_degree($earlier_jd, $later_jd, $e, $m, $angle, $p1_idx, $degr)
{
  for ($n = 1; $n <= $m; $n++)
  {
    //get positions of both planets on JD = later_jd and JD = earlier_jd
    $ls = Get_1_Planet_geo($later_jd, $p1_idx);
    $y1 = $ls[0];
    $ls = Get_1_Planet_geo($earlier_jd, $p1_idx);
    $y3 = $ls[0];

    //get distance from exact aspect for both planets on JD = later_jd
    $dayy = $degr - $y1;
    $da = abs($degr - $y1);
    if ($da > 180)
    {
      $da = 360 - $da;
    }
    $dist1 = $da - $angle;
    if ($dayy <= -180 Or ($dayy >= 0 And $dayy < 180))
    {
      $dist1 = -$dist1;
    }

    //get distance from exact aspect for both planets on JD = earlier_jd
    $dayy = $degr - $y3;
    $da = abs($degr - $y3);
    if ($da > 180)
    {
      $da = 360 - $da;
    }
    $dist2 = $da - $angle;
    if ($dayy <= -180 Or ($dayy >= 0 And $dayy < 180))
    {
      $dist2 = -$dist2;
    }

    if ($dist1 - $dist2 == 0)
    {
      $later_jd = ($later_jd + $earlier_jd) / 2;
      $d = 0;
    }
    else
    {
      $d = (($later_jd - $earlier_jd) / ($dist1 - $dist2)) * $dist1;
    }

    if (abs($dist1 - $dist2) > 20 And $n >= 2)
    {
      //keep from looping needlessly AND
      //protect against case where dist1 = -dist2, which gives false aspect
      //example 21 March 2006 - Moon 120 Mars - there is no trine, but an opposition
      $later_jd = 0;
      break;
    }

    if (abs($d) < $e)
    {
      break;
    }

    $earlier_jd = $later_jd;

    if (abs($d) >= 1.001)
    {
      //out of range - there is no aspect in this time frame (1 day)
      $later_jd = 0;
      break;
    }
    else
    {
      $later_jd = $later_jd - $d;
    }
  }

  $results[0] = $later_jd;
  $results[1] = $y1;

  return $results;
}


Function Get_Name_of_Sign($degr)
{
  $sign_of = floor($degr / 30) + 1;
  return $name_of_sign[$sign_of];
}


Function Get_2_Planets_geo($jd, $p1_idx, $p2_idx)
{
  //get longitudes of planets indicated by $p1_idx and $p2_idx
  $swephsrc = 'sweph';
  $sweph = 'sweph';

  //to account for ephemeris time (delta t added in) instead of universal time
  //I suppose I could fetch delta t exactly, but I do not think it is worth it
  $ejd = $jd + 0.00075388 / 2;

  unset($out,$t_long);
  exec ("swetest -edir$sweph -bj$ejd -p$p1_idx$p2_idx -eswe -fls -g, -head", $out);

  // Each line of output data from swetest is exploded into array $row, giving these elements:
  // 0 = longitude
  // 1 = speed
  foreach ($out as $key => $line)
  {
    $row = explode(',',$line);
    $t_long[$key] = $row[0];
    $t_speed[$key] = $row[1];
  };

  $result[0] = $t_long[0];		//planet 1
  $result[1] = $t_speed[0];
  $result[2] = $t_long[1];		//planet 2
  $result[3] = $t_speed[1];

  return $result;
}

?>
