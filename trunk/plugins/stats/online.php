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
	*/ $ecFile = 'plugins/stats/online.php';
	
	echo ecTemplate('stats', 'online', 'siteHead');
	
	$statsVisitors = array();
	$reach = $ecLocal['timestamp'] - 180;
	$ecStatsData = dbSelect('*',1,'stats',"statsTime > $reach",'statsId',2);
	echo ecTemplate('stats', 'online', 'onlineHead');
	while($data = mysql_fetch_object($ecStatsData))
	{
		if (!in_array($data->statsIP,$statsVisitors))
		{
			$statsId = $data->statsId;
			switch ($data->statsBrowser)
			{
				case 1:
					$statsBrowser = 'Internet Explorer';
					break;
				case 2:
					$statsBrowser = 'Mozilla';
					break;
				case 3:
					$statsBrowser = 'Netscape';
					break;
				default:
					$statsBrowser = 'Other';
			}
			$statsPlugin = $data->statsUriPlug;
			$statsSite = $data->statsUriSite;
			echo ecTemplate('stats', 'online', 'onlineData');
			$statsVisitors[$data->statsId] = $data->statsIP;
		}	
	}
	
	echo ecTemplate('stats', 'online', 'onlineFoot');
?>