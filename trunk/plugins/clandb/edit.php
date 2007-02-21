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
	*/ $ecFile = 'plugins/clandb/edit.php';
	
	echo ecTemplate('clanDb', 'edit', 'siteHead');
	$ecLang = ecGetLang('clandb', 'edit');
	if (isset($_POST['save']))
	{
		if (!empty($_POST['clanDbName']))
		{
			$clanId = $_POST['clanDbId'];
			$update['clanDbName'] = $_POST['clanDbName'];
			$update['clanDbShortName'] =  $_POST['clanDbShortName'];
			$update['clanDbTag'] = $_POST['clanDbTag'];
			$update['clanDbHomepage'] = $_POST['clanDbHomepage'];
			
			dbUpdate(1, 'clandb', $update, $clanDbId = $clanId);

			$next = ecReferer('index.php?view=clandb&amp;site=manage');
			echo ecTemplate('clandb', 'edit', 'clanEdited');
		}
		else
		{
			$errorMsg = $ecLang['errorEmpty'];
			echo ecTemplate('clandb', 'edit', 'siteEntry');
		}
	}
	else
	{
		$id = $_REQUEST['clanId'];
		$errorMsg = '';
		
		$ecClanDbData = dbSelect('*', 1, 'clandb', 'clanDbId = '.$id);
		while ($clanInfo = mysql_fetch_object($ecClanDbData))
		{
			$clanDbId = $clanInfo->clanDbId;
			$clanDbName = $clanInfo->clanDbName;
			$clanDbShortName = $clanInfo->clanDbShortName;
			$clanDbTag = $clanInfo->clanDbTag;
			//$clanCountry = $clanInfo->clanDbCountry;
			$clanDbHomepage = $clanInfo->clanDbHomepage;
			echo ecTemplate('clanDb', 'edit', 'siteEntry');
		}
	}
?>