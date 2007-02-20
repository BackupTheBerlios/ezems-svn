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
*/ $ecFile = 'plugins/users/changepassword.php';

echo ecTemplate('users', 'changepassword', 'siteHead');
$ecLang = ecGetLang('users', 'changepassword');
if (isset($_POST['save']))
{
	if (!empty($_POST['usersOldPassword']) && !empty($_POST['usersNewPassword']) && !empty($_POST['usersNewPassword2']))
	{
		if ($_POST['usersNewPassword'] == $_POST['usersNewPassword2'])
		{
			$ecUsersData = dbSelect('*', 1, 'users', "usersId=".$ecUser['userId']);
			while($users = mysql_fetch_object($ecUsersData))
			{
				if ($users->usersPassword == ecCrypt($_POST['usersOldPassword']))
				{
					$update['usersPassword'] = ecCrypt($_POST['usersNewPassword']);
					
					dbUpdate(1, 'users', $update, "usersId = ".$ecUser['userId']);
					
					$next = ecReferer('index.php?view=users&amp;site=usercenter');
					echo ecTemplate('users', 'changepassword', 'usersEdited');
				}
				else
				{
					$errorMsg = $ecLang['errorOldPassword'];
					echo ecTemplate('users', 'changepassword', 'usersEdit');
				}
			}
		}
		else
		{
			$errorMsg = $ecLang['errorPassword'];
			echo ecTemplate('users', 'changepassword', 'usersEdit');
		}
	}
	else
	{
		$errorMsg = $ecLang['errorEmpty'];
		echo ecTemplate('users', 'changepassword', 'usersEdit');
	}
}
else
{
	$errorMsg = '';
	echo ecTemplate('users', 'changepassword', 'usersEdit');
}
?>