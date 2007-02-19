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
*/ $ecFile = 'plugins/stats/manage.php';

echo ecTemplate('stats', 'manage', 'siteHead');

if (isset($_POST['save']))
{
	$data['online'] = isset($_POST['online']) ? 1 : 0;
	$data['today'] = isset($_POST['today']) ? 1 : 0;
	$data['yesterday'] = isset($_POST['yesterday']) ? 1 : 0;
	$data['month'] = isset($_POST['month']) ? 1 : 0;
	$data['all'] = isset($_POST['all']) ? 1 : 0;
	$data['hits'] = isset($_POST['hits']) ? 1 : 0;
	
	ecSettings('stats', $data);
	$next = ecReferer('index.php?view=stats&amp;site=manage');
	echo ecTemplate('stats', 'manage', 'statsSaved');
}
else
{
	$online = !empty($ecSettings['stats']['online']) ? ' checked="checked"' : '';
	$today = !empty($ecSettings['stats']['today']) ? ' checked="checked"' : '';
	$yesterday = !empty($ecSettings['stats']['yesterday']) ? ' checked="checked"' : '';
	$month = !empty($ecSettings['stats']['month']) ? ' checked="checked"' : '';
	$all = !empty($ecSettings['stats']['all']) ? ' checked="checked"' : '';
	$hits = !empty($ecSettings['stats']['hits']) ? ' checked="checked"' : '';

	
	echo ecTemplate('stats', 'manage', 'statsSkript');
}
?>