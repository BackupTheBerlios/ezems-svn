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
*/ $ecFile = 'system/subs/files.php';

// Checkdir
function ecFileListFolder($dir,$typ = 1)
{ 
	global $ecFile;
	ini_set("max_execution_time",10);
	if (!is_dir($dir)) 
	{ 
		$message = 'Bad folder: ' . $dir;
		ecError($ecFile,$message);
	}
	else
	{
		if ($typ == 1) { // Ordner
			$handle = opendir($dir);
			$filesArray = array ();
			while ($file = readdir($handle)) {            
				if ($file != "." && $file != ".." && is_dir("$dir/$file")) {                    
					$result = $file;
					array_push($filesArray,$result);  
				}
			}
		}
		elseif ($typ == 2) // Dateien
		{
			$handle = opendir($dir);
			$filesArray = array ();
			while ( $file = readdir($handle) ) {
				if($file != "." && $file != ".." && !is_dir("$dir/$file")) {
					$result = $file;
					array_push($filesArray,$result);
				}
			}
		}
		elseif ($typ == 3) // Ordner und Dateien
		{
			$handle = opendir($dir);
			$filesArray = array ();
			while ( $file = readdir($handle) ) {
				if($file != "." && $file != "..") {
					$result = $file;
					array_push($filesArray,$result);
				}
			}
		}
		else
		{
			$message = 'Bad typ given in function ecFileListFolder() required: 1, 2 or 3';
			ecError($ecFile,$message);
		}
		return $filesArray; // Ausgabe
	}
}

// Delete
function ecFileDelete($file)
{
	global $ecFile;
	if (file_exists($file))
	{
		unlink($file);
		return true;
	}
	else
	{
		$message = 'Can not delete file: '.$file;
		ecError($ecFile,$message);
		return false;
	}	
}

// Copy
function ecFileCopy($from,$to,$replace = 0)
{
	if (isset($GLOBALS['externArrayStart']))
	{
		global $externArrayStart;
	}
	else
	{
		global $externArrayStart;
		$externArrayStart = array();
	}
	if (file_exists($from))
	{
		$data = implode('',file($from));
		if (substr($data, 0, 12) == '#ec_autoexec')
		{
			array_push($externArrayStart,$to);
			$data = str_replace('#ec_autoexec', '', $data);
		}
	}
	if ($replace == 1)
	{
		$backup = $to.'.bak';
		if (!file_exists($to))
		{	
			$datei = fopen($to,'w');
				fwrite($datei,$data);
			fclose($datei);
		}
		else
		{
			if (file_exists($backup))
			{
				unlink($backup);
			}
			ecFileCopy($from,$backup,1);
		}
	}
	else
	{
		if (!file_exists($to))
		{	
			$datei = fopen($to,'w');
				fwrite($datei,$data);
			fclose($datei);
		}
	}
	return $to;
}

// Move
function ecFileMove($from,$to,$replace = 0)
{
	if (file_exists($from))
	{
		$data = implode('',file($from));
		
		if ($replace == 1)
		{
			$datei = fopen($to,'w');
				fwrite($datei,$data);
			fclose($datei);
		}
		else
		{
			if (!file_exists($to))
			{	
				$datei = fopen($to,'w');
					fwrite($datei,$data);
				fclose($datei);
			}
		}
		ecFileDelete($from);
	}
	else
	{
		return false;
	}
	return $to;
}

// Copy Folder
function ecFileCopyFolder($from,$to)
{
	ini_set("max_execution_time",60);
	$log['folder'] = array();
	$log['files'] = array();
	if (substr($to, -1,1) == '/')
	{
		$to = substr($to, 0,-1);
	}
	if (substr($from, -1,1) == '/')
	{
		$from = substr($from, 0,-1);
	}
	if (!file_exists($to))
	{
		mkdir($to,0777);
		array_push($log['folder'],$to);
	}
	$data = ec_checkdir($from,3);
	foreach($data as $id => $file)
	{
		$writepath = $to.'/'.$file;
		$readpath = $from.'/'.$file;
		if (!is_dir($from.'/'.$file))
		{
			$action = fl_copy($readpath,$writepath,1);
			array_push($log['files'],$action);
		}
		else
		{
			$action = fl_copyfolder($readpath,$writepath);
			foreach($action['folder'] as $id => $file)
			{
				array_push($log['folder'],$file);
			}
			foreach($action['files'] as $id => $file)
			{
				array_push($log['files'],$file);
			}
		}
	}
	return $log;
}
?>