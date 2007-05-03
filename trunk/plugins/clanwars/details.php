<?php
/*
 (C) 2006 EC-CP.NET Alle Rechte vorbehalten.

 Dieses Programm ist urheberrechtlich geschützt.
 Die Verwendung für private Zwecke ist gesattet.
 Unbrechtigte Nutzung (Verkauf, Weiterverbreitung,
 Nutzung ohne Urherberrechtsvermerk, kommerzielle
 Nutzung) ist strafbar.
 Die Nutzung des Scriptes erfolgt auf eigene Gefahr.
 Schäden die durch die Nutzung entstanden sind,
 trägt allein der Nutzer des Programmes.
*/ $ecFile = 'plugins/clanwars/details.php';

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

echo ecTemplate('clanwars', 'details', 'siteHead');
$ecClanwarsData = dbSelect('*', 1, 'clanwars,games,squads,clandb',"(clanwarsGameId = gamesId) AND (clanwarsSquadId = squadsId) AND (clanwarsEnemyId = clandbId) AND (clanwarsId = $id)");
$clanwar = mysql_fetch_assoc($ecClanwarsData);
$clanwarsId = $clanwar['clanwarsId'];
$clanwarsDate = ecDate($clanwar['clanwarsTime'],2);
$clanwarsTime = ecDate($clanwar['clanwarsTime'],1);
$clanwarsSquadId = $clanwar['clanwarsSquadId'];
$clanwarsSquadName = $clanwar['squadsName'];
$clanwarsSquadImg = !empty($clanwar['squadsPic']) ? $clanwar['squadsPic'] : 'default.png';
$clanwarsGameId = $clanwar['gamesId'];
$clanwarsGameName = $clanwar['gamesName'];
$clanwarsGameImg = $clanwar['gamesIcon'];
$clanwarsEnemyId = $clanwar['clandbId'];
$clanwarsEnemyName = $clanwar['clandbName'];
$clanwarsInfo = $clanwar['clanwarsInfo'];
$clanwarsEnemyImg = !empty($clanwar['clandbImage']) ? $clanwar['clandbImage'] : 'default.png';
$cwTypes = array(	1 => 'Clanwar',
					2 => 'Funwar',
					3 => 'Friendlywar',
					4 => 'Trainwar',
					5 => 'Ligawar',
					6 => 'Other');
$clanwarsTyp = $cwTypes[$clanwar['clanwarsTypId']];
$clanwarsSquadNation = $ecSettings['squads']['clanNation'];
$clanwarsEnemyNation = $clanwar['clandbCountry'];

$squadLineup = '';
$clanwarsSquadPlayerCount = 0;
$squadPlayer = explode("|µ|", $clanwar['clanwarsSquadListId']);
$ecSquadData = dbSelect('squadplayerId,usersId,usersUsername,squadsTag,usersNation', 1, 'squadplayer,squadtask,users,squads', "(squadplayerTaskId = squadtaskID) AND (squadplayerUserId = usersId) AND (squadsId = squadplayerSquadId)");
while ($player  = mysql_fetch_object($ecSquadData)) 
{
	if (in_array($player->squadplayerId,$squadPlayer))
	{
		$name = $player->squadsTag.$player->usersUsername;
		$nation = $player->usersNation;
		$userId = $player->usersId;
		$squadLineup .= ecTemplate('clanwars', 'details', 'squadLineup');
		$clanwarsSquadPlayerCount++;
	}
}
$clanwarsEnemyPlayerCount = 0;
$enemyLineup = '';
$enemySquadPlayer = explode("|µ|", $clanwar['clanwarsListEnemy']);
foreach ($enemySquadPlayer as $nick)
{
	if (!empty($nick))
	{
		$name = $clanwar['clandbTag'].$nick;
		$enemyLineup .= ecTemplate('clanwars', 'details', 'enemyLineup');
		$clanwarsEnemyPlayerCount++;	
	}
}
$clanwarsXonX = $clanwarsSquadPlayerCount.' on '.$clanwarsEnemyPlayerCount;
$clanwarsRounds = '';
$totalScoreSquad = 0;
$totalScoreEnemy = 0;
$mapArray = explode("|µ|", $clanwar['clanwarsMaps']);
$scoreArray = explode("|µ|", $clanwar['clanwarsResults']);
foreach ($mapArray as $id => $map)
{
	if (!empty($map))
	{
		$scorePerRoundArray = explode(':', $scoreArray[$id]);
		$scoreSquadRound1 = $scorePerRoundArray[0];
		$scoreEnemyRound1 = $scorePerRoundArray[1];
		$scoreSquadRound2 = $scorePerRoundArray[2];
		$scoreEnemyRound2 = $scorePerRoundArray[3];
		// Total Scores
		$totalScoreSquad += $scoreSquadRound1 + $scoreSquadRound2;
		$totalScoreEnemy += $scoreEnemyRound1 + $scoreEnemyRound2;
		$clanwarsRounds.= ecTemplate('clanwars', 'details', 'mapRound');
	}
}
$ecLang = ecGetLang('clanwars', 'details');
if($totalScoreSquad < $totalScoreEnemy)
{
	$totalScoreSquad = '<font color="#ff0000">'.$totalScoreSquad.'</font>';
	$totalScoreEnemy = '<font color="#006600">'.$totalScoreEnemy.'</font>';
	$scoreStatus = '<font color="#ff0000">'.$ecLang['totalScoreStatusLost'].'</font>';
}
elseif($totalScoreSquad == $totalScoreEnemy)
{
	$totalScoreSquad = '<font color="#ff6600">'.$totalScoreSquad.'</font>';
	$totalScoreEnemy = '<font color="#ff6600">'.$totalScoreEnemy.'</font>';
	$scoreStatus = '<font color="#ff6600">'.$ecLang['totalScoreStatusDraw'].'</font>';
}
else
{
	$totalScoreSquad = '<font color="#006600">'.$totalScoreSquad.'</font>';
	$totalScoreEnemy = '<font color="#ff0000">'.$totalScoreEnemy.'</font>';
	$scoreStatus = '<font color="#006600">'.$ecLang['totalScoreStatusWon'].'</font>';
}
// Files
$mediaImageTemplate = '';
$mediaArchivTemplate = '';
$files = explode(":", $clanwar['clanwarsFiles']);
$i = 0;
while ($i < count($files)-1)
{
	$medien = $files[$i];
	// Datatype
	$datatyp = pathinfo($medien);
	$datatyp = $datatyp["extension"];
	// Images
	if($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp  == 'bmp')
	{
		$mediaImageTemplate .= ecTemplate('clanwars', 'details', 'mediaImages');
	}
	else
	{
		$mediaArchivTemplate .= ecTemplate('clanwars', 'details', 'mediaArchives');
	}
	$i++;
}
$media = ($i != 0) ? ecTemplate('clanwars', 'details', 'media') : '';
echo ecTemplate('clanwars', 'details', 'clanwarsDetails');
?>