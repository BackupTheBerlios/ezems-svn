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
*/ $ecFile = 'system/core/plugins.php';

// no direct access
defined( '_VALID_EC' ) or 
	die( 'Restricted access' );

// Set Plugin & Site
if (isset($_REQUEST['view']))
{
	$ecLocal['plugin'] = $_REQUEST['view'];
	if (isset($_REQUEST['site']))
	{
		$ecLocal['site'] = $_REQUEST['site'];
	}
	else
	{
		$ecLocal['site'] = 'list';
	}
}
else
{
	$ecLocal['plugin'] = $ecSettings['system']['defaultPlugin'];
	$ecLocal['site'] = $ecSettings['system']['defaultSite'];
}

// Set Contentwidth
$contentTyp = ($ecSettings['system']['contentTyp'] == 1) ? '%' : 'px';
$ecLocal['tableWidth'] = $ecSettings['system']['contentWidth'] . $contentTyp;

// Plugins
$ecPluginsData = dbSelect('pluginsId,pluginsPath',1,'plugins');
while($plugins = mysql_fetch_object($ecPluginsData))
{
	$ecLocal['pluginsList'][$plugins->pluginsId] = $plugins->pluginsPath;
	if ($plugins->pluginsPath == $ecLocal['plugin'])
	{
		$pluginRegistred = 1;
	}
}

// Check Plugin & Site
if (isset($pluginRegistred))
{
	$viewPath = 'plugins/'.$ecLocal['plugin'].'/'.$ecLocal['site'].'.php';
	if (!file_exists($viewPath))
	{
		ecError($ecFile,'File not found '.$viewPath);
		$ecLocal['plugin'] = 'errors';
		$ecLocal['site'] = '404';
	}
}
else
{
	ecError($ecFile,'Plugin not registred: '.$ecLocal['plugin']);
	$ecLocal['plugin'] = 'errors';
	$ecLocal['site'] = '404';
}
?>