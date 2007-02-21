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
	*/ $ecFile = 'plugins/clandb/add.php';
	
	echo ecTemplate('clanDb', 'add', 'siteHead');
	$ecLang = ecGetLang('clandb', 'add');
	if (isset($_POST['save']))
	{
		if (!empty($_POST['clanDbName']))
		{
			$insert['clanDbName'] = $_POST['clanDbName'];
			$insert['clanDbShortName'] =  $_POST['clanDbShortName'];
			$insert['clanDbTag'] = $_POST['clanDbTag'];
			$insert['clanDbHomepage'] = $_POST['clanDbHomepage'];
			
			dbInsert(1, 'clandb', $insert);

			$next = ecReferer('index.php?view=clandb&amp;site=manage');
			echo ecTemplate('clandb', 'add', 'clanAdded');
		}
		else
		{
			$errorMsg = $ecLang['errorEmpty'];
			echo ecTemplate('clandb', 'add', 'siteEntry');
		}
	}
	else
	{
		$errorMsg = '';
		$clanDbHomepage = 'http://';
		echo ecTemplate('clanDb', 'add', 'siteEntry');
	}
?>