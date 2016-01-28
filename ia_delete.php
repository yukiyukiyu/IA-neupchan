<?php
	$connect=mysql_connect("localhost", "root", "");
	if(!$connect)
	{
		die('Could not connect:' . mysql_error());
	}

	mysql_select_db("IA-database", $connect);

	mysql_query("DELETE FROM IAmoe WHERE 1");

	mysql_close($connect);

	header('Location: index.php');
?>
