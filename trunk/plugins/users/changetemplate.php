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
*/ $ecFile = 'plugins/users/changetemplate.php';

echo ecTemplate('users', 'changetemplate', 'siteHead');
if (isset($_POST['save']))
{
	$update['usersTemplateId'] = $_POST['usersTemplateId'];

	dbUpdate(1, 'users', $update, "usersId = ".$ecUser['userId']);
	
	$next = ecReferer('index.php?view=users&amp;site=usercenter');
	echo ecTemplate('users', 'changetemplate', 'usersEdited');
}
else
{
	echo ecTemplate('users', 'changetemplate', 'usersEditHead');
	$ecTemplatesData = dbSelect('templatesId,templatesPath,templatesName,templatesInfo',1,'templates');
	while($templates = mysql_fetch_object($ecTemplatesData))
	{
		$templatesId = $templates->templatesId;
		$templatesName = $templates->templatesName;
		$templatesPath = $templates->templatesPath;
		$templatesInfo = $templates->templatesInfo;
		if ($templatesId == $ecUser['templateId'])
		{
			$checked = 'checked="checked"';
		}
		else
		{
			$checked = '';
		}
		echo ecTemplate('users', 'changetemplate', 'usersEditData');
	}
	echo ecTemplate('users', 'changetemplate', 'usersEditFoot');
}
?>