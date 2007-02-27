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
echo ecTemplate('squads', 'manage', 'memberHead');
$ecMemberData = dbSelect('*',1,'squadplayer,squads,users', "(squadplayerUserId = usersId) && (squadplayerSquadId = squadsId)",'squadplayerId',1);
while($member = mysql_fetch_object($ecMemberData))
{
	$memberId = $member->squadplayerId;
	$memberNick = $member->usersUsername;
	$memberSquad = $member->squadsName;
	echo ecTemplate('squads', 'manage', 'memberData');
}
echo ecTemplate('squads', 'manage', 'memberFoot');
echo ecTemplate('squads', 'manage', 'memberAdd');

echo ecTemplate('squads', 'manage', 'siteFoot');
?>