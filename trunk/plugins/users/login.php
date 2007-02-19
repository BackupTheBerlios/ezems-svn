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
*/ $ecFile = 'plugins/users/login.php';

echo ecTemplate('users', 'login', 'siteHead');

$ecLang = ecGetLang('users', 'login');
if ($loginStatus == 1)
{
	$loginPlugin = $_POST['loginPlugin'];
	$loginSite = $_POST['loginSite'];
	$next = ecReferer('index.php?view='.$loginPlugin.'&amp;site='.$loginSite);
	echo ecTemplate('users', 'login', 'loginOk');
}
elseif ($loginStatus == 2)
{
	$loginError = $ecLang['error2'];
	echo ecTemplate('users', 'login', 'loginError');
}
else
{
	$loginError = $ecLang['error3'];
	echo ecTemplate('users', 'login', 'loginError');
}


?>