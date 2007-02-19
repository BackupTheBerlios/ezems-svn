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
*/ $ecFile = 'system/core/settings.php';

// no direct access
defined( '_VALID_EC' ) or 
	die( 'Restricted access' );

// Userip
$ecLocal['userIP'] = getenv("REMOTE_ADDR");

// Load Settings
$ecSettingsData = dbSelect('*', 1, 'settings');
while($setting = mysql_fetch_object($ecSettingsData))
{
	$ecSettings[$setting->settingsPlugin][$setting->settingsKey] = $setting->settingsValue;
}

// Set Timestamp
$ecLocal['timestamp'] = time();
?>