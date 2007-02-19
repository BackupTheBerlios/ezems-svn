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
*/ $ecFile = 'plugins/groups/access.php';

echo ecTemplate('groups', 'access', 'siteHead');
if (isset($_POST['save']))
{
	$id = $_POST['id'];
	foreach ($_POST as $key => $value)
	{
		if (is_numeric($key))
		{
			$update['accessLevel'] = $value;
			dbUpdate(1, 'access', $update, "(accessGroupId=$id) AND (accessSiteId=$key)");
		}
	}
	$next = ecReferer('index.php?view=groups&amp;site=manage');
	echo ecTemplate('groups', 'access', 'accessEdited');
}
else
{
	$id = $_REQUEST['id'];
	$tmpAccess = array();
	$ecAccessData = dbSelect('*',1,'access','accessGroupId='.$id);
	while($access = mysql_fetch_object($ecAccessData))
	{
		array_push($tmpAccess,$access->accessSiteId);
	}
	
	$ecSitesData = dbSelect('*',1,'sites');
	while($sites = mysql_fetch_object($ecSitesData))
	{
		$sitesId = $sites->sitesId;
		if (!in_array($sitesId, $tmpAccess))
		{
			$insert['accessGroupId'] = $id;
			$insert['accessSiteId'] = $sitesId;
			$insert['accessLevel'] = 0;
			dbInsert(1, 'access', $insert);
		}
	}
	echo ecTemplate('groups', 'access', 'accessHead');
	$actPlug = 0;
	$ecAccessData = dbSelect('pluginsId, pluginsPath, pluginsName, sitesName, accessSiteId, sitesPluginId, sitesId, accessLevel',
	1,
	'plugins,sites,access',
	"(sitesId = accessSiteId) AND (sitesPluginId = pluginsId) AND (accessGroupId = $id)",
	'pluginsId');
	while($access = mysql_fetch_object($ecAccessData))
	{
		$pluginId = $access->pluginsId;
		$pluginPath = $access->pluginsPath;
		if ($pluginId != $actPlug)
		{
			echo ecTemplate('groups', 'access', 'accessFoot');
			$plugin = $access->pluginsName;
			$actPlug = $pluginId;
			echo ecTemplate('groups', 'access', 'accessPlugin');
		}
		$site = $access->sitesName;
		$siteId = $access->sitesId;
		$access = $access->accessLevel;
		$access0 = ($access == 0) ? ' checked="checked"' : '';
		$access1 = ($access == 1) ? ' checked="checked"' : '';
		echo ecTemplate('groups', 'access', 'accessSite');
	}
	echo ecTemplate('groups', 'access', 'accessFoot');
	echo ecTemplate('groups', 'access', 'accessEdit');
}
?>