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
	*/ $ecFile = 'plugins/stats/navi.php';
	
	echo ecTemplate('stats', 'navi', 'siteHead');

	if (!empty($ecSettings['stats']['online']))
	{
		// Online
		$statsVisitors = array();
		$reach = $ecLocal['timestamp'] - 180;
		$ecStatsData = dbSelect('statsIP',1,'stats',"statsTime > $reach");
		while($data = mysql_fetch_object($ecStatsData))
		{
			$statsVisitors[$data->statsIP] = 1;
		}
		$statsOnline = count($statsVisitors);
		
		if (ecGetAccessLevel('stats','online')) echo ecTemplate('stats', 'navi', 'statsOnlineLink');
			else echo ecTemplate('stats', 'navi', 'statsOnline');
		
	}
	if (!empty($ecSettings['stats']['yesterday']))
	{
		// Today
		$statsVisitors = array();
		$reach = mktime(0,0,0,date("n",$ecLocal['timestamp']),date("d",$ecLocal['timestamp']),date("Y",$ecLocal['timestamp']));
		$ecStatsData = dbSelect('statsIP',1,'stats',"statsTime > $reach");
		while($data = mysql_fetch_object($ecStatsData))
		{
			$statsVisitors[$data->statsIP] = 1;
		}
		$statsToday = count($statsVisitors);
		echo ecTemplate('stats', 'navi', 'statsToday');
	}
	if (!empty($ecSettings['stats']['yesterday']))
	{
		// Yesterday
		$statsVisitors = array();
		$reach1 = mktime(0,0,0,date("n",$ecLocal['timestamp']),date("d",$ecLocal['timestamp'])-1,date("Y",$ecLocal['timestamp']));
		$reach2 = mktime(23,59,59,date("n",$ecLocal['timestamp']),date("d",$ecLocal['timestamp'])-1,date("Y",$ecLocal['timestamp']));
		
		$ecStatsData = dbSelect('statsIP',1,'stats',"statsTime > $reach1 AND statsTime < $reach2");
		while($data = mysql_fetch_object($ecStatsData))
		{
			$statsVisitors[$data->statsIP] = 1;
		}
		$statsYesterday = count($statsVisitors);
		echo ecTemplate('stats', 'navi', 'statsYesterday');
	}
	if (!empty($ecSettings['stats']['month']))
	{
		// Month
		$statsVisitors = array();
		$reach = mktime(0,0,0,date("n",$ecLocal['timestamp']),1,date("Y",$ecLocal['timestamp']));
		
		$ecStatsData = dbSelect('statsIP,statsTime',1,'stats',"statsTime > $reach");
		while($data = mysql_fetch_object($ecStatsData))
		{
			$date = date('n.d.Y',$data->statsTime);
			$statsVisitors[$data->statsIP.$date] = 1;
		}
		
		$statsMonth = count($statsVisitors);
		echo ecTemplate('stats', 'navi', 'statsMonth');
	}
	if (!empty($ecSettings['stats']['all']))
	{
		// All
		$statsVisitors = array();
		$ecStatsData = dbSelect('statsIP,statsTime',1,'stats');
		while($data = mysql_fetch_object($ecStatsData))
		{
			$date = date('n.d.Y',$data->statsTime);
			$statsVisitors[$data->statsIP.$date] = 1;
		}
		
		$statsAll = count($statsVisitors);
		echo ecTemplate('stats', 'navi', 'statsAll');
	}
	if (!empty($ecSettings['stats']['hits']))
	{
		// Hits
		$ecStatsData = dbSelect('COUNT(*) as statsCount',1,'stats');
		$data = mysql_fetch_assoc($ecStatsData);
		$statsHits = $data['statsCount'];
		echo ecTemplate('stats', 'navi', 'statsHits');
	}

	echo ecTemplate('stats', 'navi', 'siteFoot');

	if (ecGetAccessLevel('stats','list')) echo ecTemplate('stats', 'navi', 'statsMore');
?>