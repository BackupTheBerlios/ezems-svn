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
*/ $ecFile = 'plugins/bbcode/system.php';

// Mail
function ecMail($mail)
{  
	$chars = preg_split('//', $mail, -1, PREG_SPLIT_NO_EMPTY);
	$newmail = '';
	foreach ($chars as $val)
	{ 
		$newmail .= '&#'.ord($val).';'; 
	} 
	return $newmail;
}

// Code
function ecBBCodePhp($code)
{ 
	$output['lines'] = '';
	$code = html_entity_decode($code);
	stripslashes($code); 
	$lines = explode("\n", $code);
	foreach($lines as $line => $text)
	{
		$line++;
		$output['lines'] .= $line . ':<br />';
	}
	ob_start(); 
	highlight_string($code); 
	$output['text'] = ob_get_contents();
	ob_end_clean();
	return $output;
} 

// Textfield
function ecBBBodeField($name,$textfield,$fieldvalue)
{
	global $ecSettings;
	$i = 0;
	$maxsmileyscount = $ecSettings['bbcode']['smileycount'] - 1;
	$GLOBALS['bbSmileys'] = '';

	$ecBBCodeData = dbSelect('*',1,'bbcode', "view = 1");
	while($bbcode = mysql_fetch_object($ecBBCodeData))
	{
		$GLOBALS['code'] = $bbcode->code;
		$GLOBALS['bbSmileys'] .= ecTemplate('bbcode', 'textfield', 'smiley');
		if ($i == $maxsmileyscount)
		{
			$i = 0;
			$GLOBALS['bbSmileys'] .= '<br />';
		}
		else
		{
			$i++;
		}
	}
	return ecTemplate('bbcode', 'textfield', 'textfield');
}

