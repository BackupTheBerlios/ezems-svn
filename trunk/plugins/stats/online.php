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
					$statsBrowser = 'Internet Explorer'; break;
				case 2:
					$statsBrowser = 'Netscape'; break;
				case 3:
					$statsBrowser = 'Opera'; break;
				case 4:
					$statsBrowser = 'Firefox'; break;
				case 5:
					$statsBrowser = 'Konqueror'; break;
				case 6:
					$statsBrowser = 'Safari'; break;
				case 7:
					$statsBrowser = 'AOL Browser'; break;
				default:
					$statsBrowser = 'Other';
			}
			switch ($data->statsSystem)
			{
				case 1:
					$statsOS = 'Macintosh'; break;
				case 2:
					$statsOS = 'Linux'; break;
				case 3:
					$statsOS = 'FreeBSD'; break;
				case 4:
					$statsOS = 'SunOS'; break;
				case 5:
					$statsOS = 'BeOS'; break;
				case 6:
					$statsOS = 'OS2'; break;
				case 9:
					$statsOS = 'Windows'; break;
				case 10:
					$statsOS = 'Windows Visual'; break;
				case 11:
					$statsOS = 'Windows 95'; break;
				case 12:
					$statsOS = 'Windows 98'; break;
				case 13:
					$statsOS = 'Windows Millenium'; break;
				case 14:
					$statsOS = 'Windows NT'; break;
				case 15:
					$statsOS = 'Windows XP'; break;
				case 16:
					$statsOS = 'Windows 2000'; break;
				case 17:
					$statsOS = 'Windows 2003'; break;
				case 18:
					$statsOS = 'Windows Vista'; break;

				default:
					$statsOS = 'Other';
			}
			$statsPlugin = $data->statsUriPlug;
			$statsSite = $data->statsUriSite;
			echo ecTemplate('stats', 'online', 'onlineData');
			$statsVisitors[$data->statsId] = $data->statsIP;
		}	
	}
	
	echo ecTemplate('stats', 'online', 'onlineFoot');
?>