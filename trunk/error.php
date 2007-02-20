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
*/ $ecFile = 'error.php';

@error_reporting(E_ALL);
@set_time_limit(20);
@ini_set('register_globals','off');

$typ = isset($_REQUEST['typ']) ? $typ : 0;

if ($typ == 'install')
{
	echo 'Bitte Installationsdatei löschen!';
}
elseif ($typ == 'dbconnect')
{
	echo 'Es konnte keine Verbindung zum Datenbankserver hergestellt werden!';
}
elseif ($typ == 'dbname')
{
	echo 'Verbindung hergestellt, Datenbank wurde nicht gefunden';
}
elseif ($typ == 'themes')
{
	echo 'Default-Theme nicht gefunden';
}
elseif ($typ == 'icons')
{
	echo 'Default-Icons nicht gefunden';
}
elseif ($typ == 'templates')
{
	echo 'Default-Templates nicht gefunden';
}
elseif ($typ == 'languages')
{
	echo 'Default-Language nicht gefunden';
}
else
{
	echo 'Unbekannter Fehler';
}
?>
<br />
<a href="./">Nochmal Probieren</a>