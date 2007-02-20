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

$cwId = isset($_REQUEST['cwId']) ? $_REQUEST['cwId'] : '';

$gameName = '';
$gameTemplate = '';

$ecClanwarData = dbSelect('*', 1, 'clanwars', 'clanwarsId ='.$cwId);
while ($cwDetails = mysql_fetch_object($ecClanwarData))
{
	//Alle Informationen über diegewählte ID holen
	//Hier holt er erst die Id des Clanwars und ermittelt das Spiel
	$gameId = $cwDetails->clanwarsGameId;
	$gameInfos = dbSelect('*', 1, 'games', 'gamesId ='.$gameId);
	while ($gameInfo = mysql_fetch_object($gameInfos)) 
	{
		$gameName .= $gameInfo->gamesName;
		$gameTemplate .= (file_exists('templates/'.$ecLocal['template'].'/clanwars/'.$gameName.'/details.html')) ? $gameName."/" : '';
		$gameIcon = $gameInfo->gamesIcon;
	}
	
	//Durch die Squadid die Squadinforamtionen bekommen
	$squadId = $cwDetails->clanwarsSquadId;
	$squad = dbSelect('*', 1, 'squads', 'squadsId ='.$squadId);
	while ($squadInfo = mysql_fetch_object($squad)) 
	{
		$squadName = $squadInfo->squadsName;
		$squadTag = $squadInfo->squadsTag;
		$squadPic = !empty($squadInfo->squadsPic) ? '$squadInfo->squadsPic' : 'default.png';
	}
	
	//Durch die Gegnerid die Gegnerinformationen aus der ClanDb holen
	$enemyClanId = $cwDetails->clanwarsEnemyId;
	$enemy = dbSelect('*', 1, 'clandb', 'clanDbId ='.$enemyClanId);
	while ($enemyClanInfo = mysql_fetch_object($enemy))
	{
		$enemyName = $enemyClanInfo->clanDbName;
		$enemyPic = $enemyClanInfo->clanDbImage;
	}

	//Datumausgabe im Script
	$datum = $cwDetails->clanwarsDate;
	$date = date("d.m.Y - H:i",$datum);
	
	//Player aus dem Squad suchen und Ausgeben mit seiner Funktion
	$squadLineup = '';
	$squadPlayer = explode("|µ|", $cwDetails->clanwarsSquadListPlayerId);
	$i=1;
	while ($i < count($squadPlayer))
	{
		$gamer = $squadPlayer[$i];
		$squadPlayerInfo = dbSelect('*', 1, 'player,users', "(playerId = $gamer) && (playerUserId = usersId)");
		while ($squadPlayerInfos  = mysql_fetch_object($squadPlayerInfo)) 
		{
			$gamerName = $squadTag.$squadPlayerInfos->usersUsername;
			$squadLineup .= ecTemplate('clanwars', $gameTemplate.'details', 'squadLineup');	
		}	
		$i++;
	}
	
	//Player aus dem Gegnersquad suchen und ausgeben
	$enemyLineup = '';
	$enemySquadPlayer = explode("|µ|", $cwDetails->clanwarsListEnemy);
	$i=0;
	while ($i < count($enemySquadPlayer))
	{
		$enemyGamerName = $enemySquadPlayer[$i];
		$enemyLineup .= ecTemplate('clanwars', $gameTemplate.'details', 'enemyLineup');		
		$i++;
	}
	
	
	//MAP und Ergebnisse
	$maptemplate = '';
	$mapArray = explode(":", $cwDetails->clanwarsMapsId);
	$scoreArray = explode("|µ|", $cwDetails->clanwarsResults);
	
	$mapCount = 0;
	$scoreCount = 0;
	while($mapCount < count($mapArray) && $scoreCount < count($scoreArray))
	{
		$maparrays = $mapArray[$mapCount];
		$mapDbSelect = dbSelect('*', 1, 'maps', 'mapsId ='.$maparrays);
		while ($mapInfo = mysql_fetch_object($mapDbSelect)) 
		{
			$map = $mapInfo->mapsName;
		}
		
		$scoreRoundArray = explode(':', $scoreArray[$scoreCount]);
		$scorecount2 = 1;
		while ($scorecount2 < count($scoreRoundArray))
		{
			//Ergebnisse aus der aktuellen Map holen
			$score1 = $scoreRoundArray[$scorecount2];
			$scorecount2++;
			$score2 = $scoreRoundArray[$scorecount2];
			$scorecount2++;
			
			$score3 = $scoreRoundArray[$scorecount2];
			$scorecount2++;
			$score4 = $scoreRoundArray[$scorecount2];
			$scorecount2++;
		}
		
		$mapCount++;
		$scoreCount++;
		$maptemplate .= ecTemplate('clanwars', $gameTemplate.'details', 'mapRound');
	}
	
	//Files aus dem suchen und ausgeben
	$medienImageTemplate = '';
	$medienArchivTemplate = '';
	$files = explode(":", $cwDetails->clanwarsFiles);
	$i = 0;
	while ($i < count($files)-1)
	{
		//Datei einer Variable zuweisen
		$medien = $files[$i];
		
		//Datentyp herausbekommen:
		$datatyp = pathinfo($medien);
		$datatyp = $datatyp["extension"];
		
		//Überprüfen ob es sich um Bilder handelt
		if($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp  == 'bmp')
		{
			$medienImageTemplate .= ecTemplate('clanwars', $gameTemplate.'details', 'medienImage');
		}
		else
		{
			$medienArchivTemplate .= ecTemplate('clanwars', $gameTemplate.'details', 'medienArchiv');
		}
		$i++;
	}
	$media = ($i != 0) ? ecTemplate('clanwars', $gameTemplate.'details', 'medien') : '';
	echo ecTemplate('clanwars', $gameTemplate.'details', 'siteEntry');
}
?>