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
*/ $ecFile = 'plugins/clanwars/manage.php';

echo ecTemplate('clanwars', 'manage', 'siteHead');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if ($action == 'permission')
{
	//Erlaubnisfelddaten senden
	$data['commentPersmission'] = isset($_POST['commentPermission']) ? 1 : 0;
	//Daten in die Datenbank schreiben
	ecSettings('clanwars', $data);
	//Template laden
	$next = ecReferer('index.php?view=clanwars&amp;site=manage');
	echo ecTemplate('clanwars', 'manage', 'clanwarsSaved');
}
elseif ($action == 'uploadTypes')
{
	//UploadTypen senden
	$data['pics'] = isset($_POST['pics']) ? 1 : 0;
	$data['archives'] = isset($_POST['archives']) ? 1 : 0; 
	//Daten in die Datenbank schreiben
	ecSettings('clanwars', $data);
	//Template laden
	$next = ecReferer('index.php?view=clanwars&amp;site=manage');
	echo ecTemplate('clanwars', 'manage', 'clanwarsSaved');
}
else
{
	//Inhalt & Template laden
	echo ecTemplate('clanwars', 'manage', 'clanwarsHead');
	$ecClanwarsData = dbSelect('*', 1, 'clanwars,games,clandb', '(clanwarsGameId = gamesId) && (clanwarsEnemyId = clanDbId)');
	while ($clanwar = mysql_fetch_object($ecClanwarsData))
	{
		//Clanwardaten auslesen
		$clanwarsId = $clanwar->clanwarsId;
		$gameId = $clanwar->clanwarsGameId;
		$clanwarsGameName = $clanwar->gamesName;
		$clanwarsGameImg = $clanwar->gamesIcon;
		$clanwarsDate = ecDate($clanwar->clanwarsTime, 2);
		$clanwarsEnemyId = $clanwar->clandbId;
		$clanwarsEnemyName = $clanwar->clandbName;

		//Template laden
		echo ecTemplate('clanwars', 'manage', 'clanwarsData');
	}
	echo ecTemplate('clanwars', 'manage', 'clanwarsFoot');
	
	$options = '';
	//Games auslesen
	$ecGamesData = dbSelect('*', 1, 'games');
	while ($games = mysql_fetch_object($ecGamesData))
	{
		$value = $games->gamesId;
		$description = $games->gamesName;
		$options .= ecTemplate('clanwars', 'manage', 'select');
	}
	
	//Erlaubnisfelder
	//Erlaubnisfelddaten auslesen
	$commentPermission = ($ecSettings['clanwars']['commentPersmission'] == 1) ? 'checked="checked"' : '';
	
	//UploadTypen auslesen
	$pics = ($ecSettings['clanwars']['pics'] == 1) ? 'checked="checked"' : '';
	$archives = ($ecSettings['clanwars']['archives'] == 1) ? 'checked="checked"' : '';

	//Erlaubnisfeld Template laden
	echo ecTemplate('clanwars', 'manage', 'clanwarsAccess');
	
	if (ecGetAccessLevel('clanwars','upload'))
	{
		echo ecTemplate('clanwars', 'manage', 'clanwarsAccessUpload');
	}
	echo ecTemplate('clanwars', 'manage', 'siteFoot');
}
?>