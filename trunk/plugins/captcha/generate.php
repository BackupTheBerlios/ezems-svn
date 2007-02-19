<?php
/*
 (C) 2006 EZEMS.NET Alle Rechte vorbehalten.

 Dieses Programm ist urheberrechtlich geschützt.
 Die Verwendung für private Zwecke ist gesattet.
 Unbrechtigte Nutzung (Verkauf, Weiterverbreitung,
 Nutzung ohne Urherberrechtsvermerk, kommerzielle
 Nutzung) ist strafbar. 
 Die Nutzung des Scriptes erfolgt auf eigene Gefahr.
 Schäden die durch die Nutzung entstanden sind,
 trägt allein der Nutzer des Programmes.
*/ $ecFile = 'plugins/captcha/generate.php';

	define('_VALID_EC', 1);
	
	// Load config
		require_once('../../config.php');
		
	// Load errorsubs
		require_once('../../system/subs/errors.php');
	
	// Connect to database & Load subs
		require_once('../../system/database/'.$ecDb['typ'].'/subs.php');
		
	// Load settings
		require_once('../../system/core/settings.php');
		
if (!isset($_REQUEST['test']))
{	
	$captchaId = $_REQUEST['id'];
	$ecCaptchaData = dbSelect('*',1,'captcha',"captchaId=$captchaId");
	$captcha = mysql_fetch_assoc($ecCaptchaData);
	$captchaCode = $captcha['captchaCode'];
}
$text = isset($_REQUEST['test']) ? strtoupper($_REQUEST['test']) : strtoupper($captchaCode);
header('Content-type: image/jpeg');
session_start();

// Bild Erstellen
$image = imagecreatetruecolor (250,50);

// Bild Hintergrundfarbe erstellen
$background_color = ImageColorAllocate($image, 230, 230, 230);
imagefill($image,0,0,$background_color);
$text_color = ImageColorAllocate($image, 20, 20, 20);

// Startposition Zufällig wählen
$string_start = rand(0,20);
for($i = 0; $i <= strlen($text); $i++)
{
	imagettftext($image, 30, rand(-10,10), $string_start+40*$i, rand(30,50), $text_color,'fonts/'.$ecSettings['captcha']['font'].'.ttf',$text[$i]);
}

// Bild-Rauschen
$color_pixels = ImageColorAllocate($image, 20, 20, 20);

// Zufälliges Störrauschen erstellen
for($i = 0; $i <= imagesx($image); $i++) // X Koordinaten
{ 
	for($c = 0; $c <= imagesy($image); $c++) // Y Koordinaten
	{
		if(rand(0,1)) // Zufall => Setze Pixel/Setze Keinen Pixel
		{
			imagesetpixel($image, $i, $c, $color_pixels);
		}
	}
}
imagejpeg($image,null,40);
imagedestroy($image);
?>