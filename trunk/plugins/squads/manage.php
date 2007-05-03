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
*/ $ecFile = 'plugins/squads/manage.php';

echo ecTemplate('squads', 'manage', 'siteHead');

if (isset($_POST['save']))
{
	$data['clanName'] = $_POST['clanName'];
	$data['clanNation'] = $_POST['clanNation'];
	ecSettings('squads', $data);
	$next = ecReferer('index.php?view=squads&amp;site=manage');
	echo ecTemplate('squads', 'manage', 'settingsSaved');
}
else
{
	//Squad Übersicht
	echo ecTemplate('squads', 'manage', 'squadHead');
	$ecSquadData = dbSelect('*',1,'squads,games', "(squadsGameId = gamesId)",'squadsID',1);
	while($squad = mysql_fetch_object($ecSquadData))
	{
		$squadId = $squad->squadsId;
		$squadName = $squad->squadsName;
		$squadGameId = $squad->gamesId;
		$squadGameName = $squad->gamesName;
		$squadGameVersion = $squad->gamesVersion;
		$squadGameImg = !empty($squad->gamesIcon) ? $squad->gamesIcon : 'default.png';
		echo ecTemplate('squads', 'manage', 'squadData');
	}
	echo ecTemplate('squads', 'manage', 'squadFoot');
	
	//Member Übersicht
	echo ecTemplate('squads', 'manage', 'taskHead');
	$ecTaskData = dbSelect('*',1,'squadtask','','squadtaskPriority',1);
	while($task = mysql_fetch_object($ecTaskData))
	{
		$taskId = $task->squadtaskId;
		$taskName = $task->squadtaskName;
		$taskPriority = $task->squadtaskPriority;
		echo ecTemplate('squads', 'manage', 'taskData');
	}
	echo ecTemplate('squads', 'manage', 'taskFoot');
	$clanName = $ecSettings['squads']['clanName'];
	$clanNationId = $ecSettings['squads']['clanNation'];
	$clanNationName = $ecGobalLang['country'][$ecSettings['squads']['clanNation']];
	$countries = '';
	foreach ($ecGobalLang['country'] as $short => $name)
	{
		$countries .= ecTemplate('clandb', 'edit', 'select');
	}
	echo ecTemplate('squads', 'manage', 'clanNation');
	echo ecTemplate('squads', 'manage', 'siteFoot');
}
?>