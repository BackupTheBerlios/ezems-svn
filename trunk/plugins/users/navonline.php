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
*/ $ecFile = 'plugins/users/navonline.php';

echo ecTemplate('users', 'navonline', 'onlineHead');
$onlineTime = $ecLocal['timestamp'] - 180;
$ecOnlineData = dbSelect('usersId,usersUsername,usersLastname',1,'users',"(usersLastOnline > $onlineTime) AND (usersGhostOnline = 0)");
while($users = mysql_fetch_object($ecOnlineData))
{
	$usersId = $users->usersId;
	$usersUsername = $users->usersUsername;
	echo ecTemplate('users', 'navonline', 'onlineData');
}
echo ecTemplate('users', 'navonline', 'onlineFoot');
?>