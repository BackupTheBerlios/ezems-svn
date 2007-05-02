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
*/ $ecFile = 'plugins/users/details.php';

echo ecTemplate('users', 'details', 'siteHead');

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

$ecUsersData = dbSelect('*',1,'users',"(usersId = $id)");
$users = mysql_fetch_assoc($ecUsersData);

if (!empty($users->usersId))
{
	echo ecTemplate('users', 'details', 'detailsBarHead');
	echo ecTemplate('users', 'details', 'detailsBarUsers');
	if (ecGetAccessLevel('squads','users')) echo ecTemplate('users', 'details', 'detailsBarClans');
	if (ecGetAccessLevel('computer','users')) echo ecTemplate('users', 'details', 'detailsBarComputer');
	if (ecGetAccessLevel('board','users')) echo ecTemplate('users', 'details', 'detailsBarBoard');
	if (ecGetAccessLevel('gbook','users')) echo ecTemplate('users', 'details', 'detailsBarGBook');
	echo ecTemplate('users', 'details', 'detailsBarFoot');
	$ecLang = ecGetLang('users','details');
	$usersUsername = $users['usersUsername'];
	$usersFirstname = $users['usersFirstname'];
	$usersLastname = $users['usersLastname'];
	$usersSex = ($users['usersSex'] == 2) ? $ecLang['usersSexF'] : $ecLang['usersSexM'];
	$usersSexImg = ($users['usersSex'] == 2) ? 'female' : 'male';
	$usersBirthday = ecDate($users['usersBirthday'],2);
	$usersAge = ecAge($users['usersBirthday']);
	$usersSize = $users['usersSize'];
	$usersAdress = $users['usersAdress'];
	$usersCity = $users['usersCity'];
	$usersNation = $ecGobalLang['country'][$users['usersNation']];
	$usersNationImg = $users['usersNation'];
	$usersRegistredTime = ecDate($users['usersTime'],1);
	$usersRegistredDate = ecDate($users['usersTime'],2);
	$usersOnlineTime = ecDate($users['usersLastOnline'],1);
	$usersOnlineDate = ecDate($users['usersLastOnline'],2);
	
	$usersProfilImg = !empty($users['usersProfilImg']) ? $users['usersProfilImg'] : 'default.png';
	echo ecTemplate('users', 'details', 'personalData');
	
	$usersEmail = ecMail($users['usersEmail']);
	$usersWWW = $users['usersWWW'];
	$usersICQ = ecICQ($users['usersICQ']);
	$usersICQImg = ecGetICQ($users['usersICQ']);
	$usersMSN = ecMail($users['usersMSN']);
	$usersSkype = $users['usersSkype'];
	$usersXfire = $users['usersXfire'];
	$usersTel = $users['usersTel'];
	$usersMobile = $users['usersMobile'];
	echo ecTemplate('users', 'details', 'contactData');
}
else
{
	echo ecTemplate('users', 'details', 'userNotfound');
}

?>