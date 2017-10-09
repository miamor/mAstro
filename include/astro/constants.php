<?php
error_reporting(E_ERROR | E_PARSE);

// set assignments of important variables
define("SE_SUN", 0);
define("SE_MOON", 1);
define("SE_MERCURY", 2);
define("SE_VENUS", 3);
define("SE_MARS", 4);
define("SE_JUPITER", 5);
define("SE_SATURN", 6);
define("SE_URANUS", 7);
define("SE_NEPTUNE", 8);
define("SE_PLUTO", 9);
define("SE_CHIRON", 10);
define("SE_LILITH", 11);
define("SE_TNODE", 12);		//this must be last thing before angle stuff
define("SE_POF", 13);
define("SE_VERTEX", 14);
define("LAST_PLANET", 14);

define("EMAIL_enabled", True);
define("EMAIL", "ae33@astrowin.org");

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
$pl_name[LAST_PLANET + 1] = "Ascendant";
$pl_name[LAST_PLANET + 2] = "Midheaven";

$pl_name[LAST_PLANET + 1] = "Ascendant";
$pl_name[LAST_PLANET + 2] = "House 2";
$pl_name[LAST_PLANET + 3] = "House 3";
$pl_name[LAST_PLANET + 4] = "House 4";
$pl_name[LAST_PLANET + 5] = "House 5";
$pl_name[LAST_PLANET + 6] = "House 6";
$pl_name[LAST_PLANET + 7] = "House 7";
$pl_name[LAST_PLANET + 8] = "House 8";
$pl_name[LAST_PLANET + 9] = "House 9";
$pl_name[LAST_PLANET + 10] = "MC (Midheaven)";
$pl_name[LAST_PLANET + 11] = "House 11";
$pl_name[LAST_PLANET + 12] = "House 12";

$house_name = array('1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th');
$elements = array('Fire' => array('LEO', 'ARIES', 'SAGITTRIUS'), 'Air' => array('GEMINI', 'LIBRA', 'AQUARIUS'), 'Earth' => array('CAPRICORN', 'VIRGO', 'TAURUS'), 'Water' => array('SCORPIO', 'PISCES', 'CANCER'));
$qualities = array('Cardinal' => array('ARIES', 'CANCER', 'LIBRA', 'CAPRICORN'), 'Fixed' => array('TAURUS', 'LEO', 'SCORPIO', 'AQUARIUS'), 'Mutable' => array('GEMINI', 'VIRGO', 'SAGITTARIUS', 'PISCES'));

$crAr = array(
	'ARIES' => 'Mars',
	'TAURUS' => 'Venus',
	'GEMINI' => 'Mercury',
	'CANCER' => 'Moon',
	'LEO' => 'Sun',
	'VIRGO' => 'Mercury',
	'LIBRA' => 'Venus',
	'SCORPIO' => 'Mars|Pluto',
	'SAGITTARIUS' => 'Jupiter',
	'CAPRICORN' => 'Saturn',
	'AQUARIUS' => 'Saturn|Uranus',
	'PISCES' => 'Jupiter|Neptune'
);
$signQ = array(
	'ARIES' => 'Cardinal',
	'LEO' => 'Fixed',
	'SAGITTARIUS' => 'Mutable',
	'SCORPIO' => 'Fixed',
	'CANCER' => 'Cardinal',
	'PISCES' => 'Mutable',
	'VIRGO' => 'Mutable',
	'CAPRICORN' => 'Cardinal',
	'TAURUS' => 'Fixed',
	'AQUARIUS' => 'Fixed',
	'GEMINI' => 'Mutable',
	'LIBRA' => 'Cardinal',
);
$signE = array(
	'ARIES' => 'Fire',
	'LEO' => 'Fire',
	'SAGGITARIUS' => 'Fire',
	'SCORPIO' => 'Water',
	'CANCER' => 'Water',
	'PISCES' => 'Water',
	'VIRGO' => 'Earth',
	'CAPRICORN' => 'Earth',
	'TAURUS' => 'Earth',
	'AQUARIUS' => 'Air',
	'GEMINI' => 'Air',
	'LIBRA' => 'Air',
);
$trinityHse = array(
	'Psychic Trinity' => array(4,8,12), // Water
	'The Trinity of Life' => array(1,5,9), // Fire
	'The Trinity of Relationship' => array(3,7,11), // Air
	'The Trinity of Wealth' => array(2,6,10), // Earth
);
$nameHse = array(
	'Angular' => array(1,4,7,10),
	'Succedent' => array(2,5,8,11),
	'Cadent' => array(3,6,9,12),
);

