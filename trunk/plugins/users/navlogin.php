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
*/ $ecFile = 'plugins/users/navlogin.php';

$ecLang = ecGetLang('users', 'navlogin');
if (isset($_REQUEST['view']))
{
	$loginPage = serialize($_GET);
}
else
{
	$loginPage = serialize(array('view' => 'users','site' => 'home'));
}
$loginPage = str_replace('"','@',$loginPage);
$username = isset($_REQUEST['loginUsername']) ? $_REQUEST['loginUsername'] : $ecLang['username'];
$password = isset($_REQUEST['loginPassword']) ? $_REQUEST['loginPassword'] : $ecLang['password'];
echo ecTemplate('users', 'navlogin');
?>