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
*/ $ecFile = 'plugins/users/navmenu.php';

$rssLink = 'plugins/'.$ecLocal['plugin'].'/rss.php';
if (file_exists($rssLink) && ecGetAccessLevel($ecLocal['plugin'], 'rss'))
{
	echo ecTemplate('system', 'rsslink', 'rssLink');
	$ecLocal['rssFeedLink'] = $rssLink;
}
?>