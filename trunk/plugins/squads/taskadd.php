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
*/ $ecFile = 'plugins/squads/taskadd.php';

echo ecTemplate('squads', 'taskadd', 'siteHead');
if (isset($_POST['save']))
{
	if (!empty($_POST['taskName']))
	{
		$insert['squadtaskName'] = $_POST['taskName'];
			
		dbInsert(1, 'squadtask', $insert);
		
		$next = ecReferer('index.php?view=squads&amp;site=manage');
		echo ecTemplate('squads', 'taskadd', 'taskAdded');
	}
	else
	{
		$errorMsg = $ecLang['errorEmpty'];
		echo ecTemplate('squads', 'taskadd', 'taskAdd');
	}
}
else
{
	echo ecTemplate('squads', 'taskadd', 'taskAdd');
}
?>