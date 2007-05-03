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
*/ $ecFile = 'plugins/clanwars/list.php';

echo ecTemplate('clanwars', 'list', 'siteTitle');

$scoreLoses = 0;
$scoreDraws = 0;
$scoreWins = 0;
echo ecTemplate('clanwars', 'list', 'clanwarsHead');
$ecClanwarsData = dbSelect('*', 1, 'clanwars,games,squads,clandb',"(clanwarsGameId = gamesId) AND (clanwarsSquadId = squadsId) AND (clanwarsEnemyId = clandbId)");
while($clanwar = mysql_fetch_object($ecClanwarsData))
{
	$clanwarsId = $clanwar->clanwarsId;
	$clanwarsDate = ecDate($clanwar->clanwarsTime,2);
	$clanwarsSquadId = $clanwar->clanwarsSquadId;
	$clanwarsSquadName = $clanwar->squadsName;
	$clanwarsGameId = $clanwar->gamesId;
	$clanwarsGameName = $clanwar->gamesName;
	$clanwarsGameImg = $clanwar->gamesIcon;
	$clanwarsEnemyId = $clanwar->clandbId;
	$clanwarsEnemyName = $clanwar->clandbName;
	$cwTypes = array(	1 => 'Clanwar',
						2 => 'Funwar',
						3 => 'Friendlywar',
						4 => 'Trainwar',
						5 => 'Ligawar',
						6 => 'Other');
	$clanwarsTyp = $cwTypes[$clanwar->clanwarsTypId];
	$clanwarsSquadNation = $ecSettings['squads']['clanNation'];
	$clanwarsEnemyNation = $clanwar->clandbCountry;

	//Ergebnisse aufsplitten nach Runden
	$totalScoreSquad = 0;
	$totalScoreEnemy = 0;
	$clanwarsResults = $clanwar->clanwarsResults;
	$scorePerMapArray = explode('|µ|', $clanwarsResults);
	foreach($scorePerMapArray as $roundScores)
	{
		if (!empty($roundScores))
		{
			$scorePerRoundArray = explode(':', $roundScores);
			$i = 0;
			while($i < count($scorePerRoundArray))
			{
				$scoreSquadRound1 = $scorePerRoundArray[$i];
				$i++;
				$scoreEnemyRound1 = $scorePerRoundArray[$i];
				$i++;
				$scoreSquadRound2 = $scorePerRoundArray[$i];
				$i++;
				$scoreEnemyRound2 = $scorePerRoundArray[$i];
				$i++;
				// Total Scores
				$totalScoreSquad += $scoreSquadRound1 + $scoreSquadRound2;
				$totalScoreEnemy += $scoreEnemyRound1 + $scoreEnemyRound2;
			}
		}
	}
	if($totalScoreSquad < $totalScoreEnemy)
	{
		$scoreLoses++;
		$clanwarsResult = '<font color="#ff0000">'.$totalScoreSquad.' : '.$totalScoreEnemy.'</font>';
	}
	elseif($totalScoreSquad == $totalScoreEnemy)
	{
		$scoreDraws++;
		$clanwarsResult = '<font color="#ff6600">'.$totalScoreSquad.' : '.$totalScoreEnemy.'</font>';
	}
	else
	{
		$scoreWins++;
		$clanwarsResult = '<font color="#006600">'.$totalScoreSquad.' : '.$totalScoreEnemy.'</font>';
	}
	echo ecTemplate('clanwars', 'list', 'clanwarsData');
}
echo ecTemplate('clanwars', 'list', 'clanwarsFoot');

$clanwarsCount = $scoreWins + $scoreDraws + $scoreLoses;
$percentageWins = round($scoreWins / $clanwarsCount * 100, 2);
$percentageDraws = round($scoreDraws / $clanwarsCount * 100, 2);
$percentageLoses = round($scoreLoses / $clanwarsCount * 100, 2);

echo ecTemplate('clanwars', 'list', 'clanwarsStats');
?>