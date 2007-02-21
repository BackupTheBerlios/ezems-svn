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
	
	echo ecTemplate('clanDb', 'edit', 'siteHead');
	$ecLang = ecGetLang('clandb', 'edit');
	if (isset($_POST['save']))
	{
		//Überprüfe ob ein Name eingebene wurde
		if (!empty($_POST['clanDbName']))
		{
			//Daten auslesen
			$clanId = $_POST['clanDbId'];
			$update['clanDbName'] = $_POST['clanDbName'];
			$update['clanDbShortName'] =  $_POST['clanDbShortName'];
			$update['clanDbTag'] = $_POST['clanDbTag'];
			$update['clanDbHomepage'] = $_POST['clanDbHomepage'];
			
			//Datenbank updaten
			dbUpdate(1, 'clandb', $update, $clanDbId = $clanId);
			
			//Überprüfen ob was hochgeladen wurde
			if($_FILES['clanPic']['error'] != 4)
			{
				$datatyp = pathinfo($_FILES['clanPic']['name']);
				$datatyp = strtolower($datatyp['extension']);
				
				//Überprüfen ob es sich um Bilder handelt
				if($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp == 'bmp')
				{
					//Hochladen
					ecUploadFile('clanPic', 'clandb', $clanId.'.'.$datatyp);
					//Bild in die Datenbank einfügen
					$update['clanDbImage'] = $clanId.'.'.$datatyp;
					dbUpdate(1,'clandb',$update,'clanDbId = '.$clanId);
				}
			}
			$next = ecReferer('index.php?view=clandb&amp;site=manage');
			echo ecTemplate('clandb', 'edit', 'clanEdited');
		}
		else
		{
			//Wenn kein Name eingegeben wurde dann Error
			$errorMsg = $ecLang['errorEmpty'];
			echo ecTemplate('clandb', 'edit', 'siteEntry');
		}
	}
	else
	{
		$id = $_REQUEST['clanId'];
		$errorMsg = '';
		
		//Daten der entsprechenden ID auslesen und ausgeben
		$ecClanDbData = dbSelect('*', 1, 'clandb', 'clanDbId = '.$id);
		while ($clanInfo = mysql_fetch_object($ecClanDbData))
		{
			$clanDbId = $clanInfo->clanDbId;
			$clanDbName = $clanInfo->clanDbName;
			$clanDbShortName = $clanInfo->clanDbShortName;
			$clanDbTag = $clanInfo->clanDbTag;
			//$clanCountry = $clanInfo->clanDbCountry;
			$clanDbHomepage = $clanInfo->clanDbHomepage;
			echo ecTemplate('clanDb', 'edit', 'siteEntry');
		}
	}
?>