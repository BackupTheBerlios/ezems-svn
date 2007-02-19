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
*/ $ecFile = 'system/database/mysql.php';

// no direct access
defined( '_VALID_EC' ) or 
	die( 'Restricted access' );
	
// Connect
$ecDb['con'] = mysql_connect($ecDb['host'],$ecDb['user'],$ecDb['pwd']) or
	header("Location: error.php?typ=dbconnect");
mysql_select_db($ecDb['name']) or
	header("Location: error.php?typ=dbname");

$ecDb['querys'] = array();
$ecDb['time'] = 0;

// MYSQL Error
function dbMySQLError($file, $message)
{
	global $ecLocal, $ecFile;
	if (!empty($ecLocal['opt_error']))
	{
		array_push($ec_local['errors'],'MySQL-Error in ' . $file . ': ' . $message . '<br />');
	}
	return 'Error in ' . $file . ': ' . $message;
}

// OPTIMIZE
function dbOptimize($prefix, $table) 
{
	$starttime = microtime(true); 
	global $ecDb, $ecFile; 
	$query = 'OPTIMIZE TABLE '; 
	if ($prefix == 1) 
	{ 
		$query .= $ecDb['prefix']; 
	} 
	$query .= $table; 
	// 
	array_push($ecDb['querys'], $query); 
	$back = mysql_query($query, $ecDb['con']) or
		dbMySQLError($ecFile,mysql_error()); 
	$timeago = microtime(true) - $starttime; 
	$ecDb['time'] = $ecDb['time'] + $timeago; 
	return  $back; 
}

// MYSQL Query
function dbQuery($query) 
{
	$starttime = microtime(true); 
	global $ecDb, $ecFile; 
	array_push($ecDb['querys'], $query); 
	$back = mysql_query($query, $ecDb['con']) or
		dbMySQLError($ecFile,mysql_error()); 
	$timeago = microtime(true) - $starttime; 
	$ecDb['time'] = $ecDb['time'] + $timeago; 
	return  $back; 
}

// SHOW TABLE STATUS
function dbShowTable($db = 'db') 
{
	$starttime = microtime(true); 
	global $ecDb, $ecFile; 
	$db = ($db == 'db') ? $ecDb['name'] : $db;
	$query = 'SHOW TABLE STATUS FROM '; 
	$query .= $db; 
	// 
	array_push($ecDb['querys'], $query); 
	$back = mysql_query($query, $ecDb['con']) or
		dbMySQLError($ecFile,mysql_error()); 
	$timeago = microtime(true) - $starttime; 
	$ecDb['time'] = $ecDb['time'] + $timeago; 
	return  $back; 
}

// MYSQL escape
function dbRealEscapeString($string) {

	global $ecDb;
	return mysql_real_escape_string($string,$ecDb['con']);
}

// MYSQL SELECT
function dbSelect($select,$prefix,$from,$where = 0,$order = 0,$typ = 0,$limit1 = 0,$limit2 = 0) 
{  
	$starttime = microtime(true);  
	global $ecDb, $ecFile;  
	$select = preg_replace("/{pre}/Sis", $ecDb['prefix'], $select);
	$query = ' SELECT ' . $select . ' FROM ';
	$from_explode = explode(',',$from);
	$num_from = count($from_explode);
	for($i=0; $i < $num_from; $i++)
	{
		if ($prefix == 1)
		{
			$query .= $ecDb['prefix'] . $from_explode[$i];
		}
		else
		{
			$query .= $from_explode[$i];
		}
		if($i!=$num_from-1)
		{
			$query.=', ';
		}
	}
	if (!empty($where))
	{
		$where = preg_replace("/{pre}/Sis", $ecDb['prefix'], $where);
		$query .= ' WHERE ';
		$query .= $where;
	}
	if (!empty($order))
	{
		$query .= ' ORDER BY ';
		$query .= $order;  
		if ($typ==1) $query .= ' ASC';  
		elseif ($typ==2) $query .= ' DESC'; 
	} 
	if (!empty($limit1) || !empty($limit2))
	{
		$query .= ' LIMIT  ';
		$query .= $limit1;  
		if (!empty($limit2))
		{
			if (!empty($limit1)) $query .= ',';
			$query .= $limit2;
		} 
	}  
	array_push($ecDb['querys'], $query);  
	$back = mysql_query($query, $ecDb['con']) or
		dbMySQLError($ecFile, mysql_error()); 
	$timeago = microtime(true) - $starttime;  
	$ecDb['time'] = $ecDb['time'] + $timeago; 

return $back; 
}

