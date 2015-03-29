<?php

function getphotodata($number)
{
	$url = "../images/bld_icon.png";
	$image = imagecreatefromstring(file_get_contents($url));
	
	$white = imagecolorallocate($image, 255, 255, 255);
	imagecolortransparent($image, $white);
	
	putenv('GDFONTPATH=' . '/php');
	echo realpath();
	$font = "Arial";
	imagettftext($image, 48, 0, 14, 70, $white, $font, $number);
	
	ob_start();
	imagepng($image);
	$data = ob_get_clean();
					
	return $data;
}

function getsmphotodata($number)
{
	$url = "../images/bld_sicon.png";
	$image = imagecreatefromstring(file_get_contents($url));
	
	$black = imagecolorallocate($image, 0, 0, 0);
	$white = imagecolorallocate($image, 255, 255, 255);
	imagecolortransparent($image, $black);
	
	putenv('GDFONTPATH=' . '/php');
	$font = "Arial";
	imagettftext($image, 20, 0, 10, 32, $white, $font, $number);
	
	ob_start();
	imagepng($image);
	$data = ob_get_clean();
					
	return $data;
}