$pl_ephem_number[0] = "0";
$pl_ephem_number[1] = "1";
$pl_ephem_number[2] = "2";
$pl_ephem_number[3] = "3";
$pl_ephem_number[4] = "4";
$pl_ephem_number[5] = "5";
$pl_ephem_number[6] = "6";
$pl_ephem_number[7] = "7";
$pl_ephem_number[8] = "8";
$pl_ephem_number[9] = "9";
$pl_ephem_number[10] = "D";
$pl_ephem_number[11] = "A";
$pl_ephem_number[12] = "t";

$sign_name[1] = "ARIES";
$sign_name[2] = "TAURUS";
$sign_name[3] = "GEMINI";
$sign_name[4] = "CANCER";
$sign_name[5] = "LEO";
$sign_name[6] = "VIRGO";
$sign_name[7] = "LIBRA";
$sign_name[8] = "SCORPIO";
$sign_name[9] = "SAGITTARIUS";
$sign_name[10] = "CAPRICORN";
$sign_name[11] = "AQUARIUS";
$sign_name[12] = "PISCES";
$sign_name[13] = "ARIES";

$name_of_sign[1] = "Aries";
$name_of_sign[2] = "Taurus";
$name_of_sign[3] = "Gemini";
$name_of_sign[4] = "Cancer";
$name_of_sign[5] = "Leo";
$name_of_sign[6] = "Virgo";
$name_of_sign[7] = "Libra";
$name_of_sign[8] = "Scorpio";
$name_of_sign[9] = "Sagittarius";
$name_of_sign[10] = "Capricorn";
$name_of_sign[11] = "Aquarius";
$name_of_sign[12] = "Pisces";
$name_of_sign[13] = "Aries";

$aspects_defined[1] = "000";
$aspects_defined[2] = "045";
$aspects_defined[3] = "060";
$aspects_defined[4] = "090";
$aspects_defined[5] = "120";
$aspects_defined[6] = "135";
$aspects_defined[7] = "180";
$aspects_defined[8] = "030";
$aspects_defined[9] = "150";

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
$pl_glyph[13] = 60;		//Part of Fortune
$pl_glyph[14] = 109;	//Vertex
$pl_glyph[LAST_PLANET + 1] = 90;		//Ascendant
$pl_glyph[LAST_PLANET + 2] = 88;		//Midheaven

$asp_color[1] = $asp_color['Water'] = $blue;
$asp_color[2] = $asp_color['Fire'] = $red;
$asp_color[3] = $asp_color['Earth'] = $green;
$asp_color[4] = $red;			//$magenta;
$asp_color[5] = $blue;			//$cyan;
$asp_color[6] = $green;			//$orange;
$asp_color['Earth'] = $orange;

$asp_name[1] = "Conjunction";
$asp_name[2] = "Opposition";
$asp_name[3] = "Trine";
$asp_name[4] = "Square";
$asp_name[5] = "Quincunx";
$asp_name[6] = "Sextile";

$asp_glyph[1] = 113;		//  0 deg
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

define("CLR_BLACK", "#000000");
define("CLR_WHITE", "#ffffff");

define("CLR_RED", "#ff0000");
define("CLR_ANOTHER_RED", "#ff3c3c");

define("CLR_GREEN", "#2dac00");
define("CLR_LIME", "#9cce04");

define("CLR_BLUE", "#0000ff");
define("CLR_LIGHT_BLUE", "#c0c0ff");
define("CLR_ANOTHER_BLUE", "#c0c0ff");

define("CLR_PURPLE", "#ff00ff");
define("CLR_CYAN", "#00ffff");

define("CLR_YELLOW", "#ffff00");

define("CLR_GRAY", "#c0c0c0");
define("CLR_ANOTHER_GRAY", "#e0e0e0");

