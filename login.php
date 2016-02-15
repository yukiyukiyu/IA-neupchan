<html>
	<body>

		<p>
			<img src="5.jpeg" width="280" height="398" border="0" usemap="#surmap" />
			<map name="surmap">
				<area shape="circle" coords="140, 180, 10" href="surprise.php"
					onfocus="blur(this);" />
			</map>	
		</p>
		<p style="color: purple">
		Welcome, my admin.
		</p>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		Admin name:<input type="text" name="adminname"><br>
		Password:<input type="password" name="password"><br>
		<input type="submit">
		</form>

	<?php

		$connect=mysql_connect('localhost', 'root', '');
		if(!$connect)
		{
			die('Could not connect: '. mysql_error());
		}
		mysql_select_db("IA-database", $connect);

		mysql_close($connect);

		if($_POST!=NULL)
		{

			$adminname=$_POST['adminname'];
			$password=$_POST['password'];
			$adminname=addslashes($adminname);
			$password=addslashes($password);
			
			if(strcmp($adminname, "admin")==0&&strcmp($password, "root")==0)
			{
				session_start();
				$_SESSION['admin']=1;
				header('Location: index.php');
			}
			else echo "My master, please input correct admin name or password.";
		}

	?>

	</body>
</html>

