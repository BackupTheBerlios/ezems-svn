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
*/ $ecFile = 'plugins/system/database.php';

$ecLang = ecGetLang('system','database');
echo ecTemplate('system', 'database', 'siteTitle');
$do = isset($_REQUEST['do']) ? $_REQUEST['do'] : '';
if ($do == 'optimize')
{
	$ecTablesData = dbShowtable();
	while($tables = mysql_fetch_object($ecTablesData))
	{
		dbOptimize(0, $tables->Name);
	}
	$next = ecReferer('index.php?view=system&site=database');
	echo ecTemplate('system', 'database', 'dbOptimized');
}
elseif ($do == 'backup')
{
	$compression = isset($_REQUEST['compression']) ? 1 : 0;
	// Path
	$path = $ecLocal['scriptPath'].'/backups/database/'; 
	
	if (!extension_loaded("zlib")) $compression = 0;
	$filetype = ($compression == 1) ? 'sql.gz' : 'sql';
	
	$curDate = date("Y-m-d", $ecLocal['timestamp']); 
	
	for ($i = 1; file_exists($path.$ecDb['name'].'_'.$curDate.'_'.$i.'_structur'.".sql") || file_exists($path.$ecDb['name'].'_'.$curDate.'_'.$i.'_structur'.".sql.gz"); $i++);
	$path1 = $path.$ecDb['name'].'_'.$curDate.'_'.$i.'_structur'.".".$filetype;
	for ($i = 1; file_exists($path.$ecDb['name'].'_'.$curDate.'_'.$i.'_data'.".sql") || file_exists($path.$ecDb['name'].'_'.$curDate.'_'.$i.'_data'.".sql.gz"); $i++);
	$path2 = $path.$ecDb['name'].'_'.$curDate.'_'.$i.'_data'.".".$filetype; 
	
	dbBackup($ecDb['name'],$path1,$path2,$compression);
	$next = ecReferer('index.php?view=system&site=database');
	echo ecTemplate('system', 'database', 'dbDumped');
}
elseif ($do == 'import')
{
	$file = 'backups/database/'.$_REQUEST['backup'];
	dbImport($file,'abcd');
	$next = ecReferer('index.php?view=system&site=database');
	echo ecTemplate('system', 'database', 'backupImported');
}
elseif ($do == 'delete')
{
	$file = 'backups/database/'.$_REQUEST['backup'];
	ecFileDelete($file);
	$next = ecReferer('index.php?view=system&site=database');
	echo ecTemplate('system', 'database', 'backupDeleted');
}
else
{
	echo ecTemplate('system', 'database', 'siteHead');
	echo ecTemplate('system', 'database', 'dbOptimize');
	echo ecTemplate('system', 'database', 'tablesHead');
	$ecTablesData = dbShowtable();
	while($tables = mysql_fetch_object($ecTablesData))
	{
		$tablesName = $tables->Name;
		$tablesRows = $tables->Rows;
		$tablesOptimized = ($tables->Data_free == 0) ? $ecLang['yes'] : $ecLang['no'];
		echo ecTemplate('system', 'database', 'tablesData');
	}
	echo ecTemplate('system', 'database', 'tablesFoot');
	echo ecTemplate('system', 'database', 'dbDumpHead');
	if (extension_loaded("zlib")) echo ecTemplate('system', 'database', 'dbDumpCompression');
	echo ecTemplate('system', 'database', 'dbDumpFoot');
	echo ecTemplate('system', 'database', 'backupsHead');
	$ecTablesData = dbShowtable();
	foreach(ecFileListFolder('backups/database/',2) as $file)
	{
		$name = $file;
		if (substr($file, -3, 3) == '.gz')
		{
			$typ = 'zip';
			echo ecTemplate('system', 'database', 'backupsData');
		}
		elseif (substr($file, -3, 3) == 'sql')
		{
			$typ = 'sql';
			echo ecTemplate('system', 'database', 'backupsData');
		}
	}
	echo ecTemplate('system', 'database', 'backupsFoot');
	echo ecTemplate('system', 'database', 'siteFoot');
}
?>