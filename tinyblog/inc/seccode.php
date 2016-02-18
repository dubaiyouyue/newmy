<?php
session_start();
if($_GET['a'] == 'showseccode') {
	seccode();
}
function seccode() {
	header("content-type: image/png");
	srand(microtime() * 100000);
	session_register('seccode');
	$seccode = strval(rand('1111', '9999'));
	$_SESSION['seccode'] = $seccode;
	$img = imagecreate(47, 23);
	$bgcolor = imagecolorallocate($img, 255, 255, 255);
	$black = imagecolorallocate($img, 0, 0, 0);
	imageline($img, 0, 22, 47, 22, $black);
	imageline($img, 0, 0, 47, 0, $black);
	imageline($img, 0, 0, 0, 23, $black);
	imageline($img, 46, 0, 46, 23, $black);
	/*imagearc($h_img, 200, 15, 20, 20, 35, 190, $c_white);*/
	imagestring($img, 5, 6, 3, $seccode, $black);
	/*for($i = 0; $i < 200; $i++) {
		$randcolor = imagecolorallocate($h_img, rand(0, 255), rand(0, 255), rand(0, 255));
		imagesetpixel($h_img, rand() % 70, rand() % 30, $randcolor);
	}*/
	imagepng($img);
	imagedestroy($img);
	die();
}
?>