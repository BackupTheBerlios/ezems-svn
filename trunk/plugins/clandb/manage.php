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
	*/ $ecFile = 'plugins/clandb/manage.php';
	
	//Kopf
	echo ecTemplate('clanDb', 'manage', 'siteHead');
	
	//Daten auslesen
	echo ecTemplate('clanDb', 'manage', 'clandbHead');
	$ecClanDbData = dbSelect('*', 1, 'clandb');
	while ($clanInfo = mysql_fetch_object($ecClanDbData))
	{
		$clanId = $clanInfo->clanDbId;
		$clanName = $clanInfo->clanDbName;
		$clanShortName = $clanInfo->clanDbShortName;
		$clanTag = $clanInfo->clanDbTag;
		//$clanCountry = $clanInfo->clanDbCountry;
		$clanWWW = $clanInfo->clanDbHomepage;
		$popup = ecTemplate('clanDb', 'manage', 'moreInfoClan');
		
		echo ecTemplate('clanDb', 'manage', 'clandbData');
	}
	echo ecTemplate('clanDb', 'manage', 'clandbFoot');
	echo ecTemplate('clanDb', 'manage', 'clandbAdd');
	
	echo ecTemplate('clanDb', 'manage', 'siteFoot');
?>