<?php
	/*
	 (C) 2006 EZEMS.NET Alle Rechte vorbehalten.
	 
	 Dieses Programm ist urheberrechtlich gesch�tzt.
	 Die Verwendung f�r private Zwecke ist gesattet.
	 Unbrechtigte Nutzung (Verkauf, Weiterverbreitung,
	 Nutzung ohne Urherberrechtsvermerk, kommerzielle
	 Nutzung) ist strafbar.
	 Die Nutzung des Scriptes erfolgt auf eigene Gefahr.
	 Sch�den die durch die Nutzung entstanden sind,
	 tr�gt allein der Nutzer des Programmes.
	*/ $ecFile = 'plugins/clandb/manage.php';
	
	//Kopf
	echo ecTemplate('clanDb', 'manage', 'siteHead');
	
	//Daten auslesen
	echo ecTemplate('clanDb', 'manage', 'siteEntry');
	$ecClanDbData = dbSelect('*', 1, 'clandb');
	while ($clanInfo = mysql_fetch_object($ecClanDbData))
	{
		$clanId = $clanInfo->clanDbId;
		$clanName = $clanInfo->clanDbName;
		$clanShortName = $clanInfo->clanDbShortName;
		$clanTag = $clanInfo->clanDbTag;
		//$clanCountry = $clanInfo->clanDbCountry;
		$clanHomepage = $clanInfo->clanDbHomepage;
		$popup = ecTemplate('clanDb', 'manage', 'moreInfoClan');
		
		echo ecTemplate('clanDb', 'manage', 'siteData');
	}
	echo ecTemplate('clanDb', 'manage', 'siteFoot');
	echo ecTemplate('clanDb', 'manage', 'siteAdd');
?>