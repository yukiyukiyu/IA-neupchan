<?php

	$connect=mysql_connect("localhost", "root", "");
	if(!$connect)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db("IA-database", $connect);

	$expireid=$_POST['id'];
	mysql_query("UPDATE IAcookies SET expire=1 WHERE id=$expireid");

	mysql_close($connect);

	header('Location: setcookie.php');

?>
