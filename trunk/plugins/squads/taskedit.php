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
*/ $ecFile = 'plugins/squads/taskedit.php';

echo ecTemplate('squads', 'taskedit', 'siteHead');
$ecLang = ecGetLang('squads', 'taskedit');
$id = $_REQUEST['id'];
if (isset($_POST['save']))
{
	if (!empty($_POST['taskName']))
	{
		$update['squadtaskName'] = $_POST['taskName'];	
		$update['squadtaskPriority'] = $_POST['taskPriority'];
		dbUpdate(1, 'squadtask', $update, "squadtaskId = $id");
		
		$next = ecReferer('index.php?view=squads&amp;site=manage');
		echo ecTemplate('squads', 'taskedit', 'taskEdited');
	}
	else
	{
		$errorMsg = $ecLang['errorEmpty'];
		echo ecTemplate('squads', 'taskedit', 'taskEdit');
	}
}
else
{
	$ecTaskData = dbSelect('*',1,'squadtask', "squadtaskId = $id");
	while($tasks = mysql_fetch_object($ecTaskData))
	{
		$taskName = $tasks->squadtaskName;
		$taskPriority = $tasks->squadtaskPriority;
		$errorMsg = '';
		echo ecTemplate('squads', 'taskedit', 'taskEdit');
	}
}
?>