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
*/ $ecFile = 'plugins/squads/squads.php';

echo ecTemplate('squads', 'squads', 'siteHead');

//Squad �bersicht
$ecSquadData = dbSelect('*',1,'squads,games', "(squadsGameId = gamesId)",'squadsID',1);
while($squad = mysql_fetch_object($ecSquadData))
{
	$squadPicSmall = !empty($squad->squadsPic) ? $squad->squadsPic : 'default.png';
	$squadId = $squad->squadsId;
	$squadName = $squad->squadsName;
	$squadGameId = $squad->squadsGameId;
	$squadGame = $squad->gamesName;
	$squadGameVersion = $squad->gamesVersion;
	$squadGameImg = !empty($squad->gamesIcon) ? $squad->gamesIcon : 'default.png';	
	$squadPlayersCount = 0;
	$squadPlayers = '';
	$ecPlayerData = dbSelect('*', 1, 'squadplayer,users,squadtask',"(squadplayerSquadId = $squadId) && (squadplayerUserID = usersId) && (squadplayerTaskId = squadtaskId)", 'squadtaskPriority', 1);
	while($player = mysql_fetch_object($ecPlayerData))
	{
		if ($squadPlayersCount != 0) $squadPlayers .= ', ';
		$squadPlayerId = $player->usersId;
		$squadPlayer = $player->usersUsername;
		$squadPlayersCount++;
		$squadPlayers .= ecTemplate('squads', 'squads', 'squadPlayer');
	}
	echo ecTemplate('squads', 'squads', 'squadData');
}
?>