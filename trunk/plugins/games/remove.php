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
	*/ $ecFile = 'plugins/games/remove.php';
	
	echo ecTemplate('games', 'remove', 'siteHead');
	$id = $_REQUEST['id'];
	if (isset($_POST['remove']))
	{
		dbDelete(1, 'games', "gamesId = $id");
		$next = ecReferer('index.php?view=games&amp;site=manage');
		echo ecTemplate('games', 'remove', 'gamesRemoved');
	}
	else
	{
		echo ecTemplate('games', 'remove', 'gamesRemove');
	}
?>