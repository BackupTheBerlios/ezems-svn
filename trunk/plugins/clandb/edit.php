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
*/ $ecFile = 'plugins/clandb/edit.php';

echo ecTemplate('clandb', 'edit', 'siteHead');
$ecLang = ecGetLang('clandb', 'edit');
$id = $_REQUEST['id'];
if (isset($_POST['save']))
{
	if (!empty($_POST['clanName']))
	{
		$update['clanDbName'] = $_POST['clanName'];
		$update['clanDbShortName'] = $_POST['clanShortName'];
		$update['clanDbTag'] = $_POST['clanTag'];
		//$update['ClanDbCountry'] = $_POST['clanCountry'];
		$update['clanDbHomepage'] = $_POST['clanWWW'];
		
		dbUpdate(1, 'clandb', $update, "clanDbId = $id");
		
		if ($_FILES['clanImage']['error'] != 4)
		{
			$datatyp = pathinfo($_FILES['clanImage']['name']);
			$datatyp = strtolower($datatyp['extension']);
			
			if($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp == 'bmp')
			{
				ecUploadFile('clanImage', 'clandb', $id.'.'.$datatyp);
				$update['clanDbImage'] = $id.'.'.$datatyp;
				dbUpdate(1,'clandb',$update,'clanDbId = '.$id);
			}
		}
		$next = ecReferer('index.php?view=clandb&amp;site=manage');
		echo ecTemplate('clandb', 'edit', 'clanEdited');
	}
	else
	{
		$errorMsg = $ecLang['errorEmpty'];
		echo ecTemplate('clandb', 'edit', 'clanEdit');
	}
}
else
{
	$ecGroupsData = dbSelect('*',1,'clandb', "clanDbId = $id");
	while($clan = mysql_fetch_object($ecGroupsData))
	{
		$clanName = $clan->clanDbName;
		$clanShortName = $clan->clanDbShortName;
		$clanTag = $clan->clanDbTag;
		$clanWWW = $clan->clanDbHomepage;
		$errorMsg = '';
		echo ecTemplate('clandb', 'edit', 'clanEdit');
	}
}
?>