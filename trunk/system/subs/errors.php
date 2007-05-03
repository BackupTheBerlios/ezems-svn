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
*/ $ecFile = 'system/subs/errors.php';

function ecError($file, $error, $fatal = 0)
{
	global $ecLocal,$ecUser;
	$fatalMessage = ($fatal == 1) ? 'Fatal error' : 'Skript Error';
	$message = $fatalMessage.' in file '.$file.': '.$error;
	array_push($ecLocal['errors'], $message);
	if ($ecLocal['errorLog'] == 1)
	{
		$insertData['errorsFatal'] = $fatal;
		$insertData['errorsMessage'] = $error;
		$insertData['errorsTimestamp'] = $ecLocal['timestamp'];
		$insertData['errorsUserId'] = $ecUser['userId'];
		$insertData['errorsUserIP'] = $ecLocal['userIP'];
		$insertData['errorsFile'] = $file;
		dbInsert(1, 'errors', $insertData);
	}
}
?>