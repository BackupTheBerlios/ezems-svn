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
*/ $ecFile = 'system/core/access.php';

function ecCrypt($password)
{
	global $ecLocal;
	$key = $ecLocal['cryptKey'];
	$data = crypt($password,$key);
	$hash = md5(($key ^ str_repeat(chr(0x5c), 64)) . pack('H*', md5(($key ^ str_repeat(chr(0x36), 64)). $data)));
	return $hash;
}

function ecCryptCookie($password)
{
	$hostname = gethostbyaddr(getenv("REMOTE_ADDR"));
	$agent = getenv("HTTP_USER_AGENT");
	$hash = ecCrypt($hostname.$password.$agent);
	return $hash;
}

$loginStatus = 0;

if (isset($_POST['loginCookie'])) $loginCookieSet = $_POST['loginCookie'];

if (!empty($_COOKIE['ecLoginUsername']) && !empty($_COOKIE['ecLoginPassword']))
{
	$loginUsername = $_COOKIE['ecLoginUsername'];
	$loginCookieCrypt = $_COOKIE['ecLoginPassword'];
	$loginPasswordCrypt = 0;
}
else
{
	$loginUsername = 0;
	$loginPassword = 0;
	$loginCookieCrypt = 0;
	$loginPasswordCrypt = 0;
}

if (empty($loginPassword) && empty($loginCookieCrypt) && isset($_POST['loginUsername']) && isset($_POST['loginPassword']))
{
	$loginUsername = $_POST['loginUsername'];
	$loginPassword = $_POST['loginPassword'];
	$loginCookieSet = $_POST['loginCookieSet'];
	$loginPasswordCrypt = ecCrypt($loginPassword);
	$loginPassword = 0;
}

session_start();
if (!empty($loginUsername) && (!empty($loginPasswordCrypt) || !empty($loginCookieCrypt)) && !isset($_SESSION['userId']))
{
	$loginUsername = dbRealEscapeString($loginUsername);
	$ecUsersData = dbSelect('*', 1, 'users', "usersUsername='".$loginUsername."'");
	while($users = mysql_fetch_object($ecUsersData))
	{
		if ($users->usersPassword == $loginPasswordCrypt || ecCryptCookie($users->usersPassword) == $loginCookieCrypt)
		{
			$loginStatus = 1;
			$_SESSION['userId'] = $users->usersId;
			$_SESSION['userIP'] = $ecLocal['userIP'];
			if (!empty($loginCookieSet))
			{ 
				$cookieTime = time() + $loginCookieSet;
				setcookie("ecLoginUsername",$loginUsername,$cookieTime);
				setcookie("ecLoginPassword",ecCryptCookie($loginPasswordCrypt),$cookieTime);
			}
		}
		else
		{
			session_destroy();
			$loginStatus = 3;
			if (!empty($_COOKIE['ecLoginUsername']) || !empty($_COOKIE['ecLoginPassword']))
			{
				setcookie("ecLoginUsername",0,1);
				setcookie("ecLoginPassword",0,1);
			}
		}
	}
	if ($loginStatus != 1 && $loginStatus != 3)
	{
		$loginStatus = 2;
		session_destroy();
	}
}

if (isset($_SESSION['userId']))
{
	$ecUser['userId'] = $_SESSION['userId'];
	$ecUsersData = dbSelect('*', 1, 'users', "usersId=".$ecUser['userId']);
	while($users = mysql_fetch_object($ecUsersData))
	{
		$ecUser['username'] = $users->usersUsername;
		$ecUser['groupId'] = $users->usersGroupId;
		$ecUser['languageId'] = $users->usersLanguageId;
		$ecUser['iconId'] = $users->usersIconId;
		$ecUser['themeId'] = $users->usersThemeId;
		$ecUser['templateId'] = $users->usersTemplateId;
		
		$ecUser['email'] = $users->usersEmail;
		$ecUser['firstname'] = $users->usersFirstname;
		$ecUser['lastname'] = $users->usersLastname;
	}
	$updateData['usersLastOnline'] = $ecLocal['timestamp'];
	dbUpdate(1, 'users', $updateData, 'usersId='.$ecUser['userId']);
}
else
{
	$ecUser['userId'] = 0;
	$ecUser['username'] = '';
	$ecUser['groupId'] = $ecSettings['system']['defaultGroupId'];
	$ecUser['languageId'] = $ecSettings['system']['defaultLanguageId'];
	$ecUser['iconId'] = $ecSettings['system']['defaultIconId'];
	$ecUser['themeId'] = $ecSettings['system']['defaultThemeId'];
	$ecUser['templateId'] = $ecSettings['system']['defaultTemplateId'];
}
if (isset($ecLocal['userIP']) && isset($_SESSION['userIP']))
{
	if ($ecLocal['userIP'] != $_SESSION['userIP']) session_destroy();
}
if (isset($_REQUEST['view']) && isset($_REQUEST['site']) && $_REQUEST['view'] == 'users' && $_REQUEST['site'] == 'logout')
{
	$updateData['lastonline'] = $ecLocal['timestamp'] - 180;
	dbUpdate(1, 'login', $updateData, 'usersId='.$ecUser['userId']);
	setcookie('ecLoginUsername',0,1);
	setcookie('ecLoginPassword',0,1);
	session_destroy();
}

function ecGetAccessLevel($plugin,$site,$groupId = -1)
{
	global $ecUser;
	$groupId = ($groupId == -1) ? $ecUser['groupId'] : $groupId;
	$ecAccessData = dbSelect('*',1,'groups,access,sites,plugins',"(groupsId = accessGroupId) AND (sitesId = accessSiteId) AND (sitesPluginId = pluginsId) AND (pluginsPath='".$plugin."') AND (sitesName = '".$site."') AND (groupsId = ".$groupId.")");
	while($access = mysql_fetch_object($ecAccessData))
	{
		if ($access->accessLevel == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>