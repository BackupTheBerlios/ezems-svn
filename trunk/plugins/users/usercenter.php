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
*/ $ecFile = 'plugins/users/usercenter.php';

echo ecTemplate('users', 'usercenter', 'siteHead');

echo ecTemplate('users', 'usercenter', 'usercenterHead');
$ecUsercenterData = dbSelect('sitesName,sitesPluginId',1,'sites', "sitesTyp=7");
while($usersites = mysql_fetch_object($ecUsercenterData))
{
	$sitePath = $usersites->sitesName;
	$pluginPath = $ecLocal['pluginsList'][$usersites->sitesPluginId];
	if (ecGetAccessLevel($pluginPath, $sitePath))
	{
		$ecLang = ecGetLang($pluginPath, $sitePath);
		$usersiteName = isset($ecLang['usercenterName']) ? $ecLang['usercenterName'] : '-';
		$usersiteDescription = isset($ecLang['usercenterDescription']) ? $ecLang['usercenterDescription'] : '-';
		echo ecTemplate('users', 'usercenter', 'usercenterData');	
	}
}

echo ecTemplate('users', 'usercenter', 'usercenterFoot');

?>