define("CLR_ORANGE", "#db9b40");

define("CLR_10TH_H", "#0000ff");
define("CLR_11TH_H", "#ff0000");
define("CLR_12TH_H", "#2dac00");
define("CLR_1ST_H", "#840da9");
define("CLR_2ND_H", "#c0004d");
define("CLR_3RD_H", "#808080");

// functions 

function left ($leftstring, $leftlength) {
	return(substr($leftstring, 0, $leftlength));
}

function Reduce_below_30 ($longitude) {
	$lng = $longitude;
	while ($lng >= 30) $lng = $lng - 30;
	return $lng;
}

function Convert_Longitude ($longitude) {
	$signs = array (0 => 'Ari', 'Tau', 'Gem', 'Can', 'Leo', 'Vir', 'Lib', 'Sco', 'Sag', 'Cap', 'Aqu', 'Pis');

	$sign_num = floor($longitude / 30);
//	echo ($longitude / 30).'<br/>';
	$pos_in_sign = $longitude - ($sign_num * 30);
	$deg = floor($pos_in_sign);
	$full_min = ($pos_in_sign - $deg) * 60;
	$min = floor($full_min);
	$full_sec = round(($full_min - $min) * 60);

	if ($deg < 10) $deg = "0" . $deg;
	if ($min < 10) $min = "0" . $min;

	if ($full_sec < 10) $full_sec = "0" . $full_sec;

	return $deg . " " . $signs[$sign_num] . " " . $min . "' " . $full_sec . chr(34);
}

function mid ($midstring, $midstart, $midlength) {
	return(substr($midstring, $midstart-1, $midlength));
}

function safeEscapeString ($string) {
	// replace HTML tags '<>' with '[]'
	$temp1 = str_replace("<", "[", $string);
	$temp2 = str_replace(">", "]", $temp1);

	// but keep <br> or <br />
	// turn <br> into <br /> so later it will be turned into ""
	// using just <br> will add extra blank lines
	$temp1 = str_replace("[br]", "<br />", $temp2);
	$temp2 = str_replace("[br /]", "<br />", $temp1);

//	if (get_magic_quotes_gpc()) 
		return $temp2;
//	else
//		return mysqli_escape_string($temp2);
}

function Find_Specific_Report_Paragraph ($phrase_to_look_for, $file) {
	$string = "";
	$len = strlen($phrase_to_look_for);

	//put entire file contents into an array", line by line
	$file_array = file($file);

	// look through each line searching for $phrase_to_look_for
	for ($i = 0; $i < count($file_array); $i++) {
		if (left(trim($file_array[$i]), $len) == $phrase_to_look_for) {
			$flag = 0;
			while (trim($file_array[$i]) != "*") {
/*				if ($flag == 0) 
					$string .= "<b>" . $file_array[$i] . "</b>";
				else 
*/				$string .= $file_array[$i];
				$flag = 1;
				$i++;
			}
			break;
		}
	}
	return $string;
}

function Crunch ($x) {
	if ($x >= 0) $y = $x - floor($x / 360) * 360;
	else $y = 360 + ($x - ((1 + floor($x / 360)) * 360));
	return $y;
}

function drawboldtext($image, $size, $angle, $x_cord, $y_cord, $clr_to_use, $fontfile, $text, $boldness) {
	$_x = array(1, 0, 1, 0, -1, -1, 1, 0, -1);
	$_y = array(0, -1, -1, 0, 0, -1, 1, 1, 1);

	for($n = 0; $n <= $boldness; $n++) ImageTTFText($image, $size, $angle, $x_cord+$_x[$n], $y_cord+$_y[$n], $clr_to_use, $fontfile, $text);
}

function DMStoDEC ($deg,$min,$sec) {
	return $deg+((($min*60)+($sec))/3600);
}

function DECtoDMS ($dec) {
	$vars = explode(".",$dec);
	$deg = $vars[0];
	$tempma = "0.".$vars[1];

	$tempma = $tempma * 3600;
	$min = floor($tempma / 60);
	$sec = $tempma - ($min*60);

	return array("deg"=>$deg, "min"=>$min, "sec"=>$sec);
}

//$chartDraw = new chartDraw();

?>
