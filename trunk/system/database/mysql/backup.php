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
*/ $ecFile = 'system/database/backup.php';

// no direct access
defined( '_VALID_EC' ) or 
	die( 'Restricted access' );
	
// Create backup
function dbBackup($db,$path1,$path2,$compression = 0)
{
	global $ecDb, $ecLocal;
	@set_time_limit(0);
	if (!extension_loaded("zlib")) $compression = 0;
	function getDef($dbname, $table)
	{ 
		global $ecDb; 
		$def = ""; 
	
		$def .= "CREATE TABLE $table (\n"; 
		$result = dbQuery("SHOW FIELDS FROM $table"); 
		while($row = mysql_fetch_array($result)) { 
			$def .= "    $row[Field] $row[Type]"; 
			if ($row['Default'] != '') $def .= " DEFAULT '$row[Default]'"; 
			if ($row['Null'] != 'YES') $def .= " NOT NULL"; 
			if ($row['Extra'] != '') $def .= " $row[Extra]"; 
			$def .= ",\n"; 
		} 
		$def = ereg_replace(",\n$","", $def); 
		$result = dbQuery("SHOW KEYS FROM $table"); 
		while($row = mysql_fetch_array($result))
		{ 
			  $kname = $row['Key_name']; 
			  if(($kname != 'PRIMARY') && ($row['Non_unique'] == 0)) $kname="UNIQUE|$kname"; 
			  if(!isset($index[$kname])) $index[$kname] = array(); 
			  $index[$kname][] = $row['Column_name']; 
		} 
		while(list($x, $columns) = @each($index))
		{ 
			  $def .= ",\n"; 
			  if($x == "PRIMARY") $def .= "  PRIMARY KEY (" . implode($columns, ", ") . ")"; 
			  else if (substr($x,0,6) == "UNIQUE") $def .= "  UNIQUE ".substr($x,7)." (" . implode($columns, ", ") . ")"; 
			  else $def .= "  FULLTEXT KEY $x (" . implode($columns, ", ") . ")"; 
		} 
	
		$def .= "\n);"; 
		return (stripslashes($def)); 
	} 
	function getContent($dbname, $table)
	{ 
		global $ecDb; 
		$content = ""; 
		$result = dbQuery("SELECT * FROM $table"); 
		while($row = mysql_fetch_row($result))
		{ 
			$insert = "INSERT INTO $table VALUES ("; 
			for($j = 0; $j < mysql_num_fields($result); $j++)
			{ 
				if (!isset($row[$j])) $insert .= "NULL,"; 
				else if ($row[$j] != "") $insert .= "'".addslashes($row[$j])."',"; 
				else $insert .= "'',"; 
			} 
			$insert = ereg_replace(",$","",$insert); 
			$insert .= ");\n"; 
			$content .= $insert; 
		} 
		return $content; 
	} 
	function writeBackup($newfile,$newfileData) 
	{ 
		global $compression, $path, $curDate, $filetype, $path1, $path2; 
		if ($compression == 1) 
		{ 
			$fp = gzopen($path1,"w9"); 
			gzwrite ($fp, $newfile);
			gzclose ($fp); 

			$fp = gzopen($path2,"w9"); 
			gzwrite ($fp, $newfileData); 
			gzclose ($fp); 
		} 
		else 
		{ 
			$fp = fopen ($path1,"w"); 
			fwrite ($fp, $newfile); 
			fclose ($fp); 
	
			$fp = fopen($path2,"w"); 
			fwrite ($fp, $newfileData); 
			fclose ($fp); 
		}
	}
	
	// create backup 
	$curTime = date("d.m.Y H:i", $ecLocal['timestamp']); 
	$newfile = "# Strukturbackup: $curTime \r\n"; 
	$newfileData = "# Datenbackup: $curTime \r\n"; 

	// write backup 
	$tables = mysql_list_tables($db,$ecDb['con']); 
	$num_tables = @mysql_num_rows($tables); 
	$i = 0; 
	while($i < $num_tables) 
	{ 
		$table = mysql_tablename($tables, $i); 
		
		$newfile .= "\n# ----------------------------------------------------------\n#\n"; 
		$newfile .= "# structur for Table '$table'\n#\n"; 
		$newfile .= getDef($db,$table); 
		$newfile .= "\n\n"; 	
	
		$newfileData .= "\n# ----------------------------------------------------------\n#\n"; 
		$newfileData .= "#\n# data for table '$table'\n#\n"; 
		$newfileData .= getContent($db,$table); 
		$newfileData .= "\n\n"; 
		$i++; 
	} 
	writeBackup($newfile,$newfileData); 
}
// Import backup
function dbImport($file,$db = 0)
{
	$starttime = microtime();
	global $ecDb, $ecFile;
	$db = empty($db) ? $ecDb['name'] : $db;
	if (substr($file, -3, 3) == '.gz')
	{
		$run = gzfile($file);
	}
	else
	{
		$run = file($file);
	}
	foreach ($run as $indx => $val)
	{
		if (substr($val, 0, 1) == '#') $run[$indx] = '';
	}
	$run = implode('',$run);
	$run = explode(');',$run);
	foreach ($run as $query)
	{
		$trim = trim($query);
		if (!empty($trim))
		{
			$query = $query.')';
			array_push($ecDb['querys'], $query); 
			$back = mysql_query($query, $ecDb['con']) or
				ecMysqlerror($ecFile,mysql_error()); 
		}
	}
	$timeago = microtime() - $starttime; 
	$timeago = $timeago * 1000; 
	$ecDb['time'] = $ecDb['time'] + $timeago; 
	return  $back; 
}
?>