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

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if($action == 'add')
{
	$error = 0;
	$enemyError = '';
	$enemyPlayerError = '';
	$playerError = '';
	$mapError = '';
	$scoreError = '';
	
	//Variablen einlesen
	$gameId = $_POST['game'];
	$day = (!empty($_POST['day'])) ? $_POST['day'] : date('j');
	$month = (!empty($_POST['month'])) ? $_POST['month'] : date('n');
	$year = (!empty($_POST['year'])) ? $_POST['year'] : date('Y');
	$hour = (!empty($_POST['hour']) || $_POST['hour'] == '0') ? $_POST['hour'] : date('G');
	$min =(!empty($_POST['min']) || $_POST['min'] == '0') ? $_POST['min'] : "0";
	//Zeit und Datum in UnixTimeStamp umwandeln
		$insert['clanwarsDate'] = mktime($hour,$min,0,$month,$day,$year);
		
	//Enemyclan auslesen
	if(!empty($_POST['clanDb']))
	{
		$insert['clanwarsEnemyId'] = $_POST['clanDb'];
	}
	else
	{
		//Falls ein neuer Clan hinzugefügt wurde, soll er ihn in die ClanDB schreiben
		if(empty($_POST['newClan']))
		{
			$enemyError = ecTemplate('clanwars', 'add', 'enemyError');
			$error += 1;
		}
		else
		{
			$insertClan['clanDbName'] = $_POST['newClan'];
			dbInsert(1, 'clandb', $insertClan);
			//und dessen ID in die Clanwars Datenbank
			$enemyClanId = mysql_insert_id();
			$insert['clanwarsEnemyId'] = $enemyClanId;
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
			$enemyPlayerError = ecTemplate('clanwars', 'add', 'enemyPlayerError');
		}
	}
	
	//Squadplayer auslesen
	//Auf vorhandensein prüfen
	if(empty($_POST['squadPlayer']))
	{
		$playerError = ecTemplate('clanwars', 'add', 'playerError');
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
		$mapError = ecTemplate('clanwars', 'add', 'mapError');
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
				$insertMap['mapsGameId'] = $gameId;
				$insertMap['mapsName'] = $mapArray[$i];
				dbInsert(1, 'maps', $insertMap);
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
			$scoreError = ecTemplate('clanwars', 'add', 'scoreError');
			$error += 1;
		}
	}
	
	//Wenn kein Error vorhanden ist, in die Datenbank schreiben
	if($error == 0)
	{
		//Daten in die Datenbank schreiben
		$insert['clanwarsGameId'] = $gameId;
		$insert['clanwarsSquadListPlayerId'] = $squadPlayerId;
		$insert['clanwarsSquadId'] = $_POST['squad'];
		$insert['clanwarsListEnemy'] = $enemyNames;
		$insert['clanwarsMapsId'] = $map;
		$insert['clanwarsResults'] = $scores;
		
		dbInsert(1, 'clanwars', $insert);
	}
	else
	{
		echo ecTemplate('clanwars', 'add', 'Error');
	}
	
	//Welche uploads sind erlaub
	$pics = ($ecSettings['clanwars']['pics'] == 1) ? 'jpg' ||  'jpeg' || 'png' || 'gif' || 'bmp' : '';
	$archive = ($ecSettings['clanwars']['archiver'] == 1) ? 'rar' || 'zip' || 'ace' || 'gz' || 'tar' : '';
	
	//Uploads erfassen und hochladen
	$mysqlInsertId = mysql_insert_id();
	$update = '';
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
				$folder = ($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp == 'bmp') ? '/images' : 'archives';
	
	
				$newDataName = $mysqlInsertId.'_'.$value["name"];
				ecUploadFile($index, 'clanwars/'.$folder, $newDataName);
				
				$update .= $newDataName.":";
			}
		}
	}
	//Datei-Namen in die Datenbank schreiben
	if($error == 0)
	{
		$updates['clanwarsFiles'] = $update;
		dbUpdate(1, 'clanwars', $updates, 'clanwarsId = '.$mysqlInsertId);
	}
	$next = ecReferer('index.php?view=clanwars&amp;site=manage');
	echo ecTemplate('clanwars', 'add', 'saved');
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
	$gameTemplate = '';
	$gamesName = '';
	//GameId senden zur Weiterverarbeitung
	
	if(!empty($_POST['gameId']))
	{
		$gameId = $_POST['gameId'];
		//GameName für das Template holen
		$gameTemplateSql = dbSelect('gamesName',1,'games', 'gamesId = '.$gameId);
		while($gameNameTemplate = mysql_fetch_object($gameTemplateSql))
		{
			$gamesName .= $gameNameTemplate->gamesName;
			if(file_exists('templates/'.$ecLocal['template'].'/clanwars/'.$gamesName.'/add.html'))
			{
				
				$gameTemplate = $gamesName."/";
			}
		}
		
		//ID auswerten
		$ecClanwarInfoData = dbSelect('*', 1, 'squads', 'squadsGameId = '.$gameId);
		while ($games = mysql_fetch_object($ecClanwarInfoData))
		{
			//Daten auslesen
			$squadId = $games->squadsId;
			$squadName = $games->squadsName;
			$squadNames = '';
	
			//Squads Template laden
			$squadOptions .= ecTemplate('clanwars',$gameTemplate.'add', 'squadOptions');
			
			//Player zum Squad auslesen
			$ecClanwarSquadInfo = dbSelect('*', 1, 'player,users', "(playerSquadId = $squadId) && (playerUserId = usersId)");
			while ($userinfos = mysql_fetch_object($ecClanwarSquadInfo))
			{
				$playerIds = $userinfos->playerId;
				$playerName = $userinfos->usersUsername;
				$squadNames .= ecTemplate('clanwars',$gameTemplate.'add', 'squadPlayer');
			}
			//Squad Player Template laden
			$squadPlayer .= ecTemplate('clanwars',$gameTemplate.'add', 'squadView');
		}
		
		//Gegner Clan einfügen aus der Clandatenbank
		$ecClanDb = dbSelect('clanDbId,clanDbName', 1, 'clandb');
		while ($clandb = mysql_fetch_object($ecClanDb))
		{
			$clanId = $clandb->clanDbId;
			$clanName = $clandb->clanDbName;
			
			//Clans Template laden
			$clanDbOptions .= ecTemplate('clanwars', $gameTemplate.'add', 'clanDbOptions');
		}
		
		//Tages Zahlen
		for($d=1; $d<32; $d++)
		{
			//Tage Template laden
			$dayOption .= ecTemplate('clanwars',$gameTemplate.'add', 'day');;
		}	
		//Monats Zahlen
		for($m=1; $m<=12; $m++)
		{
			//Monats Template laden
			$monthOption .= ecTemplate('clanwars',$gameTemplate.'add', 'month');
		}
		
		//Jahres Zahlen
		$dateYear = date('Y')+2;
		for($y = $dateYear; $y >= 1970; $y--)
		{
			//Jahres Template laden
			$yearOption .= ecTemplate('clanwars',$gameTemplate.'add', 'years');
		}
		
		//Stunden
		for($h = 0; $h < 24; $h++)
		{
			//Stunden Template laden
			$hourOption .= ecTemplate('clanwars',$gameTemplate.'add', 'hour');
		}
		//Minuten
		$mi = 0;
		while($mi <= 60)
		{
			//Minuten Template laden
			$minOption .= ecTemplate('clanwars',$gameTemplate.'add', 'min');
			$mi = $mi + 10;
		}
	
		//Maps laden
		$mapNamen = "";
		$ecMapData = dbSelect('*', 1, 'maps', "(mapsGameId = $gameId)");
		while ($map = mysql_fetch_object($ecMapData))
		{
			$mapName = $map->mapsName;
			$mapNamen .= '"'.$mapName.'",';
		}
		
		//Welche Dateitypen sind erlaubt für den Upload?
		$pics = ($ecSettings['clanwars']['pics'] == 1) ? ecTemplate('clanwars', 'add', 'pics') : '';
		$archiver = ($ecSettings['clanwars']['archiver'] == 1) ? ecTemplate('clanwars', 'add', 'archiver') : '';
		
		$uploadAllowed = ($ecSettings['clanwars']['pics'] == 1 || $ecSettings['clanwars']['archiver'] == 1) ? ecTemplate('clanwars',$gameTemplate.'add', 'uploadAllowed') : '';
		
		//Lade Template des Games
		echo ecTemplate('clanwars',$gameTemplate.'add', 'siteEntry',$gameTemplate.'add');
	}
	else 
	{
		$next = ecReferer('index.php?view=clanwars&amp;site=manage');
		echo ecTemplate('clanwars',$gameTemplate.'add', 'noGame',$gameTemplate.'add');
	}
}
?>