// BBCode
function ecBBCode($replace,$html = 0)
{
	global $ecDb, $ecUser, $ecSettings, $ecGobalLang;
	$ecLang = ecGetLang('bbcode', 'system');
	// HTML
	if ($html == 0)
	{
		$replace = htmlspecialchars($replace, ENT_QUOTES, $ecLocal['charset']);
	}
	// Lines
	if ($html == 0)
	{
		$replace = nl2br($replace);
	}
	if ($html == 0)
	{
		// Code
		preg_match_all ("/\[code\](.*?)\[\/code\]/isU", $replace , $tmpVars);
		foreach ($tmpVars[0] as $index => $text)
		{
			$text = nl2br($text);
			$code = ecBBCodePhp($tmpVars[1][$index]);
			$replace = str_replace($text, '<table class="quote">
			  <tr>
				<td class="quote_head">'.$ecLang['code'].':</td>
			  </tr>
			  <tr>
				<td width="10" class="quote_line">'.$code['lines'].'
				<td class="quote_main">'.$code['text'].'</td>
			  </tr>
			</table>', $replace);
		}
		// Line
		$replace = str_replace('[hr]', '<hr />', $replace);
		// Image
		$replace = preg_replace("/\[img\](.*)\[\/img\]/isU", "<img src=\"$1\" border='0' />", $replace); 
		$replace = preg_replace("/\[img=(.*?)x(.*?)\](.*?)\[\/img\]/", "<img src=\"$3\" width=$1 height=$2 border='0' />", $replace);
		// Center
		$replace = preg_replace("/\[center\](.*)\[\/center\]/isU", "<center>$1</center>", $replace);
		// Left
		$replace = preg_replace("/\[left\](.*)\[\/left\]/isU", "<p align=left>$1</p>", $replace);
		// Right
		$replace = preg_replace("/\[right\](.*)\[\/right\]/isU", "<p align=right>$1</p>", $replace);
		// Bold
		$replace = preg_replace("/\[b\](.*)\[\/b\]/isU", "<b>$1</b>", $replace);
		// Italic
		$replace = preg_replace("/\[i\](.*)\[\/i\]/isU", "<i>$1</i>", $replace);
		// Strike
		$replace = preg_replace("/\[s\](.*)\[\/s\]/isU", "<s>$1</s>", $replace);
		// Underlined
		$replace = preg_replace("/\[u\](.*)\[\/u\]/isU", "<u>$1</u>", $replace);
		
		// URL
		$replace = eregi_replace("([ \r\n])www\\.([^ ,\r\n]*)","\\1http://www.\\2",$replace);
		$replace = eregi_replace("([ \r\n])http\:\/\/www\\.([^ ,\r\n]*)","\\1http://www.\\2",$replace);
		$replace = preg_replace("/\[url\]www.(.*)\[\/url\]/isU", "[url]http://www.$1[/url]", $replace);
		$replace = preg_replace("/\[url=(.*?)\]www.(.*?)\[\/url\]/", "[url=$1]http://www.$2[/url]", $replace);
		$replace = preg_replace("/\[url=(.*?)\](.*?)\[\/url\]/", "<a href=\"$1\" target='_blank'>$2</a>", $replace);
		$replace = preg_replace("/\[url\](.*)\[\/url\]/isU", "<a href='$1' target='_blank'>$1</a>", $replace);
	
		// E-Mail
		preg_match_all ("/\[email\](.*?)\[\/email\]/", $replace , $tmp_vars2);
		foreach ($tmp_vars2[0] as $index => $text)
		{
			$email = ecMail($tmp_vars2[1][$index]);
			$replace = str_replace($text, '<a href="mailto:'.$email.'">'.$email.'</a>', $replace);
		}
		$replace = preg_replace("/\[email\](.*?)\[\/email\]/", "<a href=\"mailto:$1\" target='_blank'>$1</a>", $replace);
	
		// Size
		$replace = preg_replace("/\[size=(.*)\](.*)\[\/size\]/isU", "<font size='$1'>$2</font>", $replace);
	
		// Colours
		$replace = preg_replace("/\[color=(.*)\](.*)\[\/color\]/isU", "<span style=\"color:$1\">$2</span>", $replace);
		$replace = preg_replace("/\[bgcolor=(.*)\](.*)\[\/bgcolor\]/isU", "<span style=\"background:$1\">$2</span>", $replace);
	
		// Quote
		$replace = preg_replace("/\[quote\](.*)\[\/quote\]/isU", 
			"<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"quote\">
			  <tr>
				<td class=\"quote_head\">".$ecLang['quote'].":</td>
			  </tr>
			  <tr>
				<td class=\"quote_main\">$2</td>
			  </tr>
			</table>"
			, $replace);
	
		// Quote by... 
		$replace = preg_replace("/\[quote=(.*)\](.*)\[\/quote\]/isU", 
			"<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"quote\">
			  <tr>
				<td class=\"quote_head\">".$ecLang['quote']." - ".$ecLang['quote2']." $1:</td>
			  </tr>
			  <tr>
				<td class=\"quote_main\">$2</td>
			  </tr>
			</table>",
			$replace);
		// Dynamic Symbols
		$ec_bbcode_data = db_select('*', 1, 'bbcode', 'typ=3');
		while($bbcode = mysql_fetch_object($ec_bbcode_data))
		{
			$replace = str_replace($bbcode->code, '<img src="upload/bbcode/' . $bbcode->value . '" border="0" />', $replace);
		}
		// Clip
		preg_match_all ("/\[clip=(.*)\](.*)\[\/clip\]/isU", $replace, $found);
		for ($i = count($found[0]); $i > 0; $i--)
		{
		if ($ec_settings['bbcode']['clip'] == 1)
			{
				$replace = preg_replace("/\[clip=(.*)\](.*)\[\/clip\]/isU",
				"<input id=\"img_".$i."\" name=\"clip\" type=\"button\" value=\"SHOW $1\" class=\"clip\" onClick=\"ec_clip('".$i."','$1',1);\" />
				<span class=\"cliptext\" style=\"display:none\" id=\"text_".$i."\">$2</span>",
				$replace, 1);
			}
			else
			{
				$replace = preg_replace("/\[clip=(.*)\](.*)\[\/clip\]/isU",
				"<img src=\"symbols/default/plugins/bbcode/minus.gif\" width=\"1\" height=\"1\" style=\"display:none\" /><img id=\"img_".$i."\" src=\"symbols/default/plugins/bbcode/plus.gif\" /> <a href=\"javascript:void(0)\" onClick=\"ec_clip('".$i."','$1',2);\">$1</a>
				<span class=\"cliptext\" style=\"display:none\" id=\"text_".$i."\">$2</span>",
				$replace, 1);
			}
		}
	}
		
	//Return
	return $replace;
}
?>