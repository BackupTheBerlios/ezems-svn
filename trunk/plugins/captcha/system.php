<?php
/*
 (C) 2006 EZEMS.NET Alle Rechte vorbehalten.

 Dieses Programm ist urheberrechtlich gesch�tzt.
 Die Verwendung f�r private Zwecke ist gesattet.
 Unbrechtigte Nutzung (Verkauf, Weiterverbreitung,
 Nutzung ohne Urherberrechtsvermerk, kommerzielle
 Nutzung) ist strafbar. 
 Die Nutzung des Scriptes erfolgt auf eigene Gefahr.
 Sch�den die durch die Nutzung entstanden sind,
 tr�gt allein der Nutzer des Programmes.
*/ $ecFile = 'plugins/captcha/system.php';

function getCaptchaCode($id)
{
	$ecCaptchaData = dbSelect('*',1,'captcha','captchaId='.$id);
	while($captcha = mysql_fetch_object($ecCaptchaData))
	{
		return $captcha->captchaCode;
	}
}

function generateCaptcha()
{

}
?>