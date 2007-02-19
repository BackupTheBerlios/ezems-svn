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
*/ $ecFile = 'plugins/users/navlogin.php';

$ecLang = ecGetLang('users', 'navlogin');
if (isset($_REQUEST['view']))
{
	$loginPlugin = $_REQUEST['view'];
	if (isset($_REQUEST['site']))
	{
		$loginSite = $_REQUEST['site'];
	}
	else
	{
		$loginSite = 'list';
	}
}
else
{
	$loginPlugin = 'users';
	$loginSite = 'home';
}
$username = isset($_REQUEST['loginUsername']) ? $_REQUEST['loginUsername'] : $ecLang['username'];
$password = isset($_REQUEST['loginPassword']) ? $_REQUEST['loginPassword'] : $ecLang['password'];
echo ecTemplate('users', 'navlogin');
?>