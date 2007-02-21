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
	*/ $ecFile = 'plugins/clandb/add.php';
	
	echo ecTemplate('clanDb', 'add', 'siteHead');
	$ecLang = ecGetLang('clandb', 'add');
	if (isset($_POST['save']))
	{
		//�berpr�fe ob ein Name eingebene wurde
		if (!empty($_POST['clanDbName']))
		{
			//Daten auslesen
			$insert['clanDbName'] = $_POST['clanDbName'];
			$insert['clanDbShortName'] =  $_POST['clanDbShortName'];
			$insert['clanDbTag'] = $_POST['clanDbTag'];
			$insert['clanDbHomepage'] = $_POST['clanDbHomepage'];
			
			//Daten in die Datenbank schreiben
			dbInsert(1, 'clandb', $insert);
			$mysqlInsertId = mysql_insert_id();
			
			//�berpr�fen ob was hochgeladen wurde
			if($_FILES['clanPic']['error'] != 4)
			{
				//Endung der Datei herausfinden
				$datatyp = pathinfo($_FILES['clanPic']['name']);
				$datatyp = strtolower($datatyp['extension']);
				
				//�berpr�fen ob es sich um Bilder handelt
				if($datatyp  == 'jpg' || $datatyp  == 'jpeg' || $datatyp  == 'png' || $datatyp  == 'gif' || $datatyp == 'bmp')
				{
					//Hochladen
					ecUploadFile('clanPic', 'clandb', $mysqlInsertId.'.'.$datatyp);
					//Bild in die Datenbank einf�gen
					$update['clanDbImage'] = $mysqlInsertId.'.'.$datatyp;
					dbUpdate(1,'clandb',$update,'clanDbId = '.$mysqlInsertId);
				}
			}
			$next = ecReferer('index.php?view=clandb&amp;site=manage');
			echo ecTemplate('clandb', 'add', 'clanAdded');
		}
		else
		{
			//Wenn kein Name eingegeben wurde dann Error
			$errorMsg = $ecLang['errorEmpty'];
			echo ecTemplate('clandb', 'add', 'siteEntry');
		}
	}
	else
	{
		$errorMsg = '';
		$clanDbHomepage = 'http://';
		echo ecTemplate('clanDb', 'add', 'siteEntry');
	}
?>