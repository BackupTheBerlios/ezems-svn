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
*/ $ecFile = 'plugins/system/admin.php';

// Head
echo ecTemplate('system', 'admin', 'siteHead');

// Plugins
echo ecTemplate('system', 'admin', 'pluginsHead');
$ecPluginsData = dbSelect('pluginsName,pluginsPath,pluginsInfo',1,'plugins');
while($plugins = mysql_fetch_object($ecPluginsData))
{
	if (file_exists('plugins/'.$plugins->pluginsPath.'/manage.php') && ecGetAccessLevel($plugins->pluginsPath, 'manage'))
	{
		$pluginName = $plugins->pluginsName;
		$pluginFolder = $plugins->pluginsPath;
		$pluginDescription = $plugins->pluginsInfo;
		echo ecTemplate('system', 'admin', 'pluginsData');
	}
}
echo ecTemplate('system', 'admin', 'pluginsFoot');

// Tools
echo ecTemplate('system', 'admin', 'systemToolsHead');

$ecToolsData = dbSelect('sitesName,sitesPluginId',1,'sites', "sitesTyp=2");
while($sites = mysql_fetch_object($ecToolsData))
{
	$sitePath = $sites->sitesName;
	$pluginPath = $ecLocal['pluginsList'][$sites->sitesPluginId];
	if (ecGetAccessLevel($pluginPath, $sitePath))
	{
		$ecLang = ecGetLang($pluginPath, $sitePath);
		$toolName = isset($ecLang['toolName']) ? $ecLang['toolName'] : '-';
		$toolDescription = isset($ecLang['toolDescription']) ? $ecLang['toolDescription'] : '-';
		echo ecTemplate('system', 'admin', 'systemToolsData');	
	}
}

echo ecTemplate('system', 'admin', 'systemToolsFoot');

// Versioncheck
$ecLang = ecGetLang('system', 'admin');
$installedVersion = $ecSettings['system']['version'];
$serverVersion = implode('',file('http://www.phoenix-swiss.net/version.php'));

if (version_compare($installedVersion, $serverVersion) != -1)
{
	$message = $ecLang['uptodate'];
	$versionSymbol = 'green';
}
else
{
	$message = $ecLang['outdated'];
	$versionSymbol = 'red';
}
echo ecTemplate('system', 'admin', 'versionCheck');
?>