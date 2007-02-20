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
*/ $ecFile = 'plugins/system/packages.php';

echo ecTemplate('system', 'packages', 'siteHead');

$ecLang = ecGetLang('system', 'packages');

// Plugins
$listTyp = 'plugins';
$listTitle = $ecLang[$listTyp];
echo ecTemplate('system', 'packages', 'listHead');
$ecPluginsData = dbSelect('*',1,$listTyp);
while($plugins = mysql_fetch_object($ecPluginsData))
{
	$listId = $plugins->pluginsId;
	$listName = $plugins->pluginsName;
	$listFolder = $plugins->pluginsPath;
	$listInfo = $plugins->pluginsInfo;
	$listDescription = $plugins->pluginsInfo;
	$listAutor = $plugins->pluginsAutor;
	$listWWW = $plugins->pluginsWWW;
	$listReqPlugins = $plugins->pluginsReqPlugins;
	$listReqTables = $plugins->pluginsReqTables;
	$listInstall = ecDate($plugins->pluginsTime, 1).' '.ecDate($plugins->pluginsTime, 2);
	$popup = ecTemplate('system', 'packages', 'moreInfo');
	echo ecTemplate('system', 'packages', 'listData');
}
echo ecTemplate('system', 'packages', 'listFoot');

// Themes
$listTyp = 'themes';
$listTitle = $ecLang[$listTyp];
echo ecTemplate('system', 'packages', 'listHead');
$ecPluginsData = dbSelect('*',1,$listTyp);
while($themes = mysql_fetch_object($ecPluginsData))
{
	$listId = $themes->themesId;
	$listName = $themes->themesName;
	$listFolder = $themes->themesPath;
	$listInfo = $themes->themesInfo;
	$listDescription = $themes->themesInfo;
	$listAutor = $themes->themesAutor;
	$listWWW = $themes->themesWWW;
	$listReqPlugins = '-';
	$listReqTables = '-';
	$listInstall = ecDate($themes->themesTime, 1).' '.ecDate($themes->themesTime, 2);
	$popup = ecTemplate('system', 'packages', 'moreInfo');
	echo ecTemplate('system', 'packages', 'listData');
}
echo ecTemplate('system', 'packages', 'listFoot');

// Languages
$listTyp = 'languages';
$listTitle = $ecLang[$listTyp];
echo ecTemplate('system', 'packages', 'listHead');
$ecPluginsData = dbSelect('*',1,$listTyp);
while($languages = mysql_fetch_object($ecPluginsData))
{
	$listId = $languages->languagesId;
	$listName = $languages->languagesName;
	$listFolder = $languages->languagesPath;
	$listInfo = $languages->languagesInfo;
	$listDescription = $languages->languagesInfo;
	$listAutor = $languages->languagesAutor;
	$listWWW = $languages->languagesWWW;
	$listReqPlugins = '-';
	$listReqTables = '-';
	$listInstall = ecDate($languages->languagesTime, 1).' '.ecDate($languages->languagesTime, 2);
	$popup = ecTemplate('system', 'packages', 'moreInfo');
	echo ecTemplate('system', 'packages', 'listData');
}
echo ecTemplate('system', 'packages', 'listFoot');

// Templates
$listTyp = 'templates';
$listTitle = $ecLang[$listTyp];
echo ecTemplate('system', 'packages', 'listHead');
$ecPluginsData = dbSelect('*',1,$listTyp);
while($templates = mysql_fetch_object($ecPluginsData))
{
	$listId = $templates->templatesId;
	$listName = $templates->templatesName;
	$listFolder = $templates->templatesPath;
	$listInfo = $templates->templatesInfo;
	$listDescription = $templates->templatesInfo;
	$listAutor = $templates->templatesAutor;
	$listWWW = $templates->templatesWWW;
	$listReqPlugins = '-';
	$listReqTables = '-';
	$listInstall = ecDate($templates->templatesTime, 1).' '.ecDate($templates->templatesTime, 2);
	$popup = ecTemplate('system', 'packages', 'moreInfo');
	echo ecTemplate('system', 'packages', 'listData');
}
echo ecTemplate('system', 'packages', 'listFoot');

// Icons
$listTyp = 'icons';
$listTitle = $ecLang[$listTyp];
echo ecTemplate('system', 'packages', 'listHead');
$ecPluginsData = dbSelect('*',1,$listTyp);
while($icons = mysql_fetch_object($ecPluginsData))
{
	$listId = $icons->iconsId;
	$listName = $icons->iconsName;
	$listFolder = $icons->iconsPath;
	$listInfo = $icons->iconsInfo;
	$listDescription = $icons->iconsInfo;
	$listAutor = $icons->iconsAutor;
	$listWWW = $icons->iconsWWW;
	$listReqPlugins = '-';
	$listReqTables = '-';
	$listInstall = ecDate($icons->iconsTime, 1).' '.ecDate($icons->iconsTime, 2);
	$popup = ecTemplate('system', 'packages', 'moreInfo');
	echo ecTemplate('system', 'packages', 'listData');
}
echo ecTemplate('system', 'packages', 'listFoot');

// New
echo ecTemplate('system', 'packages', 'newPackage');

echo ecTemplate('system', 'packages', 'siteFoot');

?>