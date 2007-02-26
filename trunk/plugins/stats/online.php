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
					$statsBrowser = 'Microsoft Internet Explorer';
					break;
				case 2:
					$statsBrowser = 'Microsoft Internet Explorer 4.x';
					break;
				case 3:
					$statsBrowser = 'Microsoft Internet Explorer 5.x';
					break;
				case 4:
					$statsBrowser = 'Microsoft Internet Explorer 6.x';
					break;
				case 5:
					$statsBrowser = 'Microsoft Internet Explorer 7.x';
					break;
				case 9:
					$statsBrowser = 'CrazyBrowser';
					break;
				case 10:
					$statsBrowser = 'Opera 4.x';
					break;
				case 11:
					$statsBrowser = 'Opera 5.x';
					break;
				case 12:
					$statsBrowser = 'Opera 6.x';
					break;
				case 13:
					$statsBrowser = 'Opera 7.x';
					break;
				case 14:
					$statsBrowser = 'Opera 8.x';
					break;
				case 15:
					$statsBrowser = 'Opera 9.x';
					break;
				case 20:
					$statsBrowser = 'Netscape Navigator';
					break;
				case 21:
					$statsBrowser = 'Netscape 4.x';
					break;
				case 22:
					$statsBrowser = 'Mozilla/Netscape 6.x';
					break;
				case 30:
					$statsBrowser = 'Firefox 0.x';
					break;
				case 31:
					$statsBrowser = 'Firefox 1.x';
					break;
				case 32:
					$statsBrowser = 'Firefox 2.x';
					break;
				case 40:
					$statsBrowser = 'Konqueror/Safari';
					break;
				case 41:
					$statsBrowser = 'Netgem/iPlayer';
					break;
				case 42:
					$statsBrowser = 'Handy WAP';
					break;
				default:
					$statsBrowser = 'Other';
			}
			switch ($data->statsSystem)
			{
				case 1:
					$statsOS = 'Microsoft Windows';
					break;
				case 2:
					$statsOS = 'Windows 9x';
					break;
				case 3:
					$statsOS = 'Windows Millenium';
					break;
				case 4:
					$statsOS = 'Windows 2000';
					break;
				case 5:
					$statsOS = 'Windows NT';	
					break;
				case 6:
					$statsOS = 'Windows XP';
					break;
				case 7:
					$statsOS = 'Windows 2003';
					break;
				case 8:
					$statsOS = 'Windows Vista';
					break;
				case 10:
					$statsOS = 'Macintosh';
					break;
				case 15:
					$statsOS = 'Linux/Unix';
					break;
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