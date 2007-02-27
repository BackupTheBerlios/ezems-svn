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
*/ $ecFile = 'plugins/squads/squadadd.php';

echo ecTemplate('squads', 'squadadd', 'siteHead');
$ecLang = ecGetLang('squads', 'squadadd');
if (isset($_POST['save']))
{
	if (!empty($_POST['squadName']) && !empty($_POST['squadGame']))
	{
		$insert['squadsName'] = $_POST['squadName'];
		$insert['squadsTag'] = $_POST['squadTag'];
		$insert['squadsFight'] = $_POST['squadFight'];
		$insert['squadsGameId'] = $_POST['squadGame'];
			
		dbInsert(1, 'squads', $insert);
		$id = mysql_insert_id();
		
		$vorhanden = 0;
		$squadPlayerArray = $_POST['member'];
		$squadPlayerTaskArray = $_POST['task'];
		for ($i=0; $i < count($squadPlayerArray); $i++)
		{
			$ecSquadPlayerData = dbSelect('*',1,'squadplayer','squadplayerSquadId = '.$id);
			while ($member = mysql_fetch_object($ecSquadPlayerData))
			{
				$memberUserId = $member->squadplayerUserId;
				if ($memberUserId == $squadPlayerArray[$i])
				{
					$vorhanden += 1;
				}
			}
			if ($vorhanden == 0 && !empty($squadPlayerArray[$i]))
			{
				$insert2['squadplayerSquadId'] = $id;
				$insert2['squadplayerTaskId'] = $squadPlayerTaskArray[$i];
				$insert2['squadplayerUserId'] = $squadPlayerArray[$i];
				dbInsert(1, 'squadplayer', $insert2);
			}
			$vorhanden = 0;
		}
		
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
		echo ecTemplate('squads', 'squadadd', 'squadAdded');
	}
	else 
	{
		$gameOption = '';
		//Games auslesen
		$ecGamesData = dbSelect('*', 1, 'games');
		while ($games = mysql_fetch_object($ecGamesData))
		{
			$gameId = $games->gamesId;
			$gameName = $games->gamesName;
			$gameOption .= ecTemplate('squads', 'squadadd', 'gameOption');
		}
		
		$memberOptions = '';
		//Games auslesen
		$ecUserData = dbSelect('*', 1, 'users');
		while ($users = mysql_fetch_object($ecUserData))
		{
			$userId = $users->usersId;
			$userNick = $users->usersUsername;
			$memberOptions .= ecTemplate('squads', 'squadadd', 'memberOption');
		}
		
		$taskOptions = '';
		//Games auslesen
		$ecTaskData = dbSelect('*', 1, 'squadtask');
		while ($task = mysql_fetch_object($ecTaskData))
		{
			$taskId = $task->squadtaskId;
			$taskName = $task->squadtaskName;
			$taskOptions .= ecTemplate('squads', 'squadadd', 'taskOption');
		}
		$errorMsg = $ecLang['errorEmpty'];
		echo ecTemplate('squads', 'squadadd', 'squadAdd');
	}
}
else 
{
	$gameOption = '';
	//Games auslesen
	$ecGamesData = dbSelect('*', 1, 'games');
	while ($games = mysql_fetch_object($ecGamesData))
	{
		$gameId = $games->gamesId;
		$gameName = $games->gamesName;
		$gameOption .= ecTemplate('squads', 'squadadd', 'gameOption');
	}
	
	$memberOptions = '';
	//Games auslesen
	$ecUserData = dbSelect('*', 1, 'users');
	while ($users = mysql_fetch_object($ecUserData))
	{
		$userId = $users->usersId;
		$userNick = $users->usersUsername;
		$memberOptions .= ecTemplate('squads', 'squadadd', 'memberOption');
	}
	
	$taskOptions = '';
	//Games auslesen
	$ecTaskData = dbSelect('*', 1, 'squadtask');
	while ($task = mysql_fetch_object($ecTaskData))
	{
		$taskId = $task->squadtaskId;
		$taskName = $task->squadtaskName;
		$taskOptions .= ecTemplate('squads', 'squadadd', 'taskOption');
	}
	$errorMsg = '';
	echo ecTemplate('squads', 'squadadd', 'squadAdd');
}
?>