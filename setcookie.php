<html>
	<body>

		<p>
			<img src="8.jpeg" width="300" height="429" />
		</p>
		<p style="color: purple">
			My admin, please input the number of cookies you need.
		</p>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		Number: <input type="text" name="number" /><br>
		<input type="Submit" />
		</form>
		<form method="post" action="index.php">
		<input type="submit" value="Back" />
		</form>

	<?php
		
		$connect=mysql_connect('localhost', 'root', '');
		if(!$connect)
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("IA-database", $connect);

		if($_POST!=NULL)
		{
			$number=$_POST['number'];
			$number=addslashes($number);

			if(is_numeric($number))
			{
				if($number>1000)
				{
					echo "	<p style='color: red'>
								I'm sorry, my admin, the number is too large.
							</p>
							";
				}
				else if($number==0)
				{
					echo "	<p style='color: red'>
								I'm sorry, my admin, please input the number you need.
							</p>
							";
				}
				else
				{
					for($i=1; $i<=$number; $i++)
					{
						$cvalue=md5(rand(1, 100000));
						$cvalue=substr($cvalue, 0, 8);
						$sql="INSERT INTO IAcookies (value) VALUES ('$cvalue')";
						$result=mysql_query($sql, $connect);

						if(!$result)
						{
							echo "	<p style='color: red'>
										I'm sorry, my admin. An error has occurred.
									</p>
									";
						}
					}
					if($result)
					{
						echo "	<p style='color: purple'>
									My admin, ".$number." cookies have been added successfully.
								</p>
								";
					}
				}
			}
			else
			{
				echo "	<p style='color: red'>
							I'm sorry, my admin, your input is illegal. <br />
							You need to give me a number, please. (,,•́ . •̀,,) 
						</p>
						";
			}
		}

		$num_cookies=0;
		$new_result=mysql_query("SELECT * FROM IAcookies");
		while(mysql_fetch_array($new_result))
		{
			$num_cookies++;
		}
		if($num_cookies==0)
		{
			echo "	<p style='color: purple'>
						My admin, there is no cookie now.
					</p>
					";
		}
		else if($num_cookies==1)
		{
			echo "	<p style='color: purple'>
						My admin, there is only 1 cookie now.
					</p>
					";
			$new_result=mysql_query("SELECT * FROM IAcookies");
			while($row=mysql_fetch_array($new_result))
			{
				if($row['state']==1)
				{
					if($row['expire']==0)
					{
						echo '	<span style="color: purple">
									* '.$row['value'].'  (used)
								</span>
								';
						echo '	<form method="post" action="expire.php">
								<input type="submit" value="Expire" />
								<input type="hidden" value="'.$row['id'].'" name="id" />
								</form>
								';
					}
					else
					{
						echo '	<span style="color: red">
									* '.$row['value'].'  (expired)
								</span>
								';
						echo '	<form method="post" action="cookie_delete.php">
								<input type="submit" value="Delete" />
								<input type="hidden" value="'.$row['id'].'" name="id" />
								</form>
								';
					}
				}
				else
				{
					echo '	<span style="color: fuchsia">
								** '.$row['value'].'
							</span>
							';
					echo "<br />";
				}
			}
		}
		else
		{
			echo "	<p style='color: purple'>
						My admin, there are ".$num_cookies." cookies now.
					</p>
					";
			$new_result=mysql_query("SELECT * FROM IAcookies");
			while($row=mysql_fetch_array($new_result))
			{
				if($row['state']==1)
				{
					if($row['expire']==0)
					{
						echo '	<span style="color: purple">
									* '.$row['value'].'  (used)
								</span>
								';
						echo '	<form method="post" action="expire.php">
								<input type="submit" value="Expire" />
								<input type="hidden" value="'.$row['id'].'" name="id" />
								</form>
								';
					}
					else
					{
						echo '	<span style="color: red">
									* '.$row['value'].'  (expired)
								</span>
								';
						echo '	<form method="post" action="cookie_delete.php">
								<input type="submit" value="Delete" />
								<input type="hidden" value="'.$row['id'].'" name="id" />
								</form>
								';
					}
				}
				else
				{
					echo '	<span style="color: fuchsia">
								** '.$row['value'].'
							</span>
							';
					echo "<br />";
				}
			}
		}

		mysql_close($connect);

	?>

	</body>
</html>
