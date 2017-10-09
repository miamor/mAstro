<?php
  $months = array (0 => 'Choose month', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
  $my_error = "";

  // check if the form has been submitted
  if (isset($_POST['submitted']))
  {
    // get all variables from form
    $month = safeEscapeString($_POST["month"]);
    $day = safeEscapeString($_POST["day"]);
    $year = safeEscapeString($_POST["year"]);

    $timezone = safeEscapeString($_POST["timezone"]);

    $long_deg = safeEscapeString($_POST["long_deg"]);
    $long_min = safeEscapeString($_POST["long_min"]);
    $ew = safeEscapeString($_POST["ew"]);

    $lat_deg = safeEscapeString($_POST["lat_deg"]);
    $lat_min = safeEscapeString($_POST["lat_min"]);
    $ns = safeEscapeString($_POST["ns"]);

    // set cookie containing current location data here
    setcookie ('current_timezone', $timezone, time() + 60 * 60 * 24 * 30, '/', '', 0);

    setcookie ('current_long_deg', $long_deg, time() + 60 * 60 * 24 * 30, '/', '', 0);
    setcookie ('current_long_min', $long_min, time() + 60 * 60 * 24 * 30, '/', '', 0);
    setcookie ('current_ew', $ew, time() + 60 * 60 * 24 * 30, '/', '', 0);

    setcookie ('current_lat_deg', $lat_deg, time() + 60 * 60 * 24 * 30, '/', '', 0);
    setcookie ('current_lat_min', $lat_min, time() + 60 * 60 * 24 * 30, '/', '', 0);
    setcookie ('current_ns', $ns, time() + 60 * 60 * 24 * 30, '/', '', 0);

    include ('header_ph.html');				//here because of setting cookies above

    include("validation_class.php");

    //error check
    $my_form = new Validate_fields;

    $my_form->check_4html = true;

    $my_form->add_text_field("Month", $month, "text", "y", 2);
    $my_form->add_text_field("Day", $day, "text", "y", 2);
    $my_form->add_text_field("Year", $year, "text", "y", 4);

    $my_form->add_text_field("Time zone", $timezone, "text", "y", 4);

    $my_form->add_text_field("Longitude degree", $long_deg, "text", "y", 3);
    $my_form->add_text_field("Longitude minute", $long_min, "text", "y", 2);
    $my_form->add_text_field("Longitude E/W", $ew, "text", "y", 2);

    $my_form->add_text_field("Latitude degree", $lat_deg, "text", "y", 2);
    $my_form->add_text_field("Latitude minute", $lat_min, "text", "y", 2);
    $my_form->add_text_field("Latitude N/S", $ns, "text", "y", 2);

    // additional error checks on user-entered data
    if ($month == 0)
    {
      $my_error .= "Please enter a month.<br>";
    }

    if ($month != "" And $day != "" And $year != "")
    {
      if (!$date = checkdate(settype ($month, "integer"), settype ($day, "integer"), settype ($year, "integer")))
      {
        $my_error .= "The date you entered is not valid.<br>";
      }
    }

    if (($year < 1900) Or ($year >= 2100))
    {
      $my_error .= "Please enter a year between 1900 and 2099.<br>";
    }

    if (($long_deg < 0) Or ($long_deg > 179))
    {
      $my_error .= "Longitude degrees must be between 0 and 179.<br>";
    }

    if (($long_min < 0) Or ($long_min > 59))
    {
      $my_error .= "Longitude minutes must be between 0 and 59.<br>";
    }

    if (($lat_deg < 0) Or ($lat_deg > 65))
    {
      $my_error .= "Latitude degrees must be between 0 and 65.<br>";
    }

    if (($lat_min < 0) Or ($lat_min > 59))
    {
      $my_error .= "Latitude minutes must be between 0 and 59.<br>";
    }

    if (($ew == '-1') And ($timezone > 2))
    {
      $my_error .= "You have marked West longitude but set an east time zone.<br>";
    }

    if (($ew == '1') And ($timezone < 0))
    {
      $my_error .= "You have marked East longitude but set a west time zone.<br>";
    }

    if ($ew < 0)
    {
      $ew_txt = "w";
    }
    else
    {
      $ew_txt = "e";
    }

    if ($ns > 0)
    {
      $ns_txt = "n";
    }
    else
    {
      $ns_txt = "s";
    }

    $validation_error = $my_form->validation();

    if ((!$validation_error) || ($my_error != ""))
    {
      $error = $my_form->create_msg();
      echo "<TABLE align='center' WIDTH='98%' BORDER='0' CELLSPACING='15' CELLPADDING='0'><tr><td><center><b>";
      echo "<font color='#ff0000' size=+2>Error! - The following error(s) occurred:</font><br>";

      if ($error)
      {
        echo $error . $my_error;
      }
      else
      {
        echo $error . "<br>" . $my_error;
      }

      echo "</font>";
      echo "<font color='#c020c0'";
      echo "<br>PLEASE RE-ENTER YOUR TIME ZONE DATA. THANK YOU.<br><br>";
      echo "</font>";
      echo "</b></center></td></tr></table>";
    }
    else
    {
      // no errors in filling out form, so process form
      // calculate astronomic data
      $swephsrc = 'sweph';
      $sweph = 'sweph';

      unset($PATH, $ruling_pl, $pl_hour);

      putenv("PATH=$PATH:$swephsrc");

      $my_longitude = $ew * ($long_deg + ($long_min / 60));
      $my_latitude = $ns * ($lat_deg + ($lat_min / 60));

      $starting_JD = gregoriantojd($month, $day, $year) + ($ew * 0.25);
      $result = exec ("swetest -edir$sweph -bj$starting_JD -eswe -geopos$my_longitude,$my_latitude,400 -rise");


      include("constants.php");			// this is here because of the email address


//FOR DEBUG
//echo $result . "<br><br>";

      $first_colon = strpos($result, ":") + 1;
      $rise_hour = mid($result, $first_colon - 2, 2) + $timezone;
      if ($rise_hour >= 24)
      {
        $rise_hour = $rise_hour - 24;
      }
      $rise_minute = mid($result, $first_colon + 1, 2);

      $second_colon = strpos($result, ":", $first_colon + 1) + 1;
      $rise_seconds = mid($result, $second_colon + 1, 2);

      $third_colon = strpos($result, ":", $second_colon + 1) + 1;
      $set_hour = mid($result, $third_colon - 2, 2) + $timezone;
      if ($set_hour < 0)
      {
        $set_hour = $set_hour + 24;
      }
      $set_minute = mid($result, $third_colon + 1, 2);

      $fourth_colon = strpos($result, ":", $third_colon + 1) + 1;
      $set_seconds = mid($result, $fourth_colon + 1, 2);

      echo "<center>";
      if ($timezone < 0)
      {
        $tz = $timezone;
      }
      else
      {
        $tz = "+" . $timezone;
      }

      echo '<font size="2"><b>For ' . strftime("%A, %B %d, %Y<br>JD used = $starting_JD<br>(time zone = GMT $tz hours)</b></font><br />\n", mktime($hour, $minute, 0, $month, $day, $year));
      echo "<font size = '-1'><b>" . $long_deg . $ew_txt . $long_min . ", " . $lat_deg . $ns_txt . $lat_min . "</b></font><br /><br />";
      echo "</center><br>";

      $pl_name[0] = "Sun";
      $pl_name[1] = "Moon";
      $pl_name[2] = "Mars";
      $pl_name[3] = "Mercury";
      $pl_name[4] = "Jupiter";
      $pl_name[5] = "Venus";
      $pl_name[6] = "Saturn";

      $day_of_week = jddayofweek($starting_JD + 0.5);		//0 = Sunday, 6 = Saturday

//FOR DEBUG
//echo $starting_JD . "<br />";
//echo $day_of_week . "<br />";

      $sunset_time = $set_hour * 3600 + $set_minute * 60 + $set_seconds;			//in numbers of seconds
      $sunrise_time = $rise_hour * 3600 + $rise_minute * 60 + $rise_seconds;		//in numbers of seconds

      $length_of_day = $sunset_time - $sunrise_time;
      $length_of_night = 86400 - $length_of_day;

      $day_interval = $length_of_day / 12;							//in seconds
      $night_interval = $length_of_night / 12;						//in seconds

      $time_now = $sunrise_time - $day_interval;
      $ruler_now = $day_of_week +2;
      for ($i = 0; $i < 12; $i++)
      {
        $time_now = $time_now + $day_interval;				//time of next planetary hour
        $ruler_now = $ruler_now - 2;
        if ($ruler_now < 0)
        {
          $ruler_now = $ruler_now + 7;
        }
        $ruling_pl[$i] = $pl_name[$ruler_now];
        $pl_hour[$i] = $time_now;
      }

      $time_now = $sunset_time - $night_interval;
      for ($i = 0; $i < 12; $i++)
      {
        $time_now = $time_now + $night_interval;			//time of next planetary hour
        $ruler_now = $ruler_now - 2;
        if ($ruler_now < 0)
        {
          $ruler_now = $ruler_now + 7;
        }
        $ruling_pl[$i + 12] = $pl_name[$ruler_now];
        $pl_hour[$i + 12] = $time_now;
      }

      echo '<center><table width="30%" cellpadding="0" cellspacing="0" border="0">',"\n";

      echo '<tr>';
      echo "<td><font color='#0000ff'><b> Planet </b></font></td>";
      echo "<td><font color='#0000ff'><b> Time </b></font></td>";
      echo "<td><font color='#0000ff'><b> Planet </b></font></td>";
      echo "<td><font color='#0000ff'><b> Time </b></font></td>";
      echo '</tr>';

      for ($i = 0; $i <= 11; $i++)
      {
        echo '<tr>';
        echo "<td>" . $ruling_pl[$i] . "</td>";
        echo "<td>" . strftime("%X", mktime(0, 0, $pl_hour[$i], $month, $day, $year)) . "</td>";
        echo "<td>" . $ruling_pl[$i + 12] . "</td>";
        echo "<td>" . strftime("%X", mktime(0, 0, $pl_hour[$i + 12], $month, $day, $year)) . "</td>";
        echo '</tr>';
      }

      echo '</table></center>',"\n";
      echo "<br /><br />";

      @mail(EMAIL, "Planetary Hours", "");

      include ('footer_natal.html');
      exit();
    }
  }
  else
  {
    include ('header_ph.html');				//here because of cookies

    $month = strftime("%m", time());
    $day = strftime("%d", time());
    $year = strftime("%Y", time());

    $timezone = $_COOKIE['current_timezone'];

    $long_deg = $_COOKIE["current_long_deg"];
    $long_min = $_COOKIE["current_long_min"];
    $ew = $_COOKIE["current_ew"];

    $lat_deg = $_COOKIE["current_lat_deg"];
    $lat_min = $_COOKIE["current_lat_min"];
    $ns = $_COOKIE["current_ns"];
  }

?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" target="_blank" style="margin: 0px 20px;">
  <fieldset><legend><font size=5><b>Data entry</b></font></legend>

  &nbsp;&nbsp;<font color="#ff0000"><b>All fields are required.</b></font><br>

  <table style="font-size:12px;">
    <TR>
      <TD>
        <P align="right">Date:</P>
      </TD>

      <TD>
        <?php
        echo '<select name="month">';
        foreach ($months as $key => $value)
        {
          echo "<option value=\"$key\"";
          if ($key == $month)
          {
            echo ' selected="selected"';
          }
          echo ">$value</option>\n";
        }
        echo '</select>';
        ?>

        <INPUT size="2" maxlength="2" name="day" value="<?php echo $day; ?>">
        <b>,</b>&nbsp;
        <INPUT size="4" maxlength="4" name="year" value="<?php echo $year; ?>">
         <font color="#0000ff">
        (only years from 1900 through 2099 are valid)
        </font>
     </TD>
    </TR>

    <TR>
      <td colspan='2'><br>&nbsp;<br></td>
    </TR>

    <TR>
      <td valign="top">
        <P align="right"><font color="#ff0000">
        <b>IMPORTANT</b>
        </font></P>
      </td>

      <td>
        <font color="#ff0000">
        <b>NOTICE:</b>
        </font>
        <b>&nbsp;&nbsp;West longitudes are MINUS time zones.&nbsp;&nbsp;East longitudes are PLUS time zones.</b>
      </td>
    </TR>

    <TR>
      <td valign="top"><P align="right">Time zone:</P></td>

      <TD>
        <select name="timezone" size="1">
          <?php
          echo "<option value='' ";
          if ($timezone == ""){ echo " selected"; }
          echo "> Select Time Zone </option>";

          echo "<option value='-12' ";
          if ($timezone == "-12"){ echo " selected"; }
          echo ">GMT -12:00 hrs - IDLW</option>";

          echo "<option value='-11' ";
          if ($timezone == "-11"){ echo " selected"; }
          echo ">GMT -11:00 hrs - BET or NT</option>";

          echo "<option value='-10.5' ";
          if ($timezone == "-10.5"){ echo " selected"; }
          echo ">GMT -10:30 hrs - HST</option>";

          echo "<option value='-10' ";
          if ($timezone == "-10"){ echo " selected"; }
          echo ">GMT -10:00 hrs - AHST</option>";

          echo "<option value='-9.5' ";
          if ($timezone == "-9.5"){ echo " selected"; }
          echo ">GMT -09:30 hrs - HDT or HWT</option>";

          echo "<option value='-9' ";
          if ($timezone == "-9"){ echo " selected"; }
          echo ">GMT -09:00 hrs - YST or AHDT or AHWT</option>";

          echo "<option value='-8' ";
          if ($timezone == "-8"){ echo " selected"; }
          echo ">GMT -08:00 hrs - PST or YDT or YWT</option>";

          echo "<option value='-7' ";
          if ($timezone == "-7"){ echo " selected"; }
          echo ">GMT -07:00 hrs - MST or PDT or PWT</option>";

          echo "<option value='-6' ";
          if ($timezone == "-6"){ echo " selected"; }
          echo ">GMT -06:00 hrs - CST or MDT or MWT</option>";

          echo "<option value='-5' ";
          if ($timezone == "-5"){ echo " selected"; }
          echo ">GMT -05:00 hrs - EST or CDT or CWT</option>";

          echo "<option value='-4' ";
          if ($timezone == "-4"){ echo " selected"; }
          echo ">GMT -04:00 hrs - AST or EDT or EWT</option>";

          echo "<option value='-3.5' ";
          if ($timezone == "-3.5"){ echo " selected"; }
          echo ">GMT -03:30 hrs - NST</option>";

          echo "<option value='-3' ";
          if ($timezone == "-3"){ echo " selected"; }
          echo ">GMT -03:00 hrs - BZT2 or AWT</option>";

          echo "<option value='-2' ";
          if ($timezone == "-2"){ echo " selected"; }
          echo ">GMT -02:00 hrs - AT</option>";

          echo "<option value='-1' ";
          if ($timezone == "-1"){ echo " selected"; }
          echo ">GMT -01:00 hrs - WAT</option>";

          echo "<option value='0' ";
          if ($timezone == "0"){ echo " selected"; }
          echo ">Greenwich Mean Time - GMT or UT</option>";

          echo "<option value='1' ";
          if ($timezone == "1"){ echo " selected"; }
          echo ">GMT +01:00 hrs - CET or MET or BST</option>";

          echo "<option value='2' ";
          if ($timezone == "2"){ echo " selected"; }
          echo ">GMT +02:00 hrs - EET or CED or MED or BDST or BWT</option>";

          echo "<option value='3' ";
          if ($timezone == "3"){ echo " selected"; }
          echo ">GMT +03:00 hrs - BAT or EED</option>";

          echo "<option value='3.5' ";
          if ($timezone == "3.5"){ echo " selected"; }
          echo ">GMT +03:30 hrs - IT</option>";

          echo "<option value='4' ";
          if ($timezone == "4"){ echo " selected"; }
          echo ">GMT +04:00 hrs - USZ3</option>";

          echo "<option value='5' ";
          if ($timezone == "5"){ echo " selected"; }
          echo ">GMT +05:00 hrs - USZ4</option>";

          echo "<option value='5.5' ";
          if ($timezone == "5.5"){ echo " selected"; }
          echo ">GMT +05:30 hrs - IST</option>";

          echo "<option value='6' ";
          if ($timezone == "6"){ echo " selected"; }
          echo ">GMT +06:00 hrs - USZ5</option>";

          echo "<option value='6.5' ";
          if ($timezone == "6.5"){ echo " selected"; }
          echo ">GMT +06:30 hrs - NST</option>";

          echo "<option value='7' ";
          if ($timezone == "7"){ echo " selected"; }
          echo ">GMT +07:00 hrs - SST or USZ6</option>";

          echo "<option value='7.5' ";
          if ($timezone == "7.5"){ echo " selected"; }
          echo ">GMT +07:30 hrs - JT</option>";

          echo "<option value='8' ";
          if ($timezone == "8"){ echo " selected"; }
          echo ">GMT +08:00 hrs - AWST or CCT</option>";

          echo "<option value='8.5' ";
          if ($timezone == "8.5"){ echo " selected"; }
          echo ">GMT +08:30 hrs - MT</option>";

          echo "<option value='9' ";
          if ($timezone == "9"){ echo " selected"; }
          echo ">GMT +09:00 hrs - JST or AWDT</option>";

          echo "<option value='9.5' ";
          if ($timezone == "9.5"){ echo " selected"; }
          echo ">GMT +09:30 hrs - ACST or SAT or SAST</option>";

          echo "<option value='10' ";
          if ($timezone == "10"){ echo " selected"; }
          echo ">GMT +10:00 hrs - AEST or GST</option>";

          echo "<option value='10.5' ";
          if ($timezone == "10.5"){ echo " selected"; }
          echo ">GMT +10:30 hrs - ACDT or SDT or SAD</option>";

          echo "<option value='11' ";
          if ($timezone == "11"){ echo " selected"; }
          echo ">GMT +11:00 hrs - UZ10 or AEDT</option>";

          echo "<option value='11.5' ";
          if ($timezone == "11.5"){ echo " selected"; }
          echo ">GMT +11:30 hrs - NZ</option>";

          echo "<option value='12' ";
          if ($timezone == "12"){ echo " selected"; }
          echo ">GMT +12:00 hrs - NZT or IDLE</option>";

          echo "<option value='12.5' ";
          if ($timezone == "12.5"){ echo " selected"; }
          echo ">GMT +12:30 hrs - NZS</option>";

          echo "<option value='13' ";
          if ($timezone == "13"){ echo " selected"; }
          echo ">GMT +13:00 hrs - NZST</option>";
          ?>
        </select>

        <br>

        <font color="#0000ff">
        (example: Chicago is "GMT -06:00 hrs" (standard time), Paris is "GMT +01:00 hrs" (standard time).<br>
        Add 1 hour if Daylight Saving was in effect when you were born (select next time zone down in the list).
        <br><br>
        </font>
      </TD>
    </TR>

    <TR>
      <td valign="top"><P align="right">Longitude:</P></td>
      <TD>
        <INPUT maxlength="3" size="3" name="long_deg" value="<?php echo $long_deg; ?>">
        <select name="ew">
          <?php
          if ($ew == "-1")
          {
            echo "<option value='-1' selected>W </option>";
            echo "<option value='1'>E </option>";
          }
          elseif ($ew == "1")
          {
            echo "<option value='-1'>W </option>";
            echo "<option value='1' selected>E </option>";
          }
          else
          {
            echo "<option value='' selected>Select</option>";
            echo "<option value='-1'>W </option>";
            echo "<option value='1'>E </option>";
          }
          ?>
        </select>

        <INPUT maxlength="2" size="2" name="long_min" value="<?php echo $long_min; ?>">
        <font color="#0000ff">
        (example: Chicago is 87 W 39, Sydney is 151 E 13)
        </font>
      </TD>
    </TR>

    <TR>
      <td valign="top"><P align="right">Latitude:</P></td>

      <TD>
        <INPUT maxlength="2" size="3" name="lat_deg" value="<?php echo $lat_deg; ?>">
        <select name="ns">
          <?php
          if ($ns == "1")
          {
            echo "<option value='1' selected>N&nbsp;&nbsp;</option>";
            echo "<option value='-1'>S&nbsp;&nbsp;</option>";
          }
          elseif ($ns == "-1")
          {
            echo "<option value='1'>N&nbsp;&nbsp;</option>";
            echo "<option value='-1' selected>S&nbsp;&nbsp;</option>";
          }
          else
          {
            echo "<option value='' selected>Select</option>";
            echo "<option value='1'>N&nbsp;&nbsp;</option>";
            echo "<option value='-1'>S&nbsp;&nbsp;</option>";
          }
          ?>
        </select>

        <INPUT maxlength="2" size="2" name="lat_min" value="<?php echo $lat_min; ?>">
        <font color="#0000ff">
        (example: Chicago is 41 N 51, Sydney is 33 S 52)
        </font>
        <br><br>
      </TD>
    </TR>
  </table>

  <br>
  <center>
  <font color="#ff0000"><b>Most people mess up the time zone selection. Please make sure your selection is correct.</b></font><br><br>
  <input type="hidden" name="submitted" value="True">
  <INPUT type="submit" name="submit" value="Submit data (AFTER DOUBLE-CHECKING IT FOR ERRORS)" align="middle" style="background-color:#66ff66;color:#000000;font-size:16px;font-weight:bold">
  </center>

  <br>
  </fieldset>
</form>

<?php
include ('footer_natal.html');


Function mid($midstring, $midstart, $midlength)
{
  return(substr($midstring, $midstart-1, $midlength));
}


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

?>
