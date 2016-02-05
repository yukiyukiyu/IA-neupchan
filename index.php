<!DOCTYPE html>
<html>
	<body>
		
		<p>
			<img src="1.jpg" width="330" height="480" border="0" usemap="#princessmap" />
			<map name="princessmap">
				<area shape="circle" coords="128, 307, 10" href="ia_song.html"
					onfocus="blur(this);" />
				<area shape="circle" coords="204, 204, 33" href="biubiubiu.html"
					onfocus="blur(this);" />
				<area shape="rect" coords="0, 0, 114, 187" href="http://www.bilibili.com/"
					onfocus="blur(this);" />
			</map>
		</p>
		<p style="color: purple">
			Welcome, my master.<br>
			I'm	IA, your servant.<br>
			Is there anything I can do for you? 
		</p>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		Message: <input type="text" name="message"><br>
		<input type="Submit">
		</form>

	<?php

		$connect=mysql_connect('localhost', 'root', '');
		if(!$connect)
		{
			die('Could not connect: '. mysql_error());
		}
		mysql_select_db("IA-database", $connect);
		
		session_start();
		if($_SESSION!=NULL)
		{
			if($_SESSION['admin']==1)
			{
				echo '	<p style="color: purple">
								My admin, you can use delete to clear all these words.
						<form method="post" action="ia_delete.php">
						<input type="submit" value="Delete">
						</form>
						</p>
						';
				echo '	<form method="post" action="logout.php">
						<input type="submit" value="Log out">
						</form>
						';
				echo "<br />";
			}
		}
		else 
		{
			echo '	<form method="post" action="login.php">
					<input type="submit" value="Log in">
					</form>
					';
			echo "<br />";
		}

		if($_POST==NULL)
		{
			$new_result=mysql_query("SELECT * FROM IAmoe");
			while($row=mysql_fetch_array($new_result))
			{
				if($_SESSION!=NULL)
				{
					if($_SESSION['admin']==1)
					{
						if($row['state']==0)
						{
							echo $row['content'];
							echo '	<form method="post" action="ia_delete_2.php"
										>
									<input type="submit" value="Delete">
									<input type="hidden" value="'.$row['id'].'"
										name="id">
									</form>		
									';
							echo '	<form method="post" action="mask.php">
									<input type="submit" value="Mask">
									<input type="hidden" value="'.$row['id'].'"
										name="id">	
									</form>
									';
						}
						else if($row['state']==1)
						{
							echo '	<span style="color: red">
									'.$row['content'].'
									</span>
									';
							echo '	<form method="post" action="ia_delete_2.php"
										>
									<input type="submit" value="Delete">
									<input type="hidden" value="'.$row['id'].'"
										name="id">
									</form>
									';
							echo '	<form method="post" action="reinstate.php">
									<input type="submit" value="Reinstate">
									<input type="hidden" value="'.$row['id'].'"
										name="id">
									</form>
									';
						}
					}
				}
				else if($row['state']==0)
					echo $row['content'];
				echo "<br />";
			}
		}

		if($_POST!=NULL)
		{
			$message=$_POST['message'];
			$message=addslashes($message);

			if(strlen($message)>50)
			{
				echo "I'm sorry, my master, the message is too long.";
			}
			else
			{
				$sql="INSERT INTO IAmoe (content) VALUES ('$message')";
				$result=mysql_query($sql, $connect);

				if($result)
				{

					if(strcmp($message, "shuzu!")==0)
					{
						echo "A gift for you ~";
						echo "<br>";
						echo '<embed height="415" width="544" quality="high" allowfullscreen="true" type="application/x-shockwave-flash" src="http://static.hdslb.com/miniloader.swf" flashvars="aid=1479974&page=1" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"></embed>';
					}

					else
					{
						$new_result=mysql_query("SELECT * FROM IAmoe");
						while($row=mysql_fetch_array($new_result))
						{
							if($_SESSION!=NULL)
							{
								if($_SESSION['admin']==1)
								{
									if($row['state']==0)
									{
										echo $row['content'];
										echo '	<form method="post" action="ia_delete_2.php"
													>
												<input type="submit" value="Delete">
												<input type="hidden" value="'.$row['id'].'"
													name="id">
												</form>		
												';
										echo '	<form method="post" action="mask.php">
												<input type="submit" value="Mask">
												<input type="hidden" value="'.$row['id'].'"
													name="id">	
												</form>
												';
									}
									else if($row['state']==1)
									{
										echo '	<span style="color: red">
												'.$row['content'].'
												</span>
												';
										echo '	<form method="post" action="ia_delete_2.php"
													>
												<input type="submit" value="Delete">
												<input type="hidden" value="'.$row['id'].'"
													name="id">
												</form>
												';
										echo '	<form method="post" action="reinstate.php">
												<input type="submit" value="Reinstate">
												<input type="hidden" value="'.$row['id'].'"
													name="id">
												</form>
												';
									}
								}
							}
							else if($row['state']==0)
								echo $row['content'];
							echo "<br />";
						}
					}
				}
				else
				{
					echo "I'm sorry, my master. An error has occurred.";
				}
				mysql_close($connect);
			}
		}
	?>

	</body>
</html>

