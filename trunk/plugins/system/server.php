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
*/ $ecFile = 'plugins/system/server.php';

echo ecTemplate('system', 'server', 'siteTitle');

$cpu = php_uname('m');
$os = php_uname('s');
$osVersion = php_uname('r');
$hostname = php_uname('n');
$phpversion = phpversion();
$zendversion = zend_version();
$db = dbVersion();
$software = str_replace('/',' ',$_SERVER['SERVER_SOFTWARE']);

$displayErrors = ini_get('display_errors');
$registerGlobals = ini_get('register_globals');
$magicQuotes = get_magic_quotes_gpc();
$safeMode = ini_get('safe_mode');
$safeMode = empty($safe_mode) ? 0 : 1;
$maxExecutionTime = ini_get('max_execution_time');
$postMaxSize = str_replace('M',' Mb', ini_get('post_max_size'));
$memory = ini_get('memory_get_usage');
$memory = empty($memory) ? '-' : $memory;

$spaceTotal = disk_total_space('../');
$spaceFree = disk_free_space('../');
$spaceUsed = $spaceTotal - $spaceFree;
$spaceTotal = ecFilesize($spaceTotal);
$spaceFree = ecFilesize($spaceFree);
$spaceUsed = ecFilesize($spaceUsed);

$spaceUsedPercent = round($spaceUsed * 100 / $spaceTotal);
$spaceFreePercent = round($spaceFree * 100 / $spaceTotal);
$spaceTotalPercent = $spaceUsedPercent + $spaceFreePercent;

echo ecTemplate('system', 'server', 'siteOverview');
?>