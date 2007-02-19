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
*/ $ecFile = 'plugins/users/add.php';

echo ecTemplate('users', 'add', 'siteHead');
$ecLang = ecGetLang('users', 'add');
if (isset($_POST['save']))
{
	if (!empty($_POST['usersUsername']) && !empty($_POST['usersPassword']) && !empty($_POST['usersPassword2']) && !empty($_POST['usersEmail']))
	{
		if ($_POST['usersPassword'] == $_POST['usersPassword2'])
		{
			$insert['usersUsername'] = $_POST['usersUsername'];
			$insert['usersPassword'] = ecCrypt($_POST['usersPassword']);
			$insert['usersEmail'] = $_POST['usersEmail'];
			$insert['usersFirstname'] = $_POST['usersFirstname'];
			$insert['usersLastname'] = $_POST['usersLastname'];
			$insert['usersGroupId'] = $_POST['usersGroupId'];
			$insert['usersThemeId'] = $ecSettings['system']['defaultThemeId'];
			$insert['usersTemplateId'] = $ecSettings['system']['defaultTemplateId'];
			$insert['usersIconId'] = $ecSettings['system']['defaultIconId'];
			$insert['usersLanguageId'] = $ecSettings['system']['defaultLanguageId'];
			$insert['usersGhostOnline'] = 0;
			$insert['usersTime'] = $ecLocal['timestamp'];
			
			dbInsert(1, 'users', $insert);
			
			$next = ecReferer('index.php?view=users&amp;site=manage');
			echo ecTemplate('users', 'add', 'usersAdded');
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
				$dataGroups .= ecTemplate('users', 'add', 'select');
			}
			echo ecTemplate('users', 'add', 'usersAdd');
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
		echo ecTemplate('users', 'add', 'usersAdd');
	}
}
else
{
	$dataGroups = '';
	$ecGroupsData = dbSelect('groupsName,groupsId',1,'groups');
	while($groups = mysql_fetch_object($ecGroupsData))
	{
		$value = $groups->groupsId;
		$description = $groups->groupsName;
		$checked = '';
		$dataGroups .= ecTemplate('users', 'edit', 'select');
	}
	$errorMsg = '';
	echo ecTemplate('users', 'add', 'usersAdd');
}
?>