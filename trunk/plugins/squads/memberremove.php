<?php
	/*
	 (C) 2006 EZEMS.NET Alle Rechte vorbehalten.
	 
	 Dieses Programm ist urheberrechtlich gesch�tzt.
	 Die Verwendung f�r private Zwecke ist gesattet.
	 Unbrechtigte Nutzung (Verkauf, Weiterverbreitung,
	 Nutzung ohne Urherberrechtsvermerk, kommerzielle
	 Nutzung) ist strafbar.
	 Die Nutzung des Scriptes erfolgt auf eigene Gefahr.
	 Sch�den die durch die Nutzung entstanden sind,
	 tr�gt allein der Nutzer des Programmes.
	*/ $ecFile = 'plugins/squads/squadremove.php';
	
	echo ecTemplate('squads', 'memberremove', 'siteHead');
	$id = $_REQUEST['id'];
	if (isset($_POST['remove']))
	{
		
		dbDelete(1, 'squadplayer', "squadplayerId = $id");
		$next = ecReferer('index.php?view=squads&amp;site=squadedit&amp;id='.$_POST['squad']);
		echo ecTemplate('squads', 'memberremove', 'memberRemoved');
	}
	else
	{
		$squad = $_REQUEST['squad'];
		echo ecTemplate('squads', 'memberremove', 'memberRemove');
	}
?>