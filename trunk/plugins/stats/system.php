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

	$insertstats = array();
	
	$insertstats['statsIP'] = $ecLocal['userIP'];
/*
	switch ($browser)
	{
		case 'Microsoft Internet Explorer':
			$insertstats['statsBrowser'] = 1;
			break;
		case 'Microsoft Internet Explorer 4.x':
			$insertstats['statsBrowser'] = 2;
			break;
		case 'Microsoft Internet Explorer 5.x':
			$insertstats['statsBrowser'] = 3;
			break;
		case 'Microsoft Internet Explorer 6.x';
			$insertstats['statsBrowser'] = 4;
			break;
		case 'Microsoft Internet Explorer 7.x';
			$insertstats['statsBrowser'] = 5;
			break;
		case 'CrazyBrowser';
			$insertstats['statsBrowser'] = 9;
			break;
		case 'Crazy Browser';
			$insertstats['statsBrowser'] = 9;
			break;
		case 'Opera 4.x';
			$insertstats['statsBrowser'] = 10;
			break;
		case 'Opera 5.x';
			$insertstats['statsBrowser'] = 11;
			break;
		case 'Opera 6.x';
			$insertstats['statsBrowser'] = 12;
			break;
		case 'Opera 7.x';
			$insertstats['statsBrowser'] = 13;
			break;
		case 'Opera 8.x';
			$insertstats['statsBrowser'] = 14;
			break;
		case 'Opera 9.x';
			$insertstats['statsBrowser'] = 15;
			break;
		case 'Netscape Navigator';
			$insertstats['statsBrowser'] = 20;
			break;
		case 'Netscape 4.x';
			$insertstats['statsBrowser'] = 21;
			break;
		case 'Mozilla/Netscape 6.x';
			$insertstats['statsBrowser'] = 22;
			break;
		case 'Firefox 0.x';
			$insertstats['statsBrowser'] = 30;
			break;
		case 'Firefox 1.x';
			$insertstats['statsBrowser'] = 31;
			break;
		case 'Firefox 2.x';
			$insertstats['statsBrowser'] = 32;
			break;
		case 'Konqueror/Safari';
			$insertstats['statsBrowser'] = 40;
			break;
		case 'Netgem/iPlayer';
			$insertstats['statsBrowser'] = 41;
			break;
//Handy Browser
		case 'pirelli';
			$insertstats['statsBrowser'] = 42;
			break;
		default:
			$insertstats['statsBrowser'] = 0;
	}
	switch ($system)
	{
		case 'Microsoft Windows':
			$insertstats['statsSystem'] = 1;
			break;
		case '':
			$insertstats['statsSystem'] = 2;
			break;
		case '':
			$insertstats['statsSystem'] = 3;
			break;
		case '';
			$insertstats['statsSystem'] = 4;
			break;
		case '';
			$insertstats['statsSystem'] = 5;
			break;
		case 'Microsoft Windows XP';
			$insertstats['statsSystem'] = 6;
			break;
		case 'Microsoft Windows 2003';
			$insertstats['statsSystem'] = 7;
			break;
		case 'Microsoft Windows Vista';
			$insertstats['statsSystem'] = 8;
			break;
		case 'Macintosh';
			$insertstats['statsSystem'] = 10;
			break;
		case 'Linux/Unix';
			$insertstats['statsSystem'] = 15;
			break;
		default:
			$insertstats['statsSystem'] = 0;
	}
*/
$insertstats['statsBrowser'] = 0;
$insertstats['statsSystem'] = 0;
	$insertstats['statsReferer'] = 0;
	$insertstats['statsUriPlug'] = $ecLocal['plugin'];
	$insertstats['statsUriSite'] = $ecLocal['site'];
	$insertstats['statsTime'] = $ecLocal['timestamp'];
	
	dbInsert(1, 'stats', $insertstats);
	?>