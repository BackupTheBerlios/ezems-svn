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
	*/ $ecFile = 'plugins/clanwars/remove.php';
	
	echo ecTemplate('clanwars', 'remove', 'siteHead');
	$id = $_REQUEST['id'];
	if (isset($_POST['remove']))
	{
		dbDelete(1, 'clanwars', "clanwarsId = $id");
		$next = ecReferer('index.php?view=clanwars&amp;site=manage');
		echo ecTemplate('clanwars', 'remove', 'clanwarsRemoved');
	}
	else
	{
		echo ecTemplate('clanwars', 'remove', 'clanwarsRemove');
	}
?>