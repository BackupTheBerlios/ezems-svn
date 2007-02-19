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
	*/ $ecFile = 'plugins/stats/system.php';

	$browser = get_browser();
	$insertstats = array();
	
	$insertstats['statsIP'] = $ecLocal['userIP'];
	switch ($browser->browser)
	{
		case 'Default Browser':
			$insertstats['statsBrowser'] = 1;
			break;
		case 'Mozilla':
			$insertstats['statsBrowser'] = 2;
			break;
		case 'Netscape':
			$insertstats['statsBrowser'] = 3;
			break;
		default:
			$insertstats['statsBrowser'] = 0;
	}
	$insertstats['statsReferer'] = 0;
	$insertstats['statsUriPlug'] = $ecLocal['plugin'];
	$insertstats['statsUriSite'] = $ecLocal['site'];
	$insertstats['statsTime'] = $ecLocal['timestamp'];
	
	dbInsert(1, 'stats', $insertstats);
	?>