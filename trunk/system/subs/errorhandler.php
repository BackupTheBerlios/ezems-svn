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
*/ $ecFile = 'system/subs/errorhandler.php';

$ecLocal['errors'] = array();

function ecErrorPHP($errno,$errmsg,$file,$linenum)
{ 
	global $ecLocal;
	$errorType = array (
		1	=>	"Error",
		2	=>	"Warning",
		4	=>	"Parsing Error",
		8	=>	"Notice",
		16	=>	"Core Error",
		32	=>	"Core Warning",
		64	=>	"Compile Error",
		128	=>	"Compile Warning",
		256	=>	"User Error",
		512	=>	"User Warning",
		1024=>	"User Notice",
		2048=>	"Strict Error"
	);
	
	$message = 'PHP Error ('.$errorType[$errno].') in file '.$file.': '.$errmsg.' (Line '.$linenum.')';
	array_push($ecLocal['errors'], $message);
}

// Set error_handler
set_error_handler("ecErrorPHP");
?>