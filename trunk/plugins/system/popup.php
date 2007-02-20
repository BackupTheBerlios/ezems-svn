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
*/ $ecFile = 'plugins/system/popup.php';

// Get data
$title = isset($_REQUEST['title']) ? $_REQUEST['title'] : 0;
$text = isset($_REQUEST['text']) ? $_REQUEST['text'] : 0;
$button = isset($_REQUEST['button']) ? $_REQUEST['button'] : 0;

$length = (strlen($text) / 30) * 15;
$height = $length + 150;

?>
<script language="JavaScript" type="text/javascript">
window.resizeTo(200,<?=$height ?>);
</script>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
<title><?=$title ?></title>
<strong><?=$title ?></strong>
<br />
<?=$text ?>
<br />
<br />
<center><input name="close" value="<?=$button ?>" type="button" onClick="window.close();" /></center>