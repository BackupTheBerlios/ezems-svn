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
*/ $ecFile = 'system/subs/date.php';

// Days
$tmpDays[0] = $ecGobalLang['sunday'];
$tmpDays[1] = $ecGobalLang['monday'];
$tmpDays[2] = $ecGobalLang['tuesday'];
$tmpDays[3] = $ecGobalLang['wednesday'];
$tmpDays[4] = $ecGobalLang['thursday'];
$tmpDays[5] = $ecGobalLang['friday'];
$tmpDays[6] = $ecGobalLang['saturday'];

// Months
$tmpMonths[1] = $ecGobalLang['january'];
$tmpMonths[2] = $ecGobalLang['february'];
$tmpMonths[3] = $ecGobalLang['march'];
$tmpMonths[4] = $ecGobalLang['april'];
$tmpMonths[5] = $ecGobalLang['may'];
$tmpMonths[6] = $ecGobalLang['june'];
$tmpMonths[7] = $ecGobalLang['juli'];
$tmpMonths[8] = $ecGobalLang['august'];
$tmpMonths[9] = $ecGobalLang['september'];
$tmpMonths[10] = $ecGobalLang['october'];
$tmpMonths[11] = $ecGobalLang['january'];
$tmpMonths[12] = $ecGobalLang['december'];

// Date
function ecDate($date, $typ = 1)
{
	global $tmpMonths, $tmpDays, $ecGobalLang, $ecLocal;
	// Time
	if ($typ == 1)
	{
		$back = date($ecGobalLang['timetyp'], $date);
		$back .= ' ';
		$back .= $ecGobalLang['oclock'];
		return $back;
	}
	elseif ($typ == 2)
	{
		return date($ecGobalLang['datetyp'], $date);
	}
	elseif ($typ == 2.1)
	{
		$back = date("d", $date);
		$back .= $ecGobalLang['th'];
		$back .= ' ';
		$back .= $tmpMonths[date("n", $date)];
		$back .= ' ';
		$back .= date("Y", $date);
		return $back;
	}
	elseif ($typ == 2.2)
	{
		$back = $tmpDays[date("w", $date)];
		$back .= ', ';
		$back .= $ecGobalLang['the'];
		$back .= ' ';
		$back .= date("j", $date);
		$back .= $ecGobalLang['th'];
		$back .= ' ';
		$back .= $tmpMonths[date("n", $date)];
		$back .= ' ';
		$back .= date("Y", $date);
		return $back;
	}
}

function ecAge($birthDate)
{
	$yearDiff = date("Y", $ecLocal['timestamp']) - date("Y", $birthDate);
	$monthDiff = date("m", $ecLocal['timestamp']) - date("m", $birthDate);
	$dayDiff  = date("d", $ecLocal['timestamp']) - date("d", $birthDate);
	if ($dayDiff < 0 || $monthDiff < 0) $yearDiff--;
	return $yearDiff;
}

// Date & Time
$ecLocal['date'] = ecDate($ecLocal['timestamp'], 2);
$ecLocal['time'] = ecDate($ecLocal['timestamp'], 1);
?>