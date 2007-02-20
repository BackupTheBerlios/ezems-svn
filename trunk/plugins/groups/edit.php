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
*/ $ecFile = 'plugins/groups/edit.php';

echo ecTemplate('groups', 'edit', 'siteHead');
$ecLang = ecGetLang('groups', 'edit');
$id = $_REQUEST['id'];
if (isset($_POST['save']))
{
	if (!empty($_POST['groupsName']))
	{
		$update['groupsName'] = $_POST['groupsName'];
		$update['groupsWWW'] = $_POST['groupsWWW'];
		$update['groupsInfo'] = $_POST['groupsInfo'];
		
		dbUpdate(1, 'groups', $update, "groupsId = $id");
		
		$next = ecReferer('index.php?view=groups&amp;site=manage');
		echo ecTemplate('groups', 'edit', 'groupsEdited');
	}
	else
	{
		$errorMsg = $ecLang['errorEmpty'];
		echo ecTemplate('groups', 'edit', 'groupsEdit');
	}
}
else
{
	$ecGroupsData = dbSelect('*',1,'groups', "groupsId = $id");
	while($groups = mysql_fetch_object($ecGroupsData))
	{
		$groupsName = $groups->groupsName;
		$groupsWWW = $groups->groupsWWW;
		$groupsInfo = $groups->groupsInfo;
		$errorMsg = '';
		echo ecTemplate('groups', 'edit', 'groupsEdit');
	}
}
?>