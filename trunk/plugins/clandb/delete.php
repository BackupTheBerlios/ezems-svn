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
	*/ $ecFile = 'plugins/clandb/delete.php';
	
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
	echo ecTemplate('clanDb', 'delete', 'siteHead');
	
	if($action == 'selectiondelete')
	{
		$delete = $_POST['delete'];
		foreach($delete as $deleteId)
		{
			dbDelete(1,'clandb','clanDbId = '.$deleteId);
		}
		$next = ecReferer('index.php?view=clandb&amp;site=manage');
		echo ecTemplate('clanDb', 'delete', 'siteEntry');
	}
	
	if($action == 'delete')
	{
		$clanId = $_REQUEST['id'];
		dbDelete(1,'clandb','clanDbId = '.$clanId);
		//Template laden
		$next = ecReferer('index.php?view=clandb&amp;site=manage');
		echo ecTemplate('clanDb', 'delete', 'siteEntry');
	}
	
	if(empty($action))
	{
		$next = ecReferer('index.php?view=clandb&amp;site=manage');
		echo ecTemplate('clanDb', 'delete', 'siteError');
	}
?>