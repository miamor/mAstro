<? 
//include '../config.php';
include 'constants.php';
header("Content-type: image/png");
$g = $_GET['g'];
$clr = $_GET['clr'];

$overall_size = 18;		//add a planet
$extra_width = 18;		//in order to make total width = 680
$margins = 0;			//left and right margins on the background graphic

$im = @imagecreatetruecolor($overall_size, $overall_size) or die("Cannot initialize new GD image stream");

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
$clrRGB = hex2rgb($clr);
$clrC = imagecolorallocate($im, $clrRGB[0], $clrRGB[1], $clrRGB[2]);

imagefilledrectangle($im, 0, 0, $overall_size, $overall_size, $white);
drawboldtext($im, 15, 0, -1, 17, $clrC, 'HamburgSymbols.ttf', chr($pl_glyph[$g]), 0);
//ImageTTFText($im, 16, 0, 0, 0, $blue, 'HamburgSymbols.ttf', chr($pl_glyph[$g]));
imagepng($im);
imagedestroy($im);
exit();

// function 
function hex2rgb ($color, $opacity = false) {
	$default = 'rgb(0,0,0)';
	//Return default if no color provided
	if (empty($color)) return $default; 

	//Sanitize $color if "#" is provided 
	if ($color[0] == '#' ) $color = substr($color, 1);

	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
	else if (strlen($color) == 3) $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
	else return $default;

	//Convert hexadec to rgb
	$rgb = array_map('hexdec', $hex);

	//Return rgb(a) color string
	return $rgb;
}

function hex2rgba ($color, $opacity = false) {
	$default = 'rgb(0,0,0)';
	$rgb = hex2rgba($color);
	//Check if opacity is set(rgba or rgb)
	if ($opacity) {
		if (abs($opacity) > 1) $opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else $output = 'rgb('.implode(",",$rgb).')';
	//Return rgb(a) color string
	return $output;
}


?>
