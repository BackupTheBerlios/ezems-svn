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
*/ $ecFile = 'system/subs/icons.php';

// Icons
$ecIconsData = dbSelect('iconsId,iconsPath',1,'icons');
while($icons = mysql_fetch_object($ecIconsData))
{
	$ecLocal['iconsList'][$icons->iconsId] = $icons->iconsPath;
}

// Load Icons
$ecLocal['icons'] = $ecLocal['iconsList'][$ecUser['iconId']];
$themesPath = 'icons/'.$ecLocal['icons'];
if (!file_exists($themesPath))
{
	$ecLocal['icons'] = $ecLocal['iconsList'][$ecSettings['system']['defaultIconId']];
	$iconsPath = 'icons/'.$ecLocal['icons'];
	if (!file_exists($iconsPath))
	{
		header("Location: error.php?typ=icons");
		exit();
	}
}
?>