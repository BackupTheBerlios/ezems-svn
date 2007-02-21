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
*/ $ecFile = 'plugins/users/edit.php';

echo ecTemplate('users', 'edit', 'siteHead');
$ecLang = ecGetLang('users', 'edit');
$id = $_REQUEST['id'];
if (isset($_POST['save']))
{
	if (!empty($_POST['usersUsername']) && !empty($_POST['usersEmail']))
	{
		if ($_POST['usersPassword'] == $_POST['usersPassword2'])
		{
			$update['usersUsername'] = $_POST['usersUsername'];
			if (!empty($_POST['usersPassword'])) $update['usersPassword'] = ecCrypt($_POST['usersPassword']);
			$update['usersEmail'] = $_POST['usersEmail'];
			$update['usersFirstname'] = $_POST['usersFirstname'];
			$update['usersLastname'] = $_POST['usersLastname'];
			$update['usersGroupId'] = $_POST['usersGroupId'];
			
			dbUpdate(1, 'users', $update, "usersId = $id");
			
			$next = ecReferer('index.php?view=users&amp;site=manage');
			echo ecTemplate('users', 'edit', 'usersEdited');
		}
		else
		{
			$errorMsg = $ecLang['errorPassword'];
			$dataGroups = '';
			$ecGroupsData = dbSelect('groupsName,groupsId',1,'groups');
			while($groups = mysql_fetch_object($ecGroupsData))
			{
				$value = $groups->groupsId;
				$description = $groups->groupsName;
				$checked = '';
				if ($_POST['usersGroupId'] == $groups->groupsId) $checked = ' selected="selected"';
				$dataGroups .= ecTemplate('users', 'edit', 'select');
			}
			echo ecTemplate('users', 'edit', 'usersEdit');
		}
	}
	else
	{
		$errorMsg = $ecLang['errorEmpty'];
		$dataGroups = '';
		$ecGroupsData = dbSelect('groupsName,groupsId',1,'groups');
		while($groups = mysql_fetch_object($ecGroupsData))
		{
			$value = $groups->groupsId;
			$description = $groups->groupsName;
			$checked = '';
			if ($_POST['usersGroupId'] == $groups->groupsId) $checked = ' selected="selected"';
			$dataGroups .= ecTemplate('users', 'edit', 'select');
		}
		echo ecTemplate('users', 'edit', 'usersEdit');
	}
}
else
{
	$ecUsersData = dbSelect('*',1,'users', "usersId = $id");
	while($users = mysql_fetch_object($ecUsersData))
	{
		$usersUsername = $users->usersUsername;
		$usersEmail = $users->usersEmail;
		$usersFirstname = $users->usersFirstname;
		$usersLastname = $users->usersLastname;
		$dataGroups = '';
		$ecGroupsData = dbSelect('groupsName,groupsId',1,'groups');
		while($groups = mysql_fetch_object($ecGroupsData))
		{
			$value = $groups->groupsId;
			$description = $groups->groupsName;
			$checked = '';
			if ($users->usersGroupId == $groups->groupsId) $checked = ' selected="selected"';
			$dataGroups .= ecTemplate('users', 'edit', 'select');
		}
		$errorMsg = '';
		echo ecTemplate('users', 'edit', 'usersEdit');
	}
}
?>