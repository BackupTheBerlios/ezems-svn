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
*/ $ecFile = 'plugins/clanwars/edit.php';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if($action == 'edit')
{
	$cwId = $_REQUEST['id'];
	$error = 0;
	$enemyError = '';
	$enemyPlayerError = '';
	$playerError = '';
	$mapError = '';
	$scoreError = '';
	
	//Variablen einlesen
	$day = (!empty($_POST['day'])) ? $_POST['day'] : date('j');
	$month = (!empty($_POST['month'])) ? $_POST['month'] : date('n');
	$year = (!empty($_POST['year'])) ? $_POST['year'] : date('Y');
	$hour = (!empty($_POST['hour']) || $_POST['hour'] == '0') ? $_POST['hour'] : date('G');
	$min =(!empty($_POST['min']) || $_POST['min'] == '0') ? $_POST['min'] : "0";
	//Zeit und Datum in UnixTimeStamp umwandeln
		$update['clanwarsDate'] = mktime($hour,$min,0,$month,$day,$year);
		
	//Enemyclan auslesen
	if(!empty($_POST['clanDb']))
	{
		$update['clanwarsEnemyId'] = $_POST['clanDb'];
	}
	else
	{
		//Falls ein neuer Clan hinzugefügt wurde, soll er ihn in die ClanDB schreiben
		if(empty($_POST['newClan']))
		{
			$enemyError = ecTemplate('clanwars', 'edit', 'enemyError');
			$error += 1;
		}
		else
		{
			$updateClan['clanDbName'] = $_POST['newClan'];
			dbInsert(1, 'clandb', $updateClan);
			//und dessen ID in die Clanwars Datenbank
			$enemyClanId = mysql_insert_id();
			$update['clanwarsEnemyId'] = $enemyClanId;
		}
	}
	
	//enemy Player auslesen
	$enemyPlayerArray = $_POST['enemyNames'];
	$enemyNames = "";
	for($i=0; $i < count($enemyPlayerArray); $i++)
	{
		if(!empty($enemyPlayerArray[0]))
		{
			if (!empty($enemyPlayerArray[$i]))
			{
				$enemyNames .= $enemyPlayerArray[$i]."|µ|"; 
			}	
		}
		else
		{
			$enemyPlayerError = ecTemplate('clanwars', 'edit', 'enemyPlayerError');
		}
	}
	
	//Squadplayer auslesen
	//Auf vorhandensein prüfen
	if(empty($_POST['squadPlayer']))
	{
		$playerError = ecTemplate('clanwars', 'edit', 'playerError');
		$error += 1;
	}
	else
	{
		$squadPlayerArray = $_POST['squadPlayer'];
		$squadPlayerId = "";
		for($i=0; $i < count($squadPlayerArray); $i++)
		{
			if (!empty($squadPlayerArray[$i])) 
			{ 
				$squadPlayerId .= "|µ|".$squadPlayerArray[$i]; 
			}	
		}
	}
	
	//Maps einlesen
	$mapArray = $_POST['map'];
	//Auf vorhandensein prüfen
	if($mapArray[0] == '')
	{
		$mapError = ecTemplate('clanwars', 'edit', 'mapError');
		$error += 1;
	}
	else 
	{
		$vorhanden = 0;
		$map = "";
		//Schauen wie viele Maps es sind
		for($i=0; $i < count($mapArray); $i++)
		{
			//In der Datenbank nachschauen ob die Map schon existiert
			$ecMapInfoData = dbSelect('*', 1, 'maps');
			while ($maps = mysql_fetch_object ($ecMapInfoData)) 
			{
				$mapsId = $maps->mapsId;
				$mapsNamen = $maps->mapsName;
				
				if($mapsNamen == $mapArray[$i])
				{
					//Wenn die Map bereits da ist, vorhanden auf 1 setzen
					$vorhanden += 1;
					$map .= $mapsId.":";
				}
			}
			//Wenn die Map neu ist, in die Datenbank schreiben
			if($vorhanden == 0)
			{
				//Falls eine neue Map hinzugefügt wurde, soll er es in die Maps-Db schreiben
				$updateMap['mapsGameId'] = $gameId;
				$updateMap['mapsName'] = $mapArray[$i];
				dbInsert(1, 'maps', $updateMap);
				//und dessen ID in das Map-Array
				$newMapsId = mysql_insert_id();
				$map .= $newMapsId.":";
			}
			//vorhanden wieder reseten
			$vorhanden = 0;
		}
	}

	//Ergebnisse auslesen
	$scoreArray = $_POST['score'];
	$scores = "";
	for($i=0; $i < count($scoreArray); $i++)
	{
		if (!empty($scoreArray[$i]) || $scoreArray[$i] == 0) 
		{
			//Jedem 4ten Wert ändern, damit man ihn besser den Maps zuordnen kann
			if($i % 4 == 0 && $i != 0)
			{
				$scores .= (!empty($scoreArray[$i])) ? "|µ|".$scoreArray[$i] : "|µ|"."0"; 
			}
			else 
			{
				$scores .= (!empty($scoreArray[$i])) ? ":".$scoreArray[$i] : ":"."0";
			}
		}
		else 
		{
			$scoreError = ecTemplate('clanwars', 'edit', 'scoreError');
			$error += 1;
		}
	}
	
	//Wenn kein Error vorhanden ist, in die Datenbank schreiben
	if($error == 0)
	{
		//Daten in die Datenbank schreiben
		$update['clanwarsSquadListPlayerId'] = $squadPlayerId;
		$update['clanwarsSquadId'] = $_POST['squad'];
		$update['clanwarsListEnemy'] = $enemyNames;
		$update['clanwarsMapsId'] = $map;
		$update['clanwarsResults'] = $scores;
		
		dbUpdate(1, 'clanwars', $update, 'clanwarsId = '.$cwId);
	}
	else
	{
		echo ecTemplate('clanwars', 'edit', 'Error');
	}
	
	//Welche uploads sind erlaub
	$pics = ($ecSettings['clanwars']['pics'] == 1) ? 'jpg' ||  'jpeg' || 'png' || 'gif' || 'bmp' : '';
	$archive = ($ecSettings['clanwars']['archiver'] == 1) ? 'rar' || 'zip' || 'ace' || 'gz' || 'tar' : '';
	
	//Schauen ob Daten gelöscht worden sind:
	$serverFiles = (!empty($_POST["serverFile"])) ? $_POST["serverFile"] : '';
	$uploadUpdate = '';
	$filesServer = dbSelect('*',1,'clanwars','clanwarsId = '.$cwId);
	while ($filesOnServer = mysql_fetch_object($filesServer)) 
	{
		//vergleichen und das Array neu Erstellen!
		if(!empty($serverFiles))
		{
			$files = explode(":", $filesOnServer->clanwarsFiles);
			
			foreach ($serverFiles as $deleteFiles)
			{
				$datatyp = pathinfo($deleteFiles);
				$datatyp = $datatyp["extension"];
				
				$folder = ($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp == 'bmp') ? 'images' : 'archives';
				unlink('uploads/clanwars/'.$folder.'/'.$deleteFiles);
				
				$uploadCounter = 0;
				$i = 0;
				while($i < count($files))
				{
					if($files[$i] == $deleteFiles)
					{
						unset($files[$i]);
					}
					$i++;
				}
			}
			
			foreach ($files as $newFiles => $value)
			{
				//Dateien die Bleiben in die Variable Schreiben
				if($value != '')
				{
					$uploadUpdate .= $value.":";
				}
			}
		}
		else
		{
			//Wenn nix gelöscht worden ist, alle Dateien übernehmen
			$uploadUpdate .= $filesOnServer->clanwarsFiles;
		}
	}
	
	//Uploads erfassen und hochladen
	foreach ($_FILES as $index => $value) 
	{
		if($value['error'] != 4)
		{
			//Datentyp herausbekommen:
			$datatyp = pathinfo($value["name"]);
			$datatyp = $datatyp["extension"];
			
			if($datatyp == $pics || $datatyp == $archive)
			{
				//Anhand des Datentyps entscheiden wo es abgespeichert werde soll:
				$folder = ($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp == 'bmp') ? 'images' : 'archives';
	
	
				$newDataName = $cwId.'_'.$value["name"];
				ecUploadFile($index, 'clanwars/'.$folder, $newDataName);
				
				$uploadUpdate .= $newDataName.":";
			}
		}
	}
	//Datei-Namen in die Datenbank schreiben
	if($error == 0)
	{
		$updates['clanwarsFiles'] = $uploadUpdate;
		dbUpdate(1, 'clanwars', $updates, 'clanwarsId = '.$cwId);
	}
	$next = ecReferer('index.php?view=clanwars&amp;site=manage');
	echo ecTemplate('clanwars', 'edit', 'saved');
}
else 
{
	//Array erstmal leer machen :)
	$clanDbOptions = '';
	$squadOptions = '';
	$squadPlayer = '';
	$dayOption = '';
	$monthOption ='';
	$yearOption = '';
	$minOption = '';
	$hourOption = '';
	$gameName = '';
	$gameTemplate = '';
	
	//GameId senden zur Weiterverarbeitung
	$clanwarsId = $_REQUEST['clanwarsId'];
	
	//ID auswerten
	$ecClanwarInfoData = dbSelect('*', 1, 'clanwars', "clanwarsId = ".$clanwarsId);
	while ($clanwars = mysql_fetch_object($ecClanwarInfoData))
	{
		//Daten auslesen
		//GegnerDaten
		$clanwarsEnemyId = $clanwars->clanwarsEnemyId;
		$clanwarListEnemy = $clanwars->clanwarsListEnemy;
		
		//SquadDaten
		$squadCurrentId = $clanwars->clanwarsSquadId;
		$squadPlayerIds = $clanwars->clanwarsSquadListPlayerId;
		//Datum mit Uhrzeit
		$day = date('j', $clanwars->clanwarsDate);
		$month = date('n', $clanwars->clanwarsDate);
		$year = date('Y', $clanwars->clanwarsDate);
		$hour = date('H', $clanwars->clanwarsDate);
		$min = date('i', $clanwars->clanwarsDate);
		//SpielId
		$gameId = $clanwars->clanwarsGameId;
		//Map
		$currentMap = $clanwars->clanwarsMapsId;
		$currentResult = $clanwars->clanwarsResults;
		//ClanwarFiles
		$cwFiles = $clanwars->clanwarsFiles ;
	}
	
	//Spielnamen bestimmen
	$ecGameInfoData = dbSelect('*', 1, 'games', 'gamesId = '.$gameId);
	while ($game = mysql_fetch_object($ecGameInfoData))
	{
		//Daten auslesen
		$gameName .= $game->gamesName;
		$gameTemplate .= (file_exists('templates/'.$ecLocal['template'].'/clanwars/'.$gameName.'/edit.html')) ? $gameName."/" : '';
	}
	
	//Gegner Clan einfügen aus der Clandatenbank
	$ecClanDb = dbSelect('clanDbId,clanDbName', 1, 'clandb', 'clanDbId = '.$clanwarsEnemyId);
	while ($clandb = mysql_fetch_object($ecClanDb))
	{
		$clanId = $clandb->clanDbId;
		$clanName = $clandb->clanDbName;
	}
	//Alle Gegnerischen Clans einfügen
	$ecClanDb2 = dbSelect('clanDbId,clanDbName', 1, 'clandb', 'clanDbId = '.$clanwarsEnemyId);
	while ($clandb2 = mysql_fetch_object($ecClanDb2))
	{
		$clanId2 = $clandb2->clanDbId;
		$clanName2 = $clandb2->clanDbName;
		
		//Clans Template laden
		$clanDbOptions .= ecTemplate('clanwars', $gameTemplate.'edit', 'clanDbOptions');
	}
	
	//Player aus dem Gegnersquad suchen und ausgeben
	$enemyNamesOption = '';
	$enemySquadPlayer = explode("|µ|", $clanwarListEnemy);
	$i=0;
	while ($i < count($enemySquadPlayer)-1)
	{
		$enemyNames = $enemySquadPlayer[$i];
		$enemyNamesOption  .= ecTemplate('clanwars', $gameTemplate.'edit', 'enemyNames');
		$enemyInputCount = count($enemySquadPlayer)-1;
		$i++;
	}
	
	
	//IDs des Clanwars auswerten
	//SquadGamerID aufsplitten und auswerten
	$squadGamer = explode("|µ|", $squadPlayerIds);
	//ID auswerten
	$ecClanwarInfoData = dbSelect('*', 1, 'games,squads', "(gamesId = $gameId) && (squadsGameId ='".$gameId."')");
	while ($games = mysql_fetch_object($ecClanwarInfoData))
	{
		//Daten auslesen
		$gamesId = $games->gamesId;
		$gamesName = $games->gamesName;
		$squadId = $games->squadsId;
		$squadName = $games->squadsName;
		$squadNames = '';
		
		//Squadname des Sqauds aus dem Fight
		if($squadId == $squadCurrentId)
		{
			$squadNameCurrentMatch = $squadName;
		}
	
		//Squads Template laden
		$squadOptions .= ecTemplate('clanwars', $gamesName.'/add', 'squadOptions');
		
		//Player zum Squad auslesen
		$ecClanwarSquadInfo = dbSelect('*', 1, 'squadplayer,users', "(squadplayerSquadId = $squadId) && (squadplayerUserId = usersId)");
		while ($userinfos = mysql_fetch_object($ecClanwarSquadInfo))
		{
			//Die Ids der Player überprüfen ob sie am MAtch dabei waren
			for($i = 0; $i < count($squadGamer); $i++)
			{
				$playerIds = $userinfos->squadsplayerId;
				$playerName = $userinfos->usersUsername;
				$checked = ($squadGamer[$i] == $playerIds) ? 'checked="checked"' : '';
			}
			$displayNone = ($squadId == $squadCurrentId) ? 'block' : 'none';
			$squadNames .= ecTemplate('clanwars', $gameTemplate.'edit', 'squadPlayer');
		}
		//Squad Player Template laden
		$squadPlayer .= ecTemplate('clanwars', $gameTemplate.'edit', 'squadView');
	}

	//Tages Zahlen
	for($d=1; $d<32; $d++)
	{
		//Tage Template laden
		$dayOption .= ecTemplate('clanwars', $gameTemplate.'edit', 'day');;
	}

	//Monats Zahlen
	for($m=1; $m<=12; $m++)
	{
		//Monats Template laden
		$monthOption .= ecTemplate('clanwars', $gameTemplate.'edit', 'month');
	}

	//Jahres Zahlen
	$dateYear = date('Y')+2;
	for($y = $dateYear; $y >= 1970; $y--)
	{
		//Jahres Template laden
		$yearOption .= ecTemplate('clanwars', $gameTemplate.'edit', 'years');
	}

	//Stunden
	for($h = 0; $h < 24; $h++)
	{
		//Stunden Template laden
		$hourOption .= ecTemplate('clanwars', $gameTemplate.'edit', 'hour');
	}

	//Minuten
	$mi = 0;
	while($mi <= 60)
	{
		//Minuten Template laden
		$minOption .= ecTemplate('clanwars', $gameTemplate.'edit', 'min');
		$mi = $mi + 10;
	}

	//MAP und Ergebnisse
	$mapscore = '';
	$mapArray = explode(":", $currentMap);
	$scoreArray = explode("|µ|", $currentResult);
	$countAllMaps = count($mapArray)-2;
	
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
		$mapscore .= ecTemplate('clanwars', $gameTemplate.'edit', 'mapScore');
	}
	
	//Maps laden
	$mapNamen = "";
	$ecMapData = dbSelect('*', 1, 'maps', "(mapsGameId = $gameId)");
	while ($map = mysql_fetch_object($ecMapData))
	{
		$mapName = $map->mapsName;
		$mapNamen .= '"'.$mapName.'",';
	}
	
	
	//Files aus dem suchen und ausgeben
	$uploadetFiles = '';
	$files = explode(":", $cwFiles);
	$i = 0;
	while ($i < count($files)-1)
	{
		//Datei einer Variable zuweisen
		$medien = $files[$i];
		
		//Überprüfen ob es sich um Bilder handelt
		$uploadetFiles .= ecTemplate('clanwars', $gameTemplate.'edit', 'uploadetFiles');
		$i++;
	}
	$media = ($i != 0) ? ecTemplate('clanwars', $gameTemplate.'edit', 'medien') : '';
	
	
	//Welche Dateitypen sind erlaubt für den Upload?
	$pics = ($ecSettings['clanwars']['pics'] == 1) ? ecTemplate('clanwars', 'edit', 'pics') : '';
	$archiver = ($ecSettings['clanwars']['archiver'] == 1) ? ecTemplate('clanwars', 'edit', 'archiver') : '';
	
	$uploadAllowed = ($ecSettings['clanwars']['pics'] == 1 || $ecSettings['clanwars']['archiver'] == 1) ? ecTemplate('clanwars', $gameTemplate.'edit', 'uploadAllowed') : '';
	
	//Lade Template des Games
	echo ecTemplate('clanwars', $gameTemplate.'edit', 'siteEntry', $gameTemplate.'edit');
}
?>