http://www.geonames.org/export/
namecheap
<?
$string = "this is my lower sting";
$str = preg_replace('/^(.*)/', 'strtoupper(\\1)', $string);
echo $str.'~~~~';


/*
$img = imagecreatetruecolor(450, 450);

$white = imagecolorallocate($img, 255, 255, 255);
$red = imagecolorallocate($img, 255, 0, 0);
$black = imagecolorallocate($img, 0, 0, 0);
$grey = imagecolorallocate($img, 211, 211, 211);

imagefill($img, 0, 0, $white);
imagearc($img, 224, 224, 400, 400, 0, 0, $black);
imagefilledarc($img, 224, 224, 15, 15, 0, 0, $black, IMG_ARC_PIE);

for ($zz = 0; $zz < 60; $zz++) {
    $digitCoords['x'][] = 175 * cos(deg2rad(($zz-10) * (360/60))) + 224;
    $digitCoords['y'][] = 175 * sin(deg2rad(($zz-10) * (360/60))) + 224;
}

for ($zz = 0; $zz < 60; $zz++) {
    if ($zz % 5 == 0)
        imagestring($img, 5, $digitCoords['x'][$zz] - 4, $digitCoords['y'][$zz] - 6, ($zz/5) + 1, $black);
    else
        imagefilledarc($img, $digitCoords['x'][$zz], $digitCoords['y'][$zz], 3, 3, 0, 0, $grey, IMG_ARC_PIE);
}

$seconds = date('s');
$minutes = date('i') + ($seconds/60);
$hours = date('h') + ($minutes/60);

$r_sec = 175;
$r_min = 175;
$r_hr = 125;

$x_sec = $r_sec * cos(deg2rad(($seconds-15) * (360/60))) + 224;
$y_sec = $r_sec * sin(deg2rad(($seconds-15) * (360/60))) + 224;

$x_min = $r_min * cos(deg2rad(($minutes-15) * (360/60))) + 224;
$y_min = $r_min * sin(deg2rad(($minutes-15) * (360/60))) + 224;

$x_hr = $r_hr * cos(deg2rad(($hours-3) * (360/12))) + 224;
$y_hr = $r_hr * sin(deg2rad(($hours-3) * (360/12))) + 224;

imageline($img, 224, 224, $x_sec, $y_sec, $red);
imagesetthickness($img, 3);
imageline($img, 224, 224, $x_min, $y_min, $black);
imagesetthickness($img, 5);
imageline($img, 224, 224, $x_hr, $y_hr, $black);

header("Content-type: image/png");
imagepng($img);

imagedestroy($img);
?>
