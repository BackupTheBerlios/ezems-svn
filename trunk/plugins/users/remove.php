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
*/ $ecFile = 'plugins/users/remove.php';

echo ecTemplate('users', 'remove', 'siteHead');
$id = $_REQUEST['id'];
if (isset($_POST['save']))
{
	dbDelete(1, 'users', "usersId = $id");	
	$next = ecReferer('index.php?view=users&amp;site=manage');
	echo ecTemplate('users', 'remove', 'usersRemoved');
}
else
{
	echo ecTemplate('users', 'remove', 'usersRemove');
}
?>