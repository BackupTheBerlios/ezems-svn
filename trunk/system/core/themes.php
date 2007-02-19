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
*/ $ecFile = 'system/core/themes.php';

// Themes
$ecThemesData = dbSelect('themesId,themesPath',1,'themes');
while($themes = mysql_fetch_object($ecThemesData))
{
	$ecLocal['themesList'][$themes->themesId] = $themes->themesPath;
}

// Load Themes
$ecLocal['theme'] = $ecLocal['themesList'][$ecUser['themeId']];
$themesPath = 'themes/'.$ecLocal['theme'].'/index.html';
if (file_exists($themesPath))
{
	$html = implode('',file($themesPath));
}
else
{
	$ecLocal['theme'] = $ecLocal['themesList'][$ecSettings['system']['defaultThemeId']];
	$themesPath = 'themes/'.$ecLocal['theme'].'/index.html';
	if (file_exists($themesPath))
	{
		$html = implode('',file($themesPath));
	}
	else
	{
		header("Location: error.php?typ=themes");
		exit();
	}
}

// Plugin & Site
if (!ecGetAccessLevel($ecLocal['plugin'],$ecLocal['site']))
{
	$ecLocal['plugin'] = 'errors';
	$ecLocal['site'] = '403';
}
$tmpReplaces['sub:view'] = 'plugins/'.$ecLocal['plugin'].'/'.$ecLocal['site'].'.php';

// Replace Vars
preg_match_all ("/{(?!sub)(.*?)\:(.*?)}/Sis", $html , $tmpVars);
$count = count($tmpVars[0]);
$i = 0;
while(!empty($count))
{
	$tmpVars[0][$i] = str_replace('{', '', $tmpVars[0][$i]);
	$tmpVars[0][$i] = str_replace('}', '', $tmpVars[0][$i]);
	$file = 'plugins/' . $tmpVars[1][$i] . '/' . $tmpVars[2][$i] . '.php';
	if(!file_exists($file) || !in_array($tmpVars[1][$i], $ecLocal['pluginsList'])) 
	{		
		$message = 'File not found: ' . $file;
		ecError($ecFile, $message);
	}
	else
	{
		if (ecGetAccessLevel($tmpVars[1][$i],$tmpVars[2][$i]))
		{
			$tmpReplaces[$tmpVars[0][$i]] = $file;
		}
		else
		{
			$html = str_replace('{' . $tmpVars[0][$i] . '}', '', $html);
		}
	}
	$i++;
	$count--;
}

// Refresh Paths
$refreshImages = "=link href\=\"(?!http)(.*?)\"=si";
$html = preg_replace($refreshImages,"link href=\"themes/".$ecLocal['theme']."/\\1\"", $html);
$refreshBackgrounds = "=background\=\"(?!http)(.*?)\"=si";
$html = preg_replace($refreshBackgrounds,"background=\"themes/".$ecLocal['theme']."/\\1\"", $html);
$refreshSources = "=src\=\"(?!http)(.*?)\"=si";
$html = preg_replace($refreshSources,"src=\"themes/".$ecLocal['theme']."/\\1\"", $html);

// Load Template Stylesheet
$refreshCss = "<link href=\"templates/".$ecLocal['template']."/style.css\" rel=\"stylesheet\" type=\"text/css\" /> \n</head>";
$html = preg_replace("=</head>=si", $refreshCss, $html);

// Load Theme Stylesheet
$refreshCss2 = "<link href=\"themes/".$ecLocal['theme']."/style.css\" rel=\"stylesheet\" type=\"text/css\" /> \n</head>";
$html = preg_replace("=</head>=si", $refreshCss2, $html);

// Javaskripte laden
$javaScript = implode('', file("system/subs/javascript.js"));
$ecJsData = dbSelect('sitesName,sitesPluginId',1,'sites', "sitesTyp=5");
while($sites = mysql_fetch_object($ecJsData))
{
	$sitePath = 'plugins/'.$ecLocal['pluginsList'][$sites->sitesPluginId].'/'.$sites->sitesName.'.js';
	$javaScript .= " \n";
	$javaScript .= implode('', file($sitePath));
}
$html = preg_replace("=</head>=si","<script language=\"javascript\" type=\"text/javascript\"> \n<!-- \n".$javaScript." \n//--> \n</script> \n</head>", $html, 1);


// Plugins includen
foreach($tmpReplaces as $themeRow => $themeIncls)
{
	ob_start();
	include ($themeIncls);
	$themeIncls = ob_get_contents();
	ob_end_clean(); 
	$themeIncls = str_replace('{', "&#123;", $themeIncls);
	$themeIncls = str_replace('}', "&#125;", $themeIncls);
	$html = str_replace('{'.$themeRow.'}', $themeIncls, $html);
}

// Time
$html = str_replace('{sub:time}', $ecLocal['time'], $html);

// Date
$html = str_replace('{sub:date}', $ecLocal['date'], $html);

// Errors
$html = str_replace('{sub:errors}', implode("<br /> \n",$ecLocal['errors']), $html);

// Database querys
$html = str_replace('{sub:sqlquerys}', implode("<br /> \n",$ecDb['querys']) . '<br /> Total Querytime: ' . $ecDb['time'] . 'ms', $html);

// Title
$html = str_replace('{sub:title}', $ecSettings['system']['title'], $html); 

// RSS-Feed

if (isset($ecLocal['rssFeedLink']))
{
	$rssCode = "<link rel=\"alternate\" href=\"".$ecLocal['rssFeedLink']."\" type=\"application/rss+xml\" title=\"RSS-Feed\" /> \n</head>";
	$html = str_replace('</head>', $rssCode, $html);
}
// Auto referer
if (isset($ecLocal['referer']['time']) && isset($ecLocal['referer']['path']))
{
	$refererCode = "<head> \n<meta http-equiv=\"refresh\" content=\"".$ecLocal['referer']['time'].";URL=".$ecLocal['referer']['path']."\" />";
	$html = str_replace('<head>', $refererCode, $html);
}

// Parsezime
$parseEnd = microtime(true);
$parsetime = $parseEnd - $parseStart;
$parsetime = round($parsetime * 1000, 2);

$html = str_replace('{sub:parse}', $parsetime.'ms', $html);

$html = $html."\n".ecCreateHtmlComment('Created with EC-CP - Version '.$ecSettings['system']['version']);
?>