<?php

	$connect=mysql_connect("localhost", "root", "");
	if(!$connect)
	{
		die('Could not connect:' . mysql_error());
	}

	mysql_select_db("IA-database", $connect);

	$reinstateid=$_POST['id'];
	mysql_query("UPDATE IAmoe SET state=0 WHERE id=$reinstateid");

	mysql_close($connect);

	header('Location: index.php');

?>
