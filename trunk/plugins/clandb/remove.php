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
	*/ $ecFile = 'plugins/clandb/remove.php';
	
	echo ecTemplate('clandb', 'remove', 'siteHead');
	$id = $_REQUEST['id'];
	if (isset($_POST['remove']))
	{
		dbDelete(1, 'clandb', "clanDbId = $id");
		$next = ecReferer('index.php?view=clandb&amp;site=manage');
		echo ecTemplate('clandb', 'remove', 'clandbRemoved');
	}
	else
	{
		echo ecTemplate('clandb', 'remove', 'clandbRemove');
	}
?>