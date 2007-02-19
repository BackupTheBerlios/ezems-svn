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
*/ $ecFile = 'index.php';

define('_VALID_EC', 1);

@error_reporting(E_ALL);
@set_time_limit(20);
@ini_set('register_globals','off');
if (version_compare("5.1.0 ", phpversion()) != 1) date_default_timezone_set("Europe/Berlin");

$parseStart = microtime(true);

// Set scriptpath
$ecLocal['scriptPath'] = ereg_replace("\\\\","/",__FILE__); 
$ecLocal['scriptPath'] = dirname($ecLocal['scriptPath']); 
$ecLocal['scriptPath'] = trim($ecLocal['scriptPath']); 

// Load errorhandler
require_once('system/subs/errorhandler.php');

// Check for hijacks
foreach ($_GET as $key => $value)
{
	$data1 = strpos($value, '%', 1);
	$data2 = strpos($value, '<', 1);
	if (!empty($data1) || !empty($data2))
		die('Unproper $_GET variable');
}

// Check for configuration file
if (!file_exists('config.php') || filesize('config.php') < 10)
{
	header ("Location: install/index.php");
	exit();
}

//Installation sub folder check
if (file_exists('install/index.php'))
{
	header ("Location: error.php?typ=install");
	exit();
}

// Load config
	require_once('config.php');
	
// Load errorsubs
	require_once('system/subs/errors.php');

// Connect to database & Load subs
	require_once('system/database/'.$ecDb['typ'].'/subs.php');
	require_once('system/database/'.$ecDb['typ'].'/backup.php');

// Load settings
	require_once('system/core/settings.php');

// Initalize plugins
	require_once('system/core/plugins.php');

// Load other subs
	require_once('system/core/access.php');
	require_once('system/subs/languages.php');
	require_once('system/subs/date.php');
	require_once('system/subs/files.php');
	require_once('system/subs/tools.php');
	require_once('system/subs/icons.php');
	require_once('system/subs/templates.php');
	
// Load autoexecuting pluginfiles

$ecAutoexecData = dbSelect('sitesPluginId,sitesName',1,'sites', "sitesTyp=3");
while($sites = mysql_fetch_object($ecAutoexecData))
{
	if (ecGetAccessLevel($ecLocal['pluginsList'][$sites->sitesPluginId],$sites->sitesName))
	{
		include ('plugins/'.$ecLocal['pluginsList'][$sites->sitesPluginId].'/'.$sites->sitesName.'.php');
	}
}

// Parse Theme & Create Website
	require_once('system/core/themes.php');
	echo $html;
	
?>