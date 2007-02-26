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
	*/ $ecFile = 'plugins/stats/system.php';

	$insertstats = array();
	$insertstats2 = array();
	
	$insertstats['statsIP'] = $ecLocal['userIP'];

function getOS() {
      if(eregi('Win', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'Windows'; }
  elseif(eregi('Mac', $_SERVER['HTTP_USER_AGENT']) or (eregi('PPC', $_SERVER['HTTP_USER_AGENT']))) { $OS = 'Macintosh'; }
  elseif(eregi('Linux', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'Linux'; }
  elseif(eregi('FreeBSD', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'FreeBSD'; }
  elseif(eregi('SunOS', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'SunOS'; }
  elseif(eregi('BeOS', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'BeOS'; }
  elseif(eregi('OS/2', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'OS2'; }
  else { $OS = 'Andere'; }

  if($OS == "Windows") {
        if(eregi('95', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'Windows 95'; }
    elseif(eregi('98', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'Windows 98'; }
    elseif(eregi('win 9x 4.90', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'Windows Millenium'; }
    elseif(eregi('NT 5.1', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'Windows XP'; }
    elseif(eregi('2000', $_SERVER['HTTP_USER_AGENT']) OR eregi('nt 5.0', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'Windows 2000'; }
    elseif(eregi('2003', $_SERVER['HTTP_USER_AGENT']) OR eregi('nt 5.2', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'Windows 2003'; }
    elseif(eregi('Vista', $_SERVER['HTTP_USER_AGENT']) OR eregi('nt 6.0', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'Windows Vista'; }
    elseif(eregi('visual', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'Windows Visual'; }
    elseif(eregi('NT', $_SERVER['HTTP_USER_AGENT'])) { $OS = 'Windows NT'; }
    else { $OS = 'Windows'; }
  }
return $OS;
}

function getBrowser() {
      if(eregi('msie', $_SERVER['HTTP_USER_AGENT'])) { $browser = 'Internet Explorer'; }
  elseif(eregi('Netscape', $_SERVER['HTTP_USER_AGENT'])) { $browser = 'Netscape'; }
  elseif(eregi('Opera', $_SERVER['HTTP_USER_AGENT'])) { $browser = 'Opera'; }
  elseif(eregi('Firefox', $_SERVER['HTTP_USER_AGENT'])) { $browser = 'Firefox'; }
  elseif(eregi('Konqueror', $_SERVER['HTTP_USER_AGENT'])) { $browser = 'Konqueror'; }
  elseif(eregi('Safari', $_SERVER['HTTP_USER_AGENT'])) { $browser = 'Safari'; }
  elseif(eregi('AOL', $_SERVER['HTTP_USER_AGENT'])) { $browser = 'AOL Browser'; }
  elseif(eregi('links', $_SERVER['HTTP_USER_AGENT']) OR eregi('lynx', $_SERVER['HTTP_USER_AGENT']) OR eregi('w3m', $_SERVER['HTTP_USER_AGENT'])) { $browser = 'Linux Textbrowser'; }
  else { $browser = 'unknown'; }
return $browser;
}

$system=getOS();
$browser=getBrowser();

	switch ($system)
	{
		case 'Macintosh':
			$insertstats['statsSystem'] = 1; break;
		case 'Linux':
			$insertstats['statsSystem'] = 2; break;
		case 'FreeBSD':
			$insertstats['statsSystem'] = 3; break;
		case 'SunOS';
			$insertstats['statsSystem'] = 4; break;
		case 'BeOS';
			$insertstats['statsSystem'] = 5; break;
		case 'OS2';
			$insertstats['statsSystem'] = 6; break;
		case 'Windows Visual';
			$insertstats['statsSystem'] = 10; break;
		case 'Windows 95';
			$insertstats['statsSystem'] = 11; break;
		case 'Windows 98';
			$insertstats['statsSystem'] = 12; break;
		case 'Windows Millenium';
			$insertstats['statsSystem'] = 13; break;
		case 'Windows NT';
			$insertstats['statsSystem'] = 14; break;
		case 'Windows XP';
			$insertstats['statsSystem'] = 15; break;
		case 'Windows 2000';
			$insertstats['statsSystem'] = 16; break;
		case 'Windows 2003';
			$insertstats['statsSystem'] = 17; break;
		case 'Windows Vista';
			$insertstats['statsSystem'] = 18; break;
		case 'Windows';
			$insertstats['statsSystem'] = 9; break;
		default:
			$insertstats['statsSystem'] = 0;
	}
	switch ($browser)
	{
		case 'Internet Explorer':
			$insertstats['statsBrowser'] = 1; break;
		case 'Netscape':
			$insertstats['statsBrowser'] = 2; break;
		case 'Opera':
			$insertstats['statsBrowser'] = 3; break;
		case 'Firefox';
			$insertstats['statsBrowser'] = 4; break;
		case 'Konqueror';
			$insertstats['statsBrowser'] = 5; break;
		case 'Safari';
			$insertstats['statsBrowser'] = 6; break;
		case 'AOL Browser';
			$insertstats['statsBrowser'] = 7; break;
		case 'unknown';
			$insertstats['statsBrowser'] = 0; break;
		default:
			$insertstats['statsBrowser'] = 0;
	}

	$insertstats['statsReferer'] = 0;
	$insertstats['statsUriPlug'] = $ecLocal['plugin'];
	$insertstats['statsUriSite'] = $ecLocal['site'];
	$insertstats['statsTime'] = $ecLocal['timestamp'];
	dbInsert(1, 'stats', $insertstats);

	$day_name=date('D');

    if ($day_name == 'Mon') {$day='week-mo';}
elseif ($day_name == 'Tue') {$day='week-di';}
elseif ($day_name == 'Wed') {$day='week-mi';}
elseif ($day_name == 'Thu') {$day='week-do';}
elseif ($day_name == 'Fr')  {$day='week-fr';}
elseif ($day_name == 'Sat') {$day='week-sa';}
elseif ($day_name == 'Sun') {$day='week-so';}
	
	$hour_num=date('H');

    if ($hour_num == '00') { $hour="00"; }
elseif ($hour_num == '01') { $hour="01"; }
elseif ($hour_num == '02') { $hour="02"; }
elseif ($hour_num == '03') { $hour="03"; }
elseif ($hour_num == '04') { $hour="04"; }
elseif ($hour_num == '05') { $hour="05"; }
elseif ($hour_num == '06') { $hour="06"; }
elseif ($hour_num == '07') { $hour="07"; }
elseif ($hour_num == '08') { $hour="08"; }
elseif ($hour_num == '09') { $hour="09"; }
elseif ($hour_num == '10') { $hour="10"; }
elseif ($hour_num == '11') { $hour="11"; }
elseif ($hour_num == '12') { $hour="12"; }
elseif ($hour_num == '13') { $hour="13"; }
elseif ($hour_num == '14') { $hour="14"; }
elseif ($hour_num == '15') { $hour="15"; }
elseif ($hour_num == '16') { $hour="16"; }
elseif ($hour_num == '17') { $hour="17"; }
elseif ($hour_num == '18') { $hour="18"; }
elseif ($hour_num == '19') { $hour="19"; }
elseif ($hour_num == '20') { $hour="20"; }
elseif ($hour_num == '21') { $hour="21"; }
elseif ($hour_num == '22') { $hour="22"; }
elseif ($hour_num == '23') { $hour="23"; }

//echo $day.'<br>'.$hour;

//	dbUpdate(1, 'stats2', $insertstats2);
	?>