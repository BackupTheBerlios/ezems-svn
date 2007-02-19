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
*/ $ecFile = 'system/subs/templates.php';

// Templates
$ecTemplatesData = dbSelect('templatesId,templatesPath',1,'templates');
while($templates = mysql_fetch_object($ecTemplatesData))
{
	$ecLocal['templatesList'][$templates->templatesId] = $templates->templatesPath;
}

// Load Templates
$ecLocal['template'] = $ecLocal['templatesList'][$ecUser['templateId']];
$themesPath = 'templates/'.$ecLocal['template'];
if (!file_exists($themesPath))
{
	$ecLocal['template'] = $ecLocal['templatesList'][$ecSettings['system']['defaultTemplateId']];
	$templatesPath = 'templates/'.$ecLocal['template'].'/index.html';
	if (!file_exists($templatesPath))
	{
		header("Location: error.php?typ=templates");
		exit();
	}
}

function ecTemplate($plugin, $site, $part = 'default', $language = 0)
{
	global $ecSettings, $ecFile, $ecLocal, $ecUser;
	// Language
	$language = empty($language) ? $site : $language;
	$ecLang = ecGetLang($plugin, $language);
	// Start parse
	$templatePath = 'templates/' . $ecLocal['template'] . '/' . $plugin . '/' . $site . '.html';
	if (file_exists($templatePath))
	{
		$template = implode('',file($templatePath));
		$template = str_replace('{ecTableWidth}', $ecLocal['tableWidth'], $template);
		#########################
		if ($part != 'default')
		{
			preg_match_all ("/\<\!\+" . $part . "\>(.*?)\<\!\-" . $part . "/Sis", $template , $tmpPart);
			if (isset($tmpPart[1][0]))
			{
				$template = $tmpPart[1][0];
			}
			else
			{
				$template = '';
				ecError($ecFile, 'Templateerror: Part "'.$part.'" not found');
			}
		}
		else
		{
			$template = preg_replace("/\{\!(.*?)\}/is", '', $template);
		}
		#########################
		preg_match_all ("={(.)(.*?)}=si", $template , $tmpVars);
		$count = count($tmpVars[0]);
		$i = 0;
		while(!empty($count))
		{	
			if ($tmpVars[1][$i] == '?')
			{
				if (isset($ecLang[$tmpVars[2][$i]]))
				{
					$template = str_replace($tmpVars[0][$i], $ecLang[$tmpVars[2][$i]], $template);
				}
				else
				{
					$template = str_replace($tmpVars[0][$i], 'not defined!', $template);
					ecError($ecFile,'Languagevar '.$tmpVars[0][$i].' isn`t defined');
				}
			}
			elseif ($tmpVars[1][$i] == '@')
			{
				if (isset($ecLang[$tmpVars[2][$i]]))
				{
					$template = str_replace($tmpVars[0][$i], ec_bbcode($ecLang[$tmpVars[2][$i]]), $template);
				}
				else
				{
					$template = str_replace($tmpVars[0][$i], 'not defined!', $template);
					ecError($ecFile,'Languagevar '.$tmpVars[0][$i].' isn`t defined');
				}
			}
			elseif ($tmpVars[1][$i] == '$')
			{
				if (isset($GLOBALS[$tmpVars[2][$i]]))
				{
					$template = str_replace($tmpVars[0][$i], $GLOBALS[$tmpVars[2][$i]], $template);
				}
				else
				{
					$template = str_replace($tmpVars[0][$i], '', $template);
				}
			}
			$i++;
			$count--;
		} 
		#########################
		preg_match_all ("={icon:(.*?)}=si", $template , $tmpVarsIcons);
		$count = count($tmpVarsIcons[0]);
		$i = 0;
		while(!empty($count))
		{	
			$iconsdata = preg_split('=:=si',$tmpVarsIcons[1][$i]);
			if (file_exists('icons/'.$ecLocal['icons'].'/'.$iconsdata[0]))
			{
				$icon = 'icons/'.$ecLocal['icons'].'/'.$iconsdata[0].'/'.$iconsdata[1].'.png';
				$icon = file_exists($icon) ? $icon : 'icons/'.$ecLocal['icons'].'/'.$iconsdata[0].'/default.png';
			}
			else
			{
				$icon = '';
				$message = 'Iconfolder not found: icons/'.$ecLocal['icons'].'/'.$iconsdata[0].'/';
				ecError($ecFile,$message);
			}
			$template = str_replace($tmpVarsIcons[0][$i], $icon, $template);
			$i++;
			$count--;
		} 
		#########################
		// End parse
		return $template;
	}
	else
	{
		$templatePath = 'templates/' . $ecLocal['template'] . '/' . $plugin . '/' . $site;
		$message = 'Template (' . $templatePath . '.html) nicht vorhanden';
		$message2 = 'Template (' . $site . '.html) nicht vorhanden';
		ecError($ecFile,$message);
		return $message2;
	}
}
?>