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
*/ $ecFile = 'plugins/system/settings.php';

echo ecTemplate('system', 'settings', 'siteHead');

if (isset($_POST['save']))
{
	$data['defaultThemeId'] = $_POST['defaultThemeId'];
	$data['dataPerPage'] = $_POST['dataPerPage'];
	$data['siteOnline'] = isset($_POST['siteOnline']) ? 1 : 0;
	$data['defaultTemplateId'] = $_POST['defaultTemplateId'];
	$data['title'] = $_POST['title'];
	$data['defaultLanguageId'] = $_POST['defaultLanguageId'];
	$data['contentTyp'] = $_POST['contentTyp'];
	$data['contentWidth'] = $_POST['contentWidth'];
	$data['usualRefererTime'] = $_POST['usualRefererTime'];
	$data['defaultSite'] = $_POST['defaultSite'];
	$data['defaultPlugin'] = $_POST['defaultPlugin'];
	$data['mailDefaultAdress'] = $_POST['mailDefaultAdress'];
	$data['mailSubjectPrefix'] = $_POST['mailSubjectPrefix'];
	ecSettings('system', $data);
	$next = ecReferer('index.php?view=system&amp;site=admin');
	echo ecTemplate('system', 'settings', 'settingsSaved');
}
else
{
	if ($ecSettings['system']['contentTyp'] == 1)
	{
		$percent = ' selected="selected"';
		$pixel = '';
	}
	else
	{
		$pixel = ' selected="selected"';
		$percent = '';
	}
	if ($ecSettings['system']['siteOnline'] == 1)
	{
		$online = ' checked="checked"';
	}
	else
	{
		$online = '';
	}
	$dataPerPage = $ecSettings['system']['dataPerPage'];
	$contentWidth = $ecSettings['system']['contentWidth'];
	$title = $ecSettings['system']['title'];
	$usualRefererTime = $ecSettings['system']['usualRefererTime'];
	$defaultSite = $ecSettings['system']['defaultSite'];
	$mailDefaultAdress = $ecSettings['system']['mailDefaultAdress'];
	$mailSubjectPrefix = $ecSettings['system']['mailSubjectPrefix'];
	
	$dataThemes = '';
	$ecSettingsData = dbSelect('themesName,themesId',1,'themes');
	while($themes = mysql_fetch_object($ecSettingsData))
	{
		$value = $themes->themesId;
		$description = $themes->themesName;
		$checked = '';
		if ($ecSettings['system']['defaultThemeId'] == $themes->themesId) $checked = ' selected="selected"';
		$dataThemes .= ecTemplate('system', 'settings', 'select');
	}
	
	$dataLanguages = '';
	$ecSettingsData = dbSelect('languagesName,languagesId',1,'languages');
	while($languages = mysql_fetch_object($ecSettingsData))
	{
		$value = $languages->languagesId;
		$description = $languages->languagesName;
		$checked = '';
		if ($ecSettings['system']['defaultLanguageId'] == $languages->languagesId) $checked = ' selected="selected"';
		$dataLanguages .= ecTemplate('system', 'settings', 'select');
	}
	
	$dataTemplates = '';
	$ecSettingsData = dbSelect('templatesName,templatesId',1,'templates');
	while($templates = mysql_fetch_object($ecSettingsData))
	{
		$value = $templates->templatesId;
		$description = $templates->templatesName;
		$checked = '';
		if ($ecSettings['system']['defaultTemplateId'] == $templates->templatesId) $checked = ' selected="selected"';
		$dataTemplates .= ecTemplate('system', 'settings', 'select');
	}
	
	$dataStartPlugins = '';
	$ecSettingsData = dbSelect('pluginsPath',1,'plugins');
	while($plugins = mysql_fetch_object($ecSettingsData))
	{
		$value = $plugins->pluginsPath;
		$description = $plugins->pluginsPath;
		$checked = '';
		if ($ecSettings['system']['defaultPlugin'] == $plugins->pluginsPath) $checked = ' selected="selected"';
		$dataStartPlugins .= ecTemplate('system', 'settings', 'select');
	}
	
	echo ecTemplate('system', 'settings', 'settingsSkript');
}
?>