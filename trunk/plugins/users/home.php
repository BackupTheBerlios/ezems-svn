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
*/ $ecFile = 'plugins/users/home.php';

echo ecTemplate('users', 'home', 'siteHead');
$user = $ecUser['username'];
$pMcount = 0;
echo ecTemplate('users', 'home', 'welcomeMessage');

$username = $ecUser['username'];
$email = $ecUser['email'];
$ip = $ecLocal['userIP'];
$userid = $ecUser['userId'];
$firstname = $ecUser['firstname'];
$lastname = $ecUser['lastname'];
echo ecTemplate('users', 'home', 'personalData');

?>