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
*/ $ecFile = 'plugins/groups/add.php';

echo ecTemplate('groups', 'add', 'siteHead');
$ecLang = ecGetLang('users', 'add');
if (isset($_POST['save']))
{
	if (!empty($_POST['groupsName']))
	{
		$insert['groupsName'] = $_POST['groupsName'];
		$insert['groupsWWW'] =  $_POST['groupsWWW'];
		$insert['groupsInfo'] = $_POST['groupsInfo'];
		$insert['groupsTime'] = $ecLocal['timestamp'];
			
		dbInsert(1, 'groups', $insert);
		
		$next = ecReferer('index.php?view=groups&amp;site=manage');
		echo ecTemplate('groups', 'add', 'groupsAdded');
	}
	else
	{
		$errorMsg = $ecLang['errorEmpty'];
		echo ecTemplate('groups', 'add', 'groupsAdd');
	}
}
else
{
	$errorMsg = '';
	$groupsWWW = 'http://';
	echo ecTemplate('groups', 'add', 'groupsAdd');
}
?>