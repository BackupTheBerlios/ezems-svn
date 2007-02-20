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

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if($action == 'permission')
{
	//Erlaubnisfelddaten senden
	$data['commentPersmission'] = isset($_POST['commentPermission']) ? 1 : 0;
	//Daten in die Datenbank schreiben
	ecSettings('clanwars', $data);
	//Template laden
	$next = ecReferer('index.php?view=clanwars&amp;site=manage');
	echo ecTemplate('clanwars', 'manage', 'save');
}
if($action == 'uploadTypes')
{
	//UploadTypen senden
	$data['pics'] = isset($_POST['pics']) ? 1 : 0;
	$data['archiver'] = isset($_POST['archiver']) ? 1 : 0; 
	//Daten in die Datenbank schreiben
	ecSettings('clanwars', $data);
	//Template laden
	$next = ecReferer('index.php?view=clanwars&amp;site=manage');
	echo ecTemplate('clanwars', 'manage', 'save');
}
if($action == 'delete')
{
	$cwID = $_REQUEST['cwId'];
	dbDelete(1, 'clanwars', 'clanwarsId ='.$cwID);
	//Template laden
	$next = ecReferer('index.php?view=clanwars&amp;site=manage');
	echo ecTemplate('clanwars', 'manage', 'delete');
}
if($action == 'selectiondelete')
{
	$delete = $_POST['delete'];
	foreach($delete as $deleteId)
	{
		dbDelete(1,'clanwars','clanwarsId = '.$deleteId);
	}
	$next = ecReferer('index.php?view=clanwars&amp;site=manage');
	echo ecTemplate('clanwars', 'manage', 'delete');
}
if(empty($action))
{
	$options = '';
	//Templatekopf laden
	echo ecTemplate('clanwars', 'manage', 'siteHead');
	
	//Games auslesen
	$ecGamesData = dbSelect('*', 1, 'games');
	while($games = mysql_fetch_object($ecGamesData))
	{
		$GamesId = $games->gamesId;
		$game = $games->gamesName;
		$options .= ecTemplate('clanwars', 'manage', 'options');
	}
	//Template laden
	echo ecTemplate('clanwars', 'manage', 'clanwarAdd');
	
	//Inhalt & Template laden
	echo ecTemplate('clanwars', 'manage', 'siteEntry');
	$ecClanwarsData = dbSelect('*', 1, 'clanwars,games,clandb', '(clanwarsGameId = gamesId) && (clanwarsEnemyId = clanDbId)');
	while($clanwars = mysql_fetch_object($ecClanwarsData))
	{
		//Clanwardaten auslesen
		$id = $clanwars->clanwarsId;
		$enemyName = $clanwars->clanDbName;
		$gameId = $clanwars->clanwarsGameId;
		$game = $clanwars->gamesName;
		
		//Spieldatum
		$dateSql = $clanwars->clanwarsDate;
			$date = date("d.m.y", $dateSql);

		//Template laden
		echo ecTemplate('clanwars', 'manage', 'siteData');
	}
	echo ecTemplate('clanwars', 'manage', 'siteFoot');
	
	//Erlaubnisfelder
	//Erlaubnisfelddaten auslesen
	$commentPermission = ($ecSettings['clanwars']['commentPersmission'] == 1) ? 'checked="checked"' : '';
	
	//UploadTypen auslesen
	$pics = ($ecSettings['clanwars']['pics'] == 1) ? 'checked="checked"' : '';
	$archiver = ($ecSettings['clanwars']['archiver'] == 1) ? 'checked="checked"' : '';

	//Erlaubnisfeld Template laden
	echo ecTemplate('clanwars', 'manage', 'sitePermissionField');
	if(ecGetAccessLevel('clanwars','upload'))
	{
		echo ecTemplate('clanwars', 'manage', 'siteUploadPermission');
	}
}
?>