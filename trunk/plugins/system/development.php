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
*/ $ecFile = 'plugins/system/development.php';

echo ecTemplate('system', 'development', 'siteTitle');

$do = isset($_REQUEST['do']) ? $_REQUEST['do'] : '';
if ($do == 'addplugin')
{
	$data['pluginsPath'] = $_POST['pluginsPath'];
	$data['pluginsName'] = $_POST['pluginsName'];
	$data['pluginsAutor'] = $_POST['pluginsAutor'];
	$data['pluginsWWW'] = $_POST['pluginsWWW'];
	$data['pluginsInfo'] = $_POST['pluginsInfo'];
	$data['pluginsTime'] = $ecLocal['timestamp'];
	$data['pluginsReqPlugins'] = $_POST['pluginsReqPlugins'];
	$data['pluginsReqTables'] = $_POST['pluginsReqTables'];
	dbInsert(1,'plugins',$data);
	$path = 'plugins/'.$_POST['pluginsPath'];
	if (!file_exists($path)) mkdir($path);
	$next = ecReferer('index.php?view=system&amp;site=development');
	echo ecTemplate('system', 'development', 'pluginAdded');
}
elseif ($do == 'addsite')
{
	$data['sitesPluginId'] = $_POST['sitesPluginId'];
	$data['sitesName'] = $_POST['sitesName'];
	$data['sitesTyp'] = $_POST['sitesTyp'];
	dbInsert(1,'sites',$data);
	$extension = '.php';
	if ($_POST['sitesTyp'] == 5)
	{
		$pathSkript = 'plugins/'.$ecLocal['pluginsList'][$_POST['sitesPluginId']].'/'.$_POST['sitesName'].'.js';
		if (!file_exists($pathSkript))
		{	
			$datei = fopen($pathSkript,'w');
			fwrite($datei,$data);
			fclose($datei);
		}
	}
	elseif ($_POST['sitesTyp'] == 3 || $_POST['sitesTyp'] == 4)
	{
		
		$pathSkript = 'plugins/'.$ecLocal['pluginsList'][$_POST['sitesPluginId']].'/'.$_POST['sitesName'].'.php';
		$data = "<?php
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
	*/ \$ecFile = '".$pathSkript."';
	
?>";
		if (!file_exists($pathSkript))
		{	
			$datei = fopen($pathSkript,'w');
			fwrite($datei,$data);
			fclose($datei);
		}
	}
	else
	{
		$pathSkript = 'plugins/'.$ecLocal['pluginsList'][$_POST['sitesPluginId']].'/'.$_POST['sitesName'].'.php';
		$data = "<?php
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
	*/ \$ecFile = '".$pathSkript."';
	
?>";
		if (!file_exists($pathSkript))
		{
			$datei = fopen($pathSkript,'w');
			fwrite($datei,$data);
			fclose($datei);
		}
		$pathLanguage = 'languages/'.$ecLocal['language'].'/'.$ecLocal['pluginsList'][$_POST['sitesPluginId']].'/'.$_POST['sitesName'].'.php';
		if (!file_exists($pathLanguage))
		{	
			$data = "<?php
\$ecFile = '".$pathLanguage."';

?>";
			$datei = fopen($pathLanguage,'w');
			fwrite($datei,$data);
			fclose($datei);
		}
		$pathTemplate = 'templates/'.$ecLocal['template'].'/'.$ecLocal['pluginsList'][$_POST['sitesPluginId']].'/'.$_POST['sitesName'].'.html';
		if (!file_exists($pathTemplate))
		{	
			$datei = fopen($pathTemplate,'w');
			fclose($datei);
		}
	}

	$next = ecReferer('index.php?view=system&amp;site=development');
	echo ecTemplate('system', 'development', 'siteAdded');
}
else
{
	echo ecTemplate('system', 'development', 'pluginAdd');
	$pluginsList = '';
	$ecPluginsData = dbSelect('pluginsName,pluginsId',1,'plugins');
	while($plugins = mysql_fetch_object($ecPluginsData))
	{
		$listName = $plugins->pluginsName;
		$listValue = $plugins->pluginsId;
		$pluginsList .= ecTemplate('system', 'development', 'listData');
	}
	echo ecTemplate('system', 'development', 'siteAdd');
}
?>