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
*/ $ecFile = 'plugins/captcha/manage.php';

echo ecTemplate('captcha', 'manage', 'siteHead');

if (isset($_POST['save']))
{
	$data['font'] = $_POST['font'];
	
	ecSettings('captcha', $data);
	$next = ecReferer('index.php?view=captcha&amp;site=manage');
	echo ecTemplate('captcha', 'manage', 'captchaSaved');
}
else
{
	$testText = isset($_REQUEST['testtext']) ? $_REQUEST['testtext'] : 'Test';
	
	$calibri = ($ecSettings['captcha']['font'] == 'CALIBRI') ? ' checked="checked"' : '';
	$arial = ($ecSettings['captcha']['font'] == 'ARIAL') ? ' checked="checked"' : '';
	$agencyr = ($ecSettings['captcha']['font'] == 'AGENCYR') ? ' checked="checked"' : '';
	$playbill = ($ecSettings['captcha']['font'] == 'PLAYBILL') ? ' checked="checked"' : '';
	$showg = ($ecSettings['captcha']['font'] == 'SHOWG') ? ' checked="checked"' : '';
	$ravie = ($ecSettings['captcha']['font'] == 'RAVIE') ? ' checked="checked"' : '';
	
	echo ecTemplate('captcha', 'manage', 'siteView');
}





?>