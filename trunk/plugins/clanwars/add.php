<?php
/*
 (C) 2006 Ezems.NET Alle Rechte vorbehalten.

 Dieses Programm ist urheberrechtlich geschützt.
 Die Verwendung für private Zwecke ist gesattet.
 Unbrechtigte Nutzung (Verkauf, Weiterverbreitung,
 Nutzung ohne Urherberrechtsvermerk, kommerzielle
 Nutzung) ist strafbar.
 Die Nutzung des Scriptes erfolgt auf eigene Gefahr.
 Schäden die durch die Nutzung entstanden sind,
 trägt allein der Nutzer des Programmes.
*/ $ecFile = 'plugins/clanwars/add.php';

echo ecTemplate('clanwars', 'add', 'siteTitle');
if(isset($_POST['save']))
{
	$insert['clanwarsGameId'] = $_POST['clanwarsGameId'];
	$insert['clanwarsTypId'] = $_POST['clanwarsTypId'];

	if($_POST['clanwarsClanId'] != 'OtherClan')
	{
		$insert['clanwarsEnemyId'] = $_POST['clanwarsClanId'];
	}
	else
	{
		// New Clan
		if(empty($_POST['clanwarsClanName']))
		{
			$error = 1;
		}
		else
		{
			$insertClan['clandbName'] = $_POST['clanwarsClanName'];
			$insertClan['clandbCountry'] = $_POST['clanwarsClanCountry'];
			dbInsert(1, 'clandb', $insertClan);
			$enemyClanId = mysql_insert_id();
			$insert['clanwarsEnemyId'] = $enemyClanId;
		}
	}
	
	
	// Enemy Player
	$enemyPlayerArray = $_POST['clanwarsEnemyNames'];
	$enemyNames = '';
	foreach($enemyPlayerArray as $player)
	{
		if (!empty($player))
		{
			$enemyNames .= $player."|µ|"; 
		}
	}
	$insert['clanwarsListEnemy'] = $enemyNames;
	
	$insert['clanwarsSquadId'] = $_POST['clanwarsSquadId'];
	
	// Squadplayer
	if(empty($_POST['clanwarsSquadPlayer']))
	{
		$error = 1;
	}
	else
	{
		$squadPlayerArray = $_POST['clanwarsSquadPlayer'];
		$squadPlayerIds = '';
		foreach($squadPlayerArray as $playerId)
		{
			if (!empty($playerId)) 
			{ 
				$squadPlayerIds .= $playerId.'|µ|'; 
			}	
		}
	}
	$insert['clanwarsSquadListId'] = $squadPlayerIds;
	
	// Unix Timestamp
	$insert['clanwarsTime'] = mktime($_POST['clanwarsHour'],$_POST['clanwarsMin'],0,$_POST['clanwarsMonth'],$_POST['clanwarsDay'],$_POST['clanwarsYear']);

	//Maps einlesen
	if(empty($_POST['clanwarsMap']))
	{
		$error = 1;
	}
	else 
	{
		$mapArray = $_POST['clanwarsMap'];
		$clanwarsMaps = '';
		foreach($mapArray as $map)
		{
			if (!empty($map)) 
			{ 
				$clanwarsMaps .= $map."|µ|"; 
			}	
		}
	}
	$insert['clanwarsMaps'] = $clanwarsMaps;

	// Score
	$scoreArray = $_POST['clanwarsScore'];
	$clanwarsScores = '';
	$i = 0;
	foreach($scoreArray as $score)
	{
		if (!empty($score) || $score == 0) 
		{
			// Every 4th Value changed
			$i++;
			if($i % 4 == 0 && $i != 0)
			{
				$clanwarsScores .= $score.'|µ|';
			}
			else 
			{
				$clanwarsScores .= $score.':';
			}
		}
		else 
		{
			$error = 1;
		}
	}
	$insert['clanwarsResults'] = $clanwarsScores;
	$insert['clanwarsInfo'] = $_POST['clanwarsInfo'];

	if(!isset($error))
		dbInsert(1, 'clanwars', $insert);
	else
		echo ecTemplate('clanwars', 'add', 'clanwarsError');
	
	// Allowed Uploads
	$pics = ($ecSettings['clanwars']['pics'] == 1) ? 'jpg' ||  'jpeg' || 'png' || 'gif' || 'bmp' : '';
	$archives = ($ecSettings['clanwars']['archives'] == 1) ? 'rar' || 'zip' || 'ace' || 'gz' || 'tar' : '';
	
	//Uploads erfassen und hochladen
	$lastInsertId = mysql_insert_id();
	$update['clanwarsFiles'] = '';
	foreach ($_FILES as $index => $value) 
	{
		if($value['error'] != 4)
		{
			//Datentyp herausbekommen:
			$datatyp = pathinfo($value["name"]);
			$datatyp = $datatyp["extension"];
			
			if($datatyp == $pics || $datatyp == $archives)
			{
				// Save Folder
				$folder = ($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp == 'bmp') ? 'images' : 'archives';
	
				$newDataName = $lastInsertId.'_'.$value["name"];
				ecUploadFile($index, 'clanwars/'.$folder, $newDataName);
				
				$update['clanwarsFiles'] .= $newDataName.":";
			}
		}
	}
	// Update Filenames in Database
	if(!isset($error))
	{
		dbUpdate(1, 'clanwars', $update, "clanwarsId = $lastInsertId");
		
		$next = ecReferer('index.php?view=clanwars&amp;site=manage');
		echo ecTemplate('clanwars', 'add', 'clanwarsSaved');
	}
}
else
{
	$ecLang = ecGetLang('clanwars','add');
	// Clanwartypes
	$clanwarsTypes = '';
	$cwTypes = array(	1 => 'Clanwar',
						2 => 'Funwar',
						3 => 'Friendlywar',
						4 => 'Trainwar',
						5 => 'Ligawar',
						6 => 'Other');
	foreach ($cwTypes as $value => $name)
	{
		$clanwarsTypes .= ecTemplate('clanwars', 'add', 'select');
	}
	// Games
	$clanwarsGames = '';
	$ecGameData = dbSelect('gamesId,gamesName',1,'games');
	while($games = mysql_fetch_object($ecGameData))
	{
		$name = $games->gamesName;
		$value = $games->gamesId;
		$clanwarsGames .= ecTemplate('clanwars', 'add', 'select');
	}
	$countries = '';
	foreach ($ecGobalLang['country'] as $short => $name)
	{
		$countries .= ecTemplate('clandb', 'add', 'select');
	}
	// EnemyClans
	$clanwarsEnemyClans = '';
	$ecEnemyClanData = dbSelect('clandbId,clandbName',1,'clandb');
	while($clans = mysql_fetch_object($ecEnemyClanData))
	{
		$name = $clans->clandbName;
		$value = $clans->clandbId;
		$clanwarsEnemyClans .= ecTemplate('clanwars', 'add', 'select');
	}
	
	// Squads
	$clanwarsSquads = '';
	$clanwarsSquadPlayer = '';
	$ecSquadsData = dbSelect('*', 1, 'squads');
	while ($squads = mysql_fetch_object($ecSquadsData))
	{
		$value = $squads->squadsId;
		$name = $squads->squadsName;
		$clanwarsSquads .= ecTemplate('clanwars', 'add', 'select');
		// Players
		$squadNames = '';
		$ecPlayerData = dbSelect('*', 1, 'squadplayer,users', "(squadplayerSquadId = $value) AND (squadplayerUserId = usersId)");
		while ($player = mysql_fetch_object($ecPlayerData))
		{
			$playerId = $player->squadplayerId;
			$playerName = $player->usersUsername;
			$squadNames .= ecTemplate('clanwars', 'add', 'squadPlayer');
		}
		$clanwarsSquadPlayer .= ecTemplate('clanwars', 'add', 'squadView');
	}
	
	// Years
	$clanwarsYears = '';
	foreach(ecMakeYear() as $value)
	{
		$name = $value;
		$clanwarsYears .= ecTemplate('clanwars', 'add', 'select');
	}
	
	// Upload Filetypes
	$uploadPictures = ($ecSettings['clanwars']['pics'] == 1) ? $ecLang['picturesTypes'] : '';
	$uploadArchives = ($ecSettings['clanwars']['archives'] == 1) ? $ecLang['archivesTypes'] : '';
	$uploadAllowed = ($ecSettings['clanwars']['pics'] == 1 || $ecSettings['clanwars']['archives'] == 1) ? ecTemplate('clanwars', 'add', 'uploadAllowed') : '';
	
	echo ecTemplate('clanwars', 'add', 'clanwarsAdd');
}
?>