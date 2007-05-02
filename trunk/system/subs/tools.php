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
*/ $ecFile = 'system/subs/tools.php';


#X-Perimental -->
// Arrange
function ecArrange($standard,$standardTyp)
{
	global $_REQUEST, $_GET, $ecGlobalLang;
	$arrange['typ'] = isset($_REQUEST['arrangetyp']) ? $_REQUEST['arrangetyp'] : $standardTyp;
	$arrange['name'] = isset($_REQUEST['arrange']) ? $_REQUEST['arrange'] : $standard;
	$typ = ($arrange['typ'] == 1) ? $ecGlobalLang['ascending'] : $ecGlobalLang['descending'];
	$arrange['message'] = $ecGlobalLang['arrangeby'].': '.$arrange['name'].' - '.$typ;
	return $arrange;
}

// Arrangelink
function ecArrangeLink($arrangeby)
{
	global $_REQUEST, $_GET;
	$link = 'index.php?';
	$g = 0;
	foreach ($_GET as $name => $value)
	{
		if ($name != 'arrange' && $name != 'arrangetyp') 
		{
			if ($g != 0) $link .= '&amp;';
			$link .= $name.'='.$value;
		}
		$g++;
	}
	if (isset($_REQUEST['arrangetyp']))
	{
		$arrangeTyp = ($_REQUEST['arrangetyp'] == 1 && $_REQUEST['arrange'] == $arrangeby) ? 2 : 1;
	}
	else
	{
		$arrangeTyp = 1; 
	}
	$link .= '&amp;arrange='.$arrangeby.'&amp;arrangetyp='.$arrangeTyp;
	return $link;
}

// Blättern
function ecSites($queryData,$persite = '')
{
	global $ecSettings, $_REQUEST, $_GET, $ecGobalLang;
	$return['navi'] = '';
	if (empty($persite))
	{
		$persite = $ec_settings['local']['postspp'];
	}
	$anz = mysql_num_rows($querydata);
	$return['count'] = $anz;
	$c = 0;
	while($anz > 0)
	{
		$c++;
		$anz = $anz - $persite;
	}
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	if ($page > $c) $page = $c;
	if ($page < 1) $page = 1;
	$pag = $page - 1;
	$link = 'index.php?';
	$g = 0;
	foreach ($_GET as $name => $value)
	{
		if ($name != 'page')
		{
			if ($g != 0) $link .= '&amp;';
			$link .= $name.'='.$value;
		}
		$g++;
	}
	if ($page > 4) $return['navi'] .= '<a href="'.$link.'&amp;page=1">&laquo; '.$ecGlobalLang['first'].'</a> ... ';
	if ($page > 1) $return['navi'] .= '<a href="'.$link.'&amp;page='.$pag.'">&laquo; '.$ecGlobalLang['back'].'</a> ';
	if ($page == 1)
	{
		$return['l1'] = '';
	}
	else
	{
		$return['l1'] = $persite * $page - $persite;
	}
	$return['l2'] = $persite;
	for ($b = $page - 3; $b <= $page + 3; $b++)
	{
		$site = $b;
		if ($b > 0 && $b <= $c)
		{
			if ($page == $site)
			{
				$return['navi'] .= '['.$b.'] ';
			}
			else
			{
				$return['navi'] .= '<a href="'.$link.'&amp;page='.$site.'">'.$b.'</a> ';
			}
		}
	}
	$pag = $page + 1;
	if ($page < $c) $return['navi'] .= '<a href="'.$link.'&amp;page='.$pag.'">'.$ecGlobalLang['next'].' &raquo;</a> ';
	if ($page < $c - 3) $return['navi'] .= '... <a href="'.$link.'&amp;page='.$c.'">'.$ecGlobalLang['last'].' &raquo;</a> ';
	return $return;
}
# X-Perimental <--