// MYSQL DELETE
function dbDelete($prefix, $from, $where = 0)
{
	$starttime = microtime(true);
	global $ecDb, $ecFile;
	$query = 'DELETE FROM ';
	if ($prefix = 1)
	{
		$query .= $ecDb['prefix'];
	}
	$query .= $from;
	//
	if (!empty($where))
	{
		$query .= ' WHERE ';
		$query .= $where;
	}

	array_push($ecDb['querys'], $query);
	$back = mysql_query($query, $ecDb['con']) or
		dbMySQLError($ecFile,mysql_error());
	$timeago = microtime(true) - $starttime;
	$ecDb['time'] = $ecDb['time'] + $timeago;
	return  $back;
}

// MYSQL INSERT
function dbInsert($prefix, $into, $values)
{
	$starttime = microtime(true);
	global $ecDb, $ecFile;
	$query = 'INSERT INTO ';
	if ($prefix = 1)
	{
		$query .= $ecDb['prefix'];
	}
	$query .= $into;
	//
	$rows = '';
	$cells = '';
	$max = count($values);
	$count = 0;
	foreach ($values as $row => $cell)
	{
		$rows .= mysql_real_escape_string($row, $ecDb['con']);
		if ($count != $max - 1)
		{
			$rows .= ', ';
		}
		$cells .= mysql_real_escape_string($cell, $ecDb['con']);
		if ($count != $max - 1)
		{
			$cells .= '\', \'';
		}
		$count++;
	}

	$query .= ' (';
	$query .= $rows;
	$query .= ')';
	$query .= ' VALUES (\'';
	$query .= $cells;
	$query .= '\')';
	//
	array_push($ecDb['querys'], $query);
	$back = mysql_query($query, $ecDb['con']) or
		dbMySQLError($ecFile,mysql_error());
	$timeago = microtime(true) - $starttime;
	$ecDb['time'] = $ecDb['time'] + $timeago;
	return  $back;
}

// MYSQL UPDATE
function dbUpdate($prefix, $update, $values, $where = 0)
{
	$starttime = microtime(true);
	global $ecDb, $ecFile;
	$query = 'UPDATE ';
	if ($prefix = 1)
	{
		$query .= $ecDb['prefix'];
	}
	$query .= $update;
	//
	$rows = '';
	$cells = '';
	$updates = '';
	$max = count($values);
	$count = 0;
	foreach ($values as $row => $cell)
	{
		$rows .= mysql_real_escape_string($row, $ecDb['con']);
		$cells .= mysql_real_escape_string($cell, $ecDb['con']);
		if ($count != $max - 1)
		{
			$cells .= ', ';
		}
		$updates .= $row . '=\'' . $cell;
		if ($count != $max - 1)
		{
			$updates .= '\', ';
		}
		$count++;
	}

	$query .= ' SET ';
	$query .= $updates;
	$query .= '\'';

	if (!empty($where))
	{
		$query .= ' WHERE ';
		$query .= $where;
	}

	array_push($ecDb['querys'], $query);
	$back = mysql_query($query, $ecDb['con']) or
		dbMySQLError($ecFile,mysql_error());
	$timeago = microtime(true) - $starttime;
	$ecDb['time'] = $ecDb['time'] + $timeago;
	return  $back;
}

// MYSQL DROP
function dbDrop($prefix, $drop)
{
	$starttime = microtime(true);
	global $ecDb, $ecFile;
	$query = 'DROP ';
	if ($prefix = 1)
	{
		$query .= $ecDb['prefix'];
	}
	$query .= $drop;
	//
	array_push($ecDb['querys'], $query);
	$back = mysql_query($query, $ecDb['con']) or
		dbMySQLError($ecFile,mysql_error());
	$timeago = microtime(true) - $starttime;
	$ecDb['time'] = $ecDb['time'] + $timeago;
	return  $back;
}

// MYSQL ALTER
function dbAlter($prefix, $table, $typ, $column)
{
	$starttime = microtime(true);
	global $ecDb, $ecFile;
	$query = 'ALTER TABLE ';
	if ($prefix = 1)
	{
		$query .= $ecDb['prefix'];
	}
	$query .= $table;
	if ($typ = 1)
	{
		$query .= ' DROP ';
		$query .= $column;
	}
	else
	{
		$query .= ' ADD (';
		$query .= $column;
		$query .= ')';
	}

	array_push($ecDb['querys'], $query);
	$back = mysql_query($query, $ecDb['con']) or
		dbMySQLError($ecFile,mysql_error());
	$timeago = microtime(true) - $starttime;
	$ecDb['time'] = $ecDb['time'] + $timeago;
	return  $back;
}

// Version
function dbVersion() {

	global $ecDb, $ecFile;
	$version = mysql_get_server_info($ecDb['con']) or
		dbMySQLError($ecFile,mysql_error());
	return 'MySQL ' . $version;
}
?>