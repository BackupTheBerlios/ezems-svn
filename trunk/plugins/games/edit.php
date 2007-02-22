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
*/ $ecFile = 'plugins/games/edit.php';

echo ecTemplate('games', 'edit', 'siteHead');
$id = $_REQUEST['id'];
if (isset($_POST['save']))
{
	if (!empty($_POST['gamesName']))
	{
		$update['gamesName'] = $_POST['gamesName'];
		$update['gamesVersion'] = $_POST['gamesVersion'];
		$update['gamesPublisher'] = $_POST['gamesPublisher'];
		$update['gamesWebsite'] = $_POST['gamesWWW'];
		
		dbUpdate(1, 'games', $update, "gamesId = $id");
		
		if ($_FILES['gamesIcon']['error'] != 4)
		{
			$datatyp = pathinfo($_FILES['gamesIcon']['name']);
			$datatyp = strtolower($datatyp['extension']);
			
			if ($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp == 'bmp')
			{
				ecUploadFile('gamesIcon', 'games', $id.'.'.$datatyp);
				$update['gamesIcon'] = $id.'.'.$datatyp;
				dbUpdate(1,'games',$update,'gamesId = '.$id);
			}
		}
		$next = ecReferer('index.php?view=games&amp;site=manage');
		echo ecTemplate('games', 'edit', 'gamesEdited');
	}
	else
	{
		$errorMsg = $ecLang['errorEmpty'];
		echo ecTemplate('clandb', 'edit', 'clanEdit');
	}
}
else
{
	$ecGamesData = dbSelect('*',1,'games', "gamesId = $id");
	while($clan = mysql_fetch_object($ecGamesData))
	{
		$gamesName = $clan->gamesName;
		$gamesVersion = $clan->gamesVersion;
		$gamesPublisher = $clan->gamesPublisher;
		$gamesWWW = $clan->gamesWebsite;;
		$errorMsg = '';
		echo ecTemplate('games', 'edit', 'gamesEdit');
	}
}
?>