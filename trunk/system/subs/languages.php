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
*/ $ecFile = 'system/subs/languages.php';

// Languages
$ecLanguagesData = dbSelect('languagesId,languagesPath',1,'languages');
while($languages = mysql_fetch_object($ecLanguagesData))
{
	$ecLocal['languagesList'][$languages->languagesId] = $languages->languagesPath;
}

// Load Languages
$ecLocal['language'] = $ecLocal['languagesList'][$ecUser['languageId']];
$languagesPath = 'languages/'.$ecLocal['language'];
if (!file_exists($languagesPath))
{
	$ecLocal['language'] = $ecLocal['languagesList'][$ecSettings['system']['defaultLanguageId']];
	$languagesPath = 'languages/'.$ecLocal['language'];
	if (!file_exists($languagesPath))
	{
		header("Location: error.php?typ=languages");
		exit();
	}
}
include('languages/'.$ecLocal['language'].'/global.php');

function ecGetLang($plugin, $site)
{
	global $ecLocal;
	$languagesPath = 'languages/'.$ecLocal['language'].'/'.$plugin.'/'.$site.'.php';
	include $languagesPath;
	return $ecLang;
}
?>