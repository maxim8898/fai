<?php
session_start();
error_reporting(0);
$font = "font.ttf";
$content = mt_rand(1000,9999);
$cod = md5($content);
$_SESSION['cod'] = $cod;
$img = imagecreate(100, 40);
$colours = array();
$colours['white'] = imagecolorallocate($img, 255, 255, 255);
$colours['black'] = imagecolorallocate($img, 0, 0, 0);
$colours['gray'] = imagecolorallocate($img, 128, 128, 128);
//$txt_bbox = imagettfbbox(30, 0, $font, $content);
header('Content-type: image/png');
imageline($img,0,6,110,6,$colours['black']);
imageline($img,0,31,110,31,$colours['black']);
for($i=0;$i<7;$i++){
 $a = $i*20;
 imageline($img,15+$a,0,(-5+$a),40,$colours['gray']);
}
imagettftext($img, 25, 10, 10, 35, $colours['black'], $font, $content);
imagepng($img);
imagedestroy($img);
?>
