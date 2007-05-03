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
*/ $ecFile = 'plugins/squads/users.php';

echo ecTemplate('squads', 'users', 'siteHead');

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

echo ecTemplate('squads', 'users', 'detailsBarHead');
if (ecGetAccessLevel('users','details')) echo ecTemplate('squads', 'users', 'detailsBarUsers');
echo ecTemplate('squads', 'users', 'detailsBarClans');
if (ecGetAccessLevel('computer','users')) echo ecTemplate('squads', 'users', 'detailsBarComputer');
if (ecGetAccessLevel('board','users')) echo ecTemplate('squads', 'users', 'detailsBarBoard');
if (ecGetAccessLevel('gbook','users')) echo ecTemplate('squads', 'users', 'detailsBarGBook');
echo ecTemplate('squads', 'users', 'detailsBarFoot');

echo ecTemplate('squads', 'users', 'squadHead');
$ecSquadData = dbSelect('*',1,'squadplayer,squads,games,squadtask', "(squadplayerUserId = $id) AND (squadsId = squadplayerSquadId) AND (gamesId = squadsGameId) AND (squadtaskId = squadplayerTaskId)");
while($squad = mysql_fetch_object($ecSquadData))
{
	$squadId = $squad->squadsId;
	$squadName = $squad->squadsName;
	$squadGameId = $squad->gamesId;
	$squadGameImg = !empty($squad->gamesIcon) ? $squad->gamesIcon : 'default.png';	
	$squadTask = $squad->squadtaskName;
	$squadTime = ecDate($squad->squadplayerTime,2);
	echo ecTemplate('squads', 'users', 'squadData');
}
echo ecTemplate('squads', 'users', 'squadFoot');
?>