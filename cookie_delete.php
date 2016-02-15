<?php

	$connect=mysql_connect('localhost', 'root', '');
	if(!$connect)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("IA-database", $connect);

	$deleteid=$_POST['id'];
	mysql_query("DELETE FROM IAcookies WHERE id=$deleteid");

	mysql_close($connect);

	header('Location: setcookie.php');

?>
