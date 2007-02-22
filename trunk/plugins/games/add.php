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
*/ $ecFile = 'plugins/games/add.php';

echo ecTemplate('games', 'add', 'siteHead');
if (isset($_POST['save']))
{
	if (!empty($_POST['gamesName']))
	{
		$insert['gamesName'] = $_POST['gamesName'];
		$insert['gamesVersion'] = $_POST['gamesVersion'];
		$insert['gamesPublisher'] = $_POST['gamesPublisher'];
		$insert['gamesWebsite'] = $_POST['gamesWWW'];
			
		dbInsert(1, 'games', $insert);
		$id = mysql_insert_id();
		
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
		echo ecTemplate('games', 'add', 'gamesAdded');
	}
	else
	{
		$errorMsg = $ecLang['errorEmpty'];
		echo ecTemplate('games', 'add', 'gamesAdd');
	}
}
else
{
	$errorMsg = '';
	$gamesWWW = 'http://';
	echo ecTemplate('games', 'add', 'gamesAdd');
}
?>