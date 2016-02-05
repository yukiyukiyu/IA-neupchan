<?php

	$connect=mysql_connect("localhost", "root", "");
	if(!$connect)
	{
		die('Could not connect:' . mysql_error());
	}

	mysql_select_db("IA-database", $connect);

	$maskid=$_POST['id'];
	mysql_query("UPDATE IAmoe SET state=1 WHERE id=$maskid");

	mysql_close($connect);

	header('Location: index.php');

?>
