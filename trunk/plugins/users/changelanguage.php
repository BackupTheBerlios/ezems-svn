<?php
/*
 (C) 2006 EZEMS.NET Alle Rechte vorbehalten.

 Dieses Programm ist urheberrechtlich gesch�tzt.
 Die Verwendung f�r private Zwecke ist gesattet.
 Unbrechtigte Nutzung (Verkauf, Weiterverbreitung,
 Nutzung ohne Urherberrechtsvermerk, kommerzielle
 Nutzung) ist strafbar. 
 Die Nutzung des Scriptes erfolgt auf eigene Gefahr.
 Sch�den die durch die Nutzung entstanden sind,
 tr�gt allein der Nutzer des Programmes.
*/ $ecFile = 'plugins/users/changelanguage.php';

echo ecTemplate('users', 'changelanguage', 'siteHead');
if (isset($_POST['save']))
{
	$update['usersLanguageId'] = $_POST['usersLanguageId'];

	dbUpdate(1, 'users', $update, "usersId = ".$ecUser['userId']);
	
	$next = ecReferer('index.php?view=users&amp;site=usercenter');
	echo ecTemplate('users', 'changelanguage', 'usersEdited');
}
else
{
	echo ecTemplate('users', 'changelanguage', 'usersEditHead');
	$ecLanguagesData = dbSelect('languagesId,languagesPath,languagesName,languagesInfo',1,'languages');
	while($languages = mysql_fetch_object($ecLanguagesData))
	{
		$languagesId = $languages->languagesId;
		$languagesName = $languages->languagesName;
		$languagesPath = $languages->languagesPath;
		$languagesInfo = $languages->languagesInfo;
		if ($languagesId == $ecUser['languageId'])
		{
			$checked = 'checked="checked"';
		}
		else
		{
			$checked = '';
		}
		echo ecTemplate('users', 'changelanguage', 'usersEditData');
	}
	echo ecTemplate('users', 'changelanguage', 'usersEditFoot');
}
?>