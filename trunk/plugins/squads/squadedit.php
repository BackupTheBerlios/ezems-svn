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
		
		$squadPlayerArray = $_POST['members'];
		$squadPlayerTaskArray = $_POST['tasks'];
		for($i=0; $i < count($squadPlayerArray); $i++)
		{
			if (!empty($squadPlayerArray[$i])) 
			{
				$update2['squadplayerTaskId'] = $squadPlayerTaskArray[$i];
				dbUpdate(1, 'squadplayer', $update2, "(squadplayerId = ".$squadPlayerArray[$i].")");
			}
		}
		
		$squadPlayersArray = $_POST['member'];
		$squadPlayersTaskArray = $_POST['task'];
		for($i=0; $i < count($squadPlayersArray); $i++)
		{
			if (!empty($squadPlayersArray[$i])) 
			{
				$insert2['squadplayerSquadId'] = $id;
				$insert2['squadplayerTaskId'] = $squadPlayersTaskArray[$i];
				$insert2['squadplayerUserId'] = $squadPlayersArray[$i];
				dbInsert(1, 'squadplayer', $insert2);
			}
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
		//$next = ecReferer('index.php?view=squads&amp;site=manage');
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
		
	$memberOptions = '';
	//Games auslesen
	$ecUserData = dbSelect('*', 1, 'users');
	while ($users = mysql_fetch_object($ecUserData))
	{
		$userId = $users->usersId;
		$userNick = $users->usersUsername;
		$memberOptions .= ecTemplate('squads', 'squadedit', 'memberOption');
	}
	
	$taskOptions = '';
	//Games auslesen
	$ecTaskData = dbSelect('*', 1, 'squadtask');
	while ($task = mysql_fetch_object($ecTaskData))
	{
		$taskId = $task->squadtaskId;
		$taskName = $task->squadtaskName;
		$taskOptions .= ecTemplate('squads', 'squadedit', 'taskOption');
	}
	$squadPlayer = '';
	$ecSquadMemberData = dbSelect('*', 1, 'squadplayer,users,squadtask',"(squadplayerSquadId = $id) && (squadplayerUserID = usersId) && (squadplayerTaskId = squadtaskId)", 'squadplayerId', 1);
	while ($squadMember = mysql_fetch_object($ecSquadMemberData))
	{
		$squadPlayerId = $squadMember->squadplayerId;
		$squadPlayerName = $squadMember->usersUsername;
		$squadPlayerTaskId = $squadMember->squadplayerTaskId;
		$squadPlayerTaskName = $squadMember->squadtaskName;
		$squadPlayer .= ecTemplate('squads', 'squadedit', 'squadPlayer');
	}
	echo ecTemplate('squads', 'squadedit', 'squadEdit');
}
?>