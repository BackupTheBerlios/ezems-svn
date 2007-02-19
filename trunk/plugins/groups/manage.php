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
*/ $ecFile = 'plugins/groups/manage.php';

echo ecTemplate('groups', 'manage', 'siteHead');

echo ecTemplate('groups', 'manage', 'groupsHead');
$ecGroupsData = dbSelect('groupsId,groupsName',1,'groups');
while($groups = mysql_fetch_object($ecGroupsData))
{
	$groupsId = $groups->groupsId;
	$groupsName = $groups->groupsName;
	echo ecTemplate('groups', 'manage', 'groupsData');
}
echo ecTemplate('groups', 'manage', 'groupsFoot');

echo ecTemplate('groups', 'manage', 'groupsNew');
?>