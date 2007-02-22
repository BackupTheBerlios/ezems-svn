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
*/ $ecFile = 'plugins/clandb/add.php';

echo ecTemplate('clandb', 'add', 'siteHead');
$ecLang = ecGetLang('users', 'add');
if (isset($_POST['save']))
{
	if (!empty($_POST['clanName']))
	{
		$insert['clanDbName'] = $_POST['clanName'];
		$insert['clanDbShortName'] = $_POST['clanShortName'];
		$insert['clanDbTag'] = $_POST['clanTag'];
		//$insert['ClanDbCountry'] = $_POST['clanCountry'];
		$insert['clanDbHomepage'] = $_POST['clanWWW'];
			
		dbInsert(1, 'clandb', $insert);
		$id = mysql_insert_id();
		
		if ($_FILES['clanImage']['error'] != 4)
		{
			$datatyp = pathinfo($_FILES['clanImage']['name']);
			$datatyp = strtolower($datatyp['extension']);
			
			if ($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp == 'bmp')
			{
				ecUploadFile('clanImage', 'clandb', $id.'.'.$datatyp);
				$update['clanDbImage'] = $id.'.'.$datatyp;
				dbUpdate(1,'clandb',$update,'clanDbId = '.$id);
			}
		}
		$next = ecReferer('index.php?view=clandb&amp;site=manage');
		echo ecTemplate('clandb', 'add', 'clanAdded');
	}
	else
	{
		$errorMsg = $ecLang['errorEmpty'];
		echo ecTemplate('clandb', 'add', 'clanAdd');
	}
}
else
{
	$errorMsg = '';
	$clanWWW = 'http://';
	echo ecTemplate('clandb', 'add', 'clanAdd');
}
?>