<form name="form1" method="post" action="crypt.php">
  <input name="password" type="text" id="password">
  <br>
  <input type="submit" name="Submit" value="Senden">
</form>
<?php
function ecCryptPassword($password)
{
	include ('../config.php');
	$key = $ecLocal['cryptKey'];
	echo 'Key: '.$key.'<br>';
	$data = crypt($password,$key);
	$hash = md5(($key ^ str_repeat(chr(0x5c), 64)) . pack('H*', md5(($key ^ str_repeat(chr(0x36), 64)). $data)));
	echo 'md5: '.md5($password).'<br>';
	echo 'Crypt: '.$data.'<br>';
	echo 'ecCrypt: '.$hash.'<br>';
}
ecCryptPassword($_REQUEST['password']);
?>