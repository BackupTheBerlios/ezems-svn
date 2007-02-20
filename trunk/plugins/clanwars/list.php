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

//Ergebnisse Zusammenzählen für Statistik:
$statistikErgebnisTeam1 = 0;
$statistikErgebnisTeam2 = 0;
$lost = 0;
$draw = 0;
$won = 0;
$countWars = 0;
$wars = '';

//Template leeren
$clanwarList = '';

$clanwarsSql = dbSelect('*', 1, 'clanwars');
while ($clanwarInfos = mysql_fetch_object($clanwarsSql))
{
	$result = '';
	//daten auslesen
	$matchId = $clanwarInfos->clanwarsId;
	$date = $clanwarInfos->clanwarsDate;
		$date = date("d.m.Y", $date);
	$squadId = $clanwarInfos->clanwarsSquadId;
	$enemyId = $clanwarInfos->clanwarsEnemyId;
	$results = $clanwarInfos->clanwarsResults;
	$gameId = $clanwarInfos->clanwarsGameId;
	
	//Squadnamen durch die Id nehmen
	$squadSql = dbSelect('squadsName', 1, 'squads', 'squadsId = '.$squadId);
	while ($squadInfos = mysql_fetch_object($squadSql))
	{
		$squadName = $squadInfos->squadsName;
	}
	
	//Gegnernamen durch die Id nehmen
	$enemySql = dbSelect('*', 1, 'clandb', 'clanDbId = '.$enemyId);
	while ($enemyInfos = mysql_fetch_object($enemySql))
	{
		$enemyName = $enemyInfos->clanDbName;
		$enemyShortName = $enemyInfos->clanDbShortName;
		$enemyTag = $enemyInfos->clanDbTag;
		//$enemyCountry = $enemyInfos->clanDbCountry;
		$enemyHomepage = $enemyInfos->clanDbHomepage;
	
		$popup = ecTemplate('clanwars', 'list', 'moreInfoClan');
	}
	
	//Spielnamen anhand der Id holen
	$gameSql = dbSelect('gamesName', 1, 'games', 'gamesId = '.$gameId);
	while($gameInfos = mysql_fetch_object($gameSql))
	{
		$gameName = $gameInfos->gamesName;
	}
	
	//Ergebnisse aufsplitten nach Runden
	$scorePerMapArray = explode('|µ|', $results);
	$i = 0;
	while($i < count($scorePerMapArray))
	{
		//Jetzt die ergebnisse der 2 Runden aufsplitten auf die Beiden Teams
		$scorePerRoundArray = explode(':', $scorePerMapArray[$i]);
		$j = 1;
		while($j < count($scorePerRoundArray))
		{
			//Runde 1 Team 1
			$ergebnisTeam1 = $scorePerRoundArray[$j];
			$j++;
			
			//Runde 1 Team 2
			$ergebnisTeam2 = $scorePerRoundArray[$j];
			$j++;
			
			//Runde 2 Team 1
			$ergebnisTeam1_2 = $ergebnisTeam1+$scorePerRoundArray[$j];
			$j++;
			
			//Runde 2 Team 1
			$ergebnisTeam2_2 = $ergebnisTeam2+$scorePerRoundArray[$j];
			$j++;
			
			//schauen ob es ein won, draw oder loos war
			if($ergebnisTeam1_2 < $ergebnisTeam2_2)
			{
				$lost++;
				$result = "<font color=\"red\">".$ergebnisTeam1_2."</font> : <font color=\"green\">".$ergebnisTeam2_2."</font>";
			}
			elseif($ergebnisTeam1_2 == $ergebnisTeam2_2)
			{
				$draw++;
				$result = "<font color=\"orange\">".$ergebnisTeam1_2." : ".$ergebnisTeam2_2."</font>";
			}
			else
			{
				$won++;
				$result = "<font color=\"green\">".$ergebnisTeam1_2."</font> : <font color=\"red\">".$ergebnisTeam2_2."</font>";
			}
			
			//Für Die Statistik
			$statistikErgebnisTeam1 = $statistikErgebnisTeam1+$ergebnisTeam1_2;
			$statistikErgebnisTeam2 = $statistikErgebnisTeam2+$ergebnisTeam2_2;
		}
		
		//$clanwarList = ecTemplate('clanwars', 'list', 'liste');
		$i++;
	}
	$wars .= ecTemplate('clanwars', 'list', 'wars');
	$countWars++;
}
$wonPercent = round($won / $countWars * 100, 2);
$drawPercent = round($draw / $countWars * 100, 2);
$lostPercent = round($lost / $countWars * 100, 2);

$statistik = ecTemplate('clanwars', 'list', 'statistik');
echo ecTemplate('clanwars', 'list', 'entry');


?>