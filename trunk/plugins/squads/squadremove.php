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
	*/ $ecFile = 'plugins/squads/squadremove.php';
	
	echo ecTemplate('squads', 'squadremove', 'siteHead');
	$id = $_REQUEST['id'];
	if (isset($_POST['remove']))
	{
		dbDelete(1, 'squads', "squadsId = $id");
		$next = ecReferer('index.php?view=squads&amp;site=manage');
		echo ecTemplate('squads', 'squadremove', 'squadRemoved');
	}
	else
	{
		echo ecTemplate('squads', 'squadremove', 'squadRemove');
	}
?>