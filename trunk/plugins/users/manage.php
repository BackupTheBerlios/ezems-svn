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
*/ $ecFile = 'plugins/users/manage.php';

echo ecTemplate('users', 'manage', 'siteHead');

echo ecTemplate('users', 'manage', 'usersHead');
$ecUsersData = dbSelect('usersId,usersUsername,usersFirstname,usersLastname',1,'users');
while($users = mysql_fetch_object($ecUsersData))
{
	$usersId = $users->usersId;
	$usersUsername = $users->usersUsername;
	$usersFirstname = $users->usersFirstname;
	$usersLastname = $users->usersLastname;
	echo ecTemplate('users', 'manage', 'usersData');
}
echo ecTemplate('users', 'manage', 'usersFoot');

echo ecTemplate('users', 'manage', 'usersNew');
?>