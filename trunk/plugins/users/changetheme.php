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
*/ $ecFile = 'plugins/users/changetheme.php';

echo ecTemplate('users', 'changetheme', 'siteHead');
if (isset($_POST['save']))
{
	$update['usersThemeId'] = $_POST['usersThemeId'];

	dbUpdate(1, 'users', $update, "usersId = ".$ecUser['userId']);
	
	$next = ecReferer('index.php?view=users&amp;site=usercenter');
	echo ecTemplate('users', 'changetheme', 'usersEdited');
}
else
{
	echo ecTemplate('users', 'changetheme', 'usersEditHead');
	$ecThemesData = dbSelect('themesId,themesPath,themesName,themesInfo',1,'themes');
	while($themes = mysql_fetch_object($ecThemesData))
	{
		$themesId = $themes->themesId;
		$themesName = $themes->themesName;
		$themesPath = $themes->themesPath;
		$themesInfo = $themes->themesInfo;
		if ($themesId == $ecUser['themeId'])
		{
			$checked = 'checked="checked"';
		}
		else
		{
			$checked = '';
		}
		echo ecTemplate('users', 'changetheme', 'usersEditData');
	}
	echo ecTemplate('users', 'changetheme', 'usersEditFoot');
}
?>