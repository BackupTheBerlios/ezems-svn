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
*/ $ecFile = 'plugins/squads/manage.php';

echo ecTemplate('squads', 'manage', 'siteHead');

//Squad �bersicht
echo ecTemplate('squads', 'manage', 'squadHead');
$ecSquadData = dbSelect('*',1,'squads,games', "(squadsGameId = gamesId)",'squadsID',1);
while($squad = mysql_fetch_object($ecSquadData))
{
	$squadId = $squad->squadsId;
	$squadName = $squad->squadsName;
	$squadGame = !empty($squad->gamesIcon) ? $squad->gamesIcon : 'default.png';
	echo ecTemplate('squads', 'manage', 'squadData');
}
echo ecTemplate('squads', 'manage', 'squadFoot');
echo ecTemplate('squads', 'manage', 'squadAdd');

//Member �bersicht
echo ecTemplate('squads', 'manage', 'taskHead');
$ecTaskData = dbSelect('*',1,'squadtask');
while($task = mysql_fetch_object($ecTaskData))
{
	$taskId = $task->squadtaskId;
	$taskName = $task->squadtaskName;
	echo ecTemplate('squads', 'manage', 'taskData');
}
echo ecTemplate('squads', 'manage', 'taskFoot');
echo ecTemplate('squads', 'manage', 'taskAdd');

echo ecTemplate('squads', 'manage', 'siteFoot');
?>