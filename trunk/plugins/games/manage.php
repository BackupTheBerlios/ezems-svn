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
*/ $ecFile = 'plugins/games/manage.php';

echo ecTemplate('games', 'manage', 'siteHead');

echo ecTemplate('games', 'manage', 'gamesHead');
$ecGamesData = dbSelect('gamesId,gamesName,gamesIcon',1,'games');
while($games = mysql_fetch_object($ecGamesData))
{
	$gamesId = $games->gamesId;
	$gamesName = $games->gamesName;
	$gamesIcon = !empty($games->gamesIcon) ? $games->gamesIcon : 'default.png';
	echo ecTemplate('games', 'manage', 'gamesData');
}
echo ecTemplate('games', 'manage', 'gamesFoot');

echo ecTemplate('games', 'manage', 'gamesAdd');

echo ecTemplate('games', 'manage', 'siteFoot');
?>