// Upload
function ecUploadFile($fileVariable, $uploadDir, $newFilename = 0)
{
	if (!empty($_FILES[$fileVariable])) 
	{
		$uploaddir = 'uploads/'.$uploadDir.'/';
		if (!file_exists($uploaddir))
		{
			mkdir($uploaddir,0777);
		}
		@chmod($uploaddir,0777);
		$uploaddir.= !empty($newFilename) ? $newFilename : basename($_FILES[$fileVariable]['name']);
		
		// Copy the file to permanent location
		if (move_uploaded_file($_FILES[$fileVariable]['tmp_name'], $uploaddir))
		{
			return $uploaddir;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

// Send Mail
function ecSendMail($to,$subject,$message,$from = 1)
{
	global $ecSettings;
	$from = ($from == 1) ? $ec_settings['system']['mailDefaultAdress'] : $from;
	mail($to, $ecSettings['system']['mailSubjectPrefix'].$subject, $message, "From: ".$from."\nX-Mailer: PHP/" . phpversion()); 
}

// HTML Comment
function ecCreateHtmlComment($comment)
{
	$html = '<!-- ';
	$html .= $comment;
	$html .= ' -->';
	return $html;
}

// Settings
function ecSettings($plugin, $dataTmp, $valueTmp = 0)
{
	global $ecSettings, $ecFile;
	if (!is_array($dataTmp))
	{
		if (!isset($ecSettings[$plugin][$dataTmp]))
		{
			$insertData['settingsPlugin'] = $plugin;
			$insertData['settingsKey'] = $dataTmp;
			$insertData['settingsValue'] = $valueTmp;
			dbInsert(1, 'settings', $insertData);
		}
		else
		{
			$insertData['settingsValue'] = $valueTmp;
			dbUpdate(1, 'settings', $insertData, "(settingsKey='$dataTmp') AND (settingsPlugin='$plugin')");
		}
	}
	else
	{
		foreach($dataTmp as $name => $value) {
			if ($name != 'save')
			{
				if (!isset($ecSettings[$plugin][$name]))
				{
					$insvalues['settingsPlugin'] = $plugin;
					$insvalues['settingsKey'] = $name;
					$insvalues['settingsValue'] = $value;
					dbInsert(1, 'settings', $insvalues);
				}
				else
				{
					$insvalues['settingsValue'] = $value;
					dbUpdate(1, 'settings', $insvalues, "((settingsKey='$name') AND (settingsPlugin='$plugin'))");
				}
			}
		}
	}
}

// Filesize
function ecFilesize($size, $typ = 2)
{

	$name = array(0 => 'Byte', 1 => 'KB', 2 => 'MB', 3 => 'GB', 4 => 'TB');
	$digits = 0;
	while($size >= 1024)
	{
		$size = $size / 1024;
		$digits++;
	}
	$return = round($size,$typ) . ' ' . $name[$digits];
	return $return;
}

// Autorefresh
function ecReferer($refererPath, $refererTime = 'usual', $refererMessage = 1)
{  
	global $ecLocal, $ecSettings, $ecGobalLang;
	
	if ($refererTime == 'usual') 
		$refererTime = $ecSettings['system']['usualRefererTime'];
	$ecLocal['referer']['time'] = $refererTime;
	$ecLocal['referer']['path'] = $refererPath;
	if ($refererMessage == 1) 
		return $ecGobalLang['referer1'].' '.$ecLocal['referer']['time'].' '.$ecGobalLang['referer2'].' <a href="'.$ecLocal['referer']['path'].'">['.$ecGobalLang['next'].']</a>';
}

// ICQ Status
function ecGetICQ($uin) 
{
	// Skript by http://www.designerzone.de
	if(!is_numeric($uin)) return 'unknown';
	$fp = fsockopen('status.icq.com', 80, &$errno, &$errstr, 8);
	if(!$fp) return 'unknown';
	$request = "HEAD /online.gif?icq=$uin HTTP/1.0\r\n"."Host: web.icq.com\r\n"."Connection: close\r\n\r\n";
	fputs($fp, $request);
	do
	{
		$response = fgets($fp, 1024);
	}
	while(!feof($fp) && !stristr($response, 'Location'));
	fclose($fp);
	if(strstr($response, 'online1')) return 'online';
	if(strstr($response, 'online0')) return 'offline';
	if(strstr($response, 'online2')) return 'unknown';
	return 'unknown';
}

// ICQ Protect
function ecICQ($uin) 
{
	$return = substr($uin,0,3).'-';
	$return .= substr($uin,3,3).'-';
	$return .= substr($uin,6,3);
	return $return;
}

?>