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
*/ $ecFile = 'plugins/users/login.php';

echo ecTemplate('users', 'login', 'siteHead');

$ecLang = ecGetLang('users', 'login');
if ($loginStatus == 1)
{
	$loginPage = unserialize(str_replace('@','"',$_POST['loginPage']));
	$nextPage = 'index.php?';
	$count = count($loginPage);
	$i = 0;
	foreach ($loginPage as $index => $value)
	{
		$i++;
		$nextPage .= $index.'='.$value;
		if ($i != $count) $nextPage .= '&amp;';
	}
	$next = ecReferer($nextPage);
	echo ecTemplate('users', 'login', 'loginOk');
}
elseif ($loginStatus == 2)
{
	$loginError = $ecLang['error2'];
	echo ecTemplate('users', 'login', 'loginError');
}
else
{
	$loginError = $ecLang['error3'];
	echo ecTemplate('users', 'login', 'loginError');
}


?>