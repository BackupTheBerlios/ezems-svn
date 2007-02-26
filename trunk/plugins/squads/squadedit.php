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
*/ $ecFile = 'plugins/squads/squadedit.php';

echo ecTemplate('squads', 'squadedit', 'siteHead');
$ecLang = ecGetLang('squads', 'squadadd');
if (isset($_POST['save']))
{
	$id = $_POST['id'];
	if (!empty($_POST['squadName']) && !empty($_POST['squadGame']))
	{
		$update['squadsName'] = $_POST['squadName'];
		$update['squadsTag'] = $_POST['squadTag'];
		$update['squadsFight'] = $_POST['squadFight'];
		$update['squadsGameId'] = $_POST['squadGame'];
		dbUpdate(1,'squads',$update,'squadsId = '.$id);
		
		if ($_FILES['small_pic']['error'] != 4)
		{
			$datatyp = pathinfo($_FILES['small_pic']['name']);
			$datatyp = strtolower($datatyp['extension']);
			
			if ($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp == 'bmp')
			{
				ecUploadFile('small_pic', 'squads', $id.'_small.'.$datatyp);
				$update['squadsPic'] = $id.'_small.'.$datatyp;
				dbUpdate(1,'squads',$update,'squadsId = '.$id);
			}
		}
		// large_pic
		if ($_FILES['large_pic']['error'] != 4)
		{
			$datatyp = pathinfo($_FILES['large_pic']['name']);
			$datatyp = strtolower($datatyp['extension']);
			
			if ($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp == 'bmp')
			{
				ecUploadFile('large_pic', 'squads', $id.'_large.'.$datatyp);
				$update['squadsPicLarge'] = $id.'_large.'.$datatyp;
				dbUpdate(1,'squads',$update,'squadsId = '.$id);
			}
		}
		$next = ecReferer('index.php?view=squads&amp;site=manage');
		echo ecTemplate('squads', 'squadedit', 'squadEdited');
	}
	else 
	{
		$next = ecReferer('index.php?view=squads&amp;site=squadedit&id='.$id);
		echo ecTemplate('squads', 'squadedit', 'squadWarning');
	}
}
else 
{
	$id = $_REQUEST['id'];
	$ecSquadData = dbSelect('*',1,'squads,games', "(squadsId = $id) && (squadsGameId = gamesId)");
	while($squad = mysql_fetch_object($ecSquadData))
	{
		$squadName = $squad->squadsName;
		$squadTag = $squad->squadsTag;
		$yes = ($squad->squadsFight == 0) ? 'checked="checked"' : '';
		$no = ($squad->squadsFight == 1) ? 'checked="checked"' : '';
		$squadGameId = $squad->gamesId;
		$squadGameName = $squad->gamesName;
		$squadPicSmall = !empty($squad->squadsPic) ? $squad->squadsPic : 'default.png';
		$squadPicLarge = !empty($squad->squadsPicLarge) ? $squad->squadsPicLarge : 'default.png';
	}
	$gameOption = '';
	//Games auslesen
	$ecGamesData = dbSelect('*', 1, 'games');
	while ($games = mysql_fetch_object($ecGamesData))
	{
		$gameId = $games->gamesId;
		$gameName = $games->gamesName;
		$gameOption .= ecTemplate('squads', 'squadedit', 'gameOption');
	}
	echo ecTemplate('squads', 'squadedit', 'squadEdit');
}
?>