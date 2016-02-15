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
			Welcome, my master.<br />
			I'm	IA, your servant.<br />
			Is there anything I can do for you? 
		</p>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		Message: <input type="text" name="message" /><br />
		<input type="Submit" />
		</form>

	<?php

		$connect=mysql_connect('localhost', 'root', '');
		if(!$connect)
		{
			die('Could not connect: '. mysql_error());
		}
		mysql_select_db("IA-database", $connect);
		
		if(isset($_COOKIE['user'])==0)
		{
			$flag=0;
			$cresult=mysql_query("SELECT * FROM IAcookies");
			while($crow=mysql_fetch_array($cresult))
			{
				if($crow['state']==0)
				{
					$flag=1;
					$cookieid=$crow['id'];
					$cvalue=$crow['value'];
					setcookie("user", "$cvalue", time()+3600);
					mysql_query("UPDATE IAcookies SET state=1 WHERE id=$cookieid");
					break;
				}
			}
			if($flag==0)
			{
				echo "	<span style='color: red'>
							I'm sorry, there is no cookie available now.<br />
							Please wait for a moment.
						</span><br />
						";
			}
		}
		else
		{
			$flag=0;
			$cresult=mysql_query("SELECT * FROM IAcookies");
			while($crow=mysql_fetch_array($cresult))
			{
				if($crow['value']==$_COOKIE["user"])
					$flag=1;
			}
			if($flag==0)
			{
				echo "	<span style='color: red'>
							I'm sorry, your cookie has been deleted. <br />
							If you want to get a new cookie, use this botton. <br />
							(And perhaps, you need to wait for the admin. _(:з」∠)_ )
						</span>
						";
				echo '	<form method="post" action="userQAQ.php">
						<input type="submit" value="QAQ" />
						</form>
						';
			}
		}

		session_start();
		if($_SESSION!=NULL)
		{
			if($_SESSION['admin']==1)
			{
				echo '	<p style="color: purple">
							My admin, you can use delete to clear all these words, and use 
						setcookies to administer the cookies of this webpage.
						<form method="post" action="ia_delete.php">
						<input type="submit" value="Delete" />
						</form>
						<form method="post" action="setcookie.php">
						<input type="submit" value="Setcookies" />
						</form>
						</p>
						';
				echo '	<form method="post" action="logout.php">
						<input type="submit" value="Log out" />
						</form>
						';
				if(isset($_COOKIE["user"]))
				{
					$cresult=mysql_query("SELECT * FROM IAcookies");
					while($crow=mysql_fetch_array($cresult))
						if($crow['value']==$_COOKIE["user"])
							if($crow['expire']==0)
							{
								echo '	<p style="color: purple">
											My admin, now you get a cookie: '.$_COOKIE['user'].' .
										</p>
										';
							}
				}
				echo "<br />";
			}
		}
		else 
		{
			echo '	<form method="post" action="login.php">
					<input type="submit" value="Log in" />
					</form>
					';
			if(isset($_COOKIE["user"]))
			{
				$cresult=mysql_query("SELECT * FROM IAcookies");
				while($crow=mysql_fetch_array($cresult))
					if($crow['value']==$_COOKIE["user"])
						if($crow['expire']==0)
						{
							echo '	<p style="color: purple">
										My master, now you get a cookie: '.$_COOKIE['user'].' .
									</p>
									';
						}
			}
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
						$flag=0;
						$cresult=mysql_query("SELECT * FROM IAcookies");
						while($crow=mysql_fetch_array($cresult))
						{
							if($crow['value']==$row['cookie']) $flag=1;
							if($crow['value']==$row['cookie']&&$crow['expire']==1)
							{
								if($row['state']==0)
								{
									echo '	<span style="color: grey">
												*ID: '.$row['cookie'].'
												<i>'.$row['date'].'</i>
											</span><br />
											';
									echo '	<span style="color: grey">
											'.$row['content'].'
											</span>
											';
									echo '	<form method="post" action="ia_delete_2.php"
												>
											<input type="submit" value="Delete" />
											<input type="hidden" value="'.$row['id'].'"
												name="id" />
											</form>		
											';
									echo '	<form method="post" action="mask.php">
											<input type="submit" value="Mask" />
											<input type="hidden" value="'.$row['id'].'"
												name="id" />	
											</form>
											';
									echo "<br />";
								}	
								else if($row['state']==1)
								{
									echo '	<span style="color: grey">
												*ID: '.$row['cookie'].'
												<i>'.$row['date'].'</i>
											</span><br />
											';
									echo '	<span style="color: red">
											'.$row['content'].'
											</span>
											';
									echo '	<form method="post" action="ia_delete_2.php"
												>
											<input type="submit" value="Delete" />
											<input type="hidden" value="'.$row['id'].'"
												name="id" />
											</form>
											';
									echo '	<form method="post" action="reinstate.php">
											<input type="submit" value="Reinstate" />
											<input type="hidden" value="'.$row['id'].'"
												name="id" />
											</form>
											';
									echo "<br />";
								}
							}
							else if($crow['value']==$row['cookie']&&$crow['expire']==0)
							{
								if($row['state']==0)
								{
									echo '	<span style="color: purple">
												*ID: '.$row['cookie'].'
											</span>
											';
									echo '	<i>
											'.$row['date'].'
											</i><br />
											';
									echo $row['content'];
									echo '	<form method="post" action="ia_delete_2.php"
												>
											<input type="submit" value="Delete" />
											<input type="hidden" value="'.$row['id'].'"
												name="id" />
											</form>		
											';
									echo '	<form method="post" action="mask.php">
											<input type="submit" value="Mask" />
											<input type="hidden" value="'.$row['id'].'"
												name="id" />	
											</form>
											';
									echo "<br />";
								}	
								else if($row['state']==1)
								{
									echo '	<span style="color: purple">
												*ID: '.$row['cookie'].'
											</span>
											';
									echo '	<i>
											'.$row['date'].'
											</i><br />
											';
									echo '	<span style="color: red">
											'.$row['content'].'
											</span>
											';
									echo '	<form method="post" action="ia_delete_2.php"
												>
											<input type="submit" value="Delete" />
											<input type="hidden" value="'.$row['id'].'"
												name="id" />
											</form>
											';
									echo '	<form method="post" action="reinstate.php">
											<input type="submit" value="Reinstate" />
											<input type="hidden" value="'.$row['id'].'"
												name="id" />
											</form>
											';
									echo "<br />";
								}
							}
						}
						if($flag==0)
						{
							if($row['state']==0)
							{
								echo '	<span style="color: grey">
											*ID: '.$row['cookie'].'  
										<i>'.$row['date'].'</i>  (deleted)
										</span><br />
										';
								echo '	<span style="color: grey">
										'.$row['content'].'
										</span>
										';
								echo '	<form method="post" action="ia_delete_2.php"
											>
										<input type="submit" value="Delete" />
										<input type="hidden" value="'.$row['id'].'"
											name="id" />
										</form>		
										';
								echo '	<form method="post" action="mask.php">
										<input type="submit" value="Mask" />
										<input type="hidden" value="'.$row['id'].'"
											name="id" />	
										</form>
										';
								echo "<br />";
							}	
							else if($row['state']==1)
							{
								echo '	<span style="color: grey">
											*ID: '.$row['cookie'].'
											<i>'.$row['date'].'</i>  (deleted)
										</span><br />
										';
								echo '	<span style="color: red">
										'.$row['content'].'
										</span>
										';
								echo '	<form method="post" action="ia_delete_2.php"
											>
										<input type="submit" value="Delete" />
										<input type="hidden" value="'.$row['id'].'"
											name="id" />
										</form>
										';
								echo '	<form method="post" action="reinstate.php">
										<input type="submit" value="Reinstate" />
										<input type="hidden" value="'.$row['id'].'"
											name="id" />
										</form>
										';
								echo "<br />";
							}
						}
					}
				}
				else if($row['state']==0)
				{
					$flag=0;
					$cresult=mysql_query("SELECT * FROM IAcookies");
					while($crow=mysql_fetch_array($cresult))
					{
						if($crow['value']==$row['cookie']) $flag=1;
						if($crow['value']==$row['cookie']&&$crow['expire']==1)
						{
							echo '	<span style="color: grey">
										*ID: '.$row['cookie'].'
										<i>'.$row['date'].'</i>
									</span><br />
									';
							echo '	<span style="color: grey">
									'.$row['content'].'
									</span>
									';
							echo "<br />";
						}
						else if($crow['value']==$row['cookie']&&$crow['expire']==0)
						{
							echo '	<span style="color: purple">
										*ID: '.$row['cookie'].'
									</span>
									';
							echo '	<i>
									'.$row['date'].'
									</i><br />
									';
							echo $row['content'];
							echo "<br />";
						}
					}
					if($flag==0)
					{
							echo '	<span style="color: grey">
										*ID: '.$row['cookie'].'
										<i>'.$row['date'].'</i>  (deleted)
									</span><br />
									';
							echo '	<span style="color: grey">
									'.$row['content'].'
									</span>
									';
							echo "<br />";
					}
				}
			}
		}

		if($_POST!=NULL)
		{
			$flag1=0;
			$flag2=0;
			if(isset($_COOKIE["user"]))
			{
				$cresult=mysql_query("SELECT * FROM IAcookies");
				while($crow=mysql_fetch_array($cresult))
				{
					if($crow['value']==$_COOKIE["user"])
					{
						$flag1=1;
						if($crow['expire']==0)
							$flag2=1;
					}
				}
				if($flag1==1&&$flag2==0)
				{
					echo "	<span style='color: red'>
								I'm sorry, your cookie has been expired.
							</span>
							";
				}
			}
			if(isset($_COOKIE["user"])&&$flag2==1)
			{

				$message=$_POST['message'];
				$message=addslashes($message);

				if(strlen($message)>50)
				{
					echo "	<p style='color: red'>
								I'm sorry, my master, the message is too long.
							</p>
							";
				}
				else if(strlen($message)==0)
				{
					echo "	<p style='color: red'>
								I'm sorry, my master, please input something before submitting.
							</p>
							";
				}
				else
				{
					$sql="INSERT INTO IAmoe (content, cookie) 
						VALUES ('$message', '".$_COOKIE['user']."')";
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
								if($_SESSION!=NULL&&$_SESSION['admin']==1)
								{
									$flag=0;
									$cresult=mysql_query("SELECT * FROM IAcookies");
									while($crow=mysql_fetch_array($cresult))
									{
										if($crow['value']==$row['cookie']) $flag=1;
										if($crow['value']==$row['cookie']&&$crow['expire']==1)
										{
											if($row['state']==0)
											{
												echo '	<span style="color: grey">
															*ID: '.$row['cookie'].'
															<i>'.$row['date'].'</i>
														</span><br />
														';
												echo '	<span style="color: grey">
														'.$row['content'].'
														</span>
														';
												echo '	<form method="post" action="ia_delete_2.php
															">
														<input type="submit" value="Delete" />
														<input type="hidden" value="'.$row['id'].'"
															name="id" />
														</form>		
														';
												echo '	<form method="post" action="mask.php">
														<input type="submit" value="Mask" />
														<input type="hidden" value="'.$row['id'].'"
															name="id" />	
														</form>
														';
												echo "<br />";
											}	
											else if($row['state']==1)
											{
												echo '	<span style="color: grey">
															*ID: '.$row['cookie'].'
															<i>'.$row['date'].'</i>
														</span><br />
														';
												echo '	<span style="color: red">
														'.$row['content'].'
														</span>
														';
												echo '	<form method="post" action="ia_delete_2.php
															">
														<input type="submit" value="Delete" />
														<input type="hidden" value="'.$row['id'].'"
															name="id" />
														</form>
														';
												echo '	<form method="post" action="reinstate.php">
														<input type="submit" value="Reinstate" />
														<input type="hidden" value="'.$row['id'].'"
															name="id" />
														</form>
														';
												echo "<br />";
											}
										}
										else if($crow['value']==$row['cookie']&&$crow['expire']==0)
										{
											if($row['state']==0)
											{
												echo '	<span style="color: purple">
															*ID: '.$row['cookie'].'
														</span>
														';
												echo '	<i>
														'.$row['date'].'
														</i><br />
														';
												echo $row['content'];
												echo '	<form method="post" action="ia_delete_2.php
															">
														<input type="submit" value="Delete" />
														<input type="hidden" value="'.$row['id'].'"
															name="id" />
														</form>		
														';
												echo '	<form method="post" action="mask.php">
														<input type="submit" value="Mask" />
														<input type="hidden" value="'.$row['id'].'"
															name="id" />	
														</form>
														';
												echo "<br />";
											}	
											else if($row['state']==1)
											{
												echo '	<span style="color: purple">
															*ID: '.$row['cookie'].'
														</span>
														';
												echo '	<i>
														'.$row['date'].'
														</i><br />
														';
												echo '	<span style="color: red">
														'.$row['content'].'
														</span>
														';
												echo '	<form method="post" action="ia_delete_2.php
															">
														<input type="submit" value="Delete" />
														<input type="hidden" value="'.$row['id'].'"
															name="id" />
														</form>
														';
												echo '	<form method="post" action="reinstate.php">
														<input type="submit" value="Reinstate" />
														<input type="hidden" value="'.$row['id'].'"
															name="id" />
														</form>
														';
												echo "<br />";
											}
										}
									}
									if($flag==0)
									{
										if($row['state']==0)
										{
											echo '	<span style="color: grey">
														*ID: '.$row['cookie'].'  
														<i>'.$row['date'].'</i>  (deleted)
													</span><br />
													';
											echo '	<span style="color: grey">
													'.$row['content'].'
													</span>
													';
											echo '	<form method="post" action="ia_delete_2.php">
													<input type="submit" value="Delete" />
													<input type="hidden" value="'.$row['id'].'"
														name="id" />
													</form>		
													';
											echo '	<form method="post" action="mask.php">
													<input type="submit" value="Mask" />
													<input type="hidden" value="'.$row['id'].'"
														name="id" />	
													</form>
													';
											echo "<br />";
										}	
										else if($row['state']==1)
										{
											echo '	<span style="color: grey">
														*ID: '.$row['cookie'].'  
														<i>'.$row['date'].'</i>  (deleted)
													</span><br />
													';
											echo '	<span style="color: red">
													'.$row['content'].'
													</span>
													';
											echo '	<form method="post" action="ia_delete_2.php">
													<input type="submit" value="Delete" />
													<input type="hidden" value="'.$row['id'].'"
														name="id" />
													</form>
													';
											echo '	<form method="post" action="reinstate.php">
													<input type="submit" value="Reinstate" />
													<input type="hidden" value="'.$row['id'].'"
														name="id" />
													</form>
													';
											echo "<br />";
										}
									}
								}
								else if($row['state']==0)
								{
									$flag=0;
									$cresult=mysql_query("SELECT * FROM IAcookies");
									while($crow=mysql_fetch_array($cresult))
									{
										if($crow['value']==$row['cookie']) $flag=1;
										if($crow['value']==$row['cookie']&&$crow['expire']==1)
										{
											echo '	<span style="color: grey">
														*ID: '.$row['cookie'].'
													<i>'.$row['date'].'</i>
													</span><br />
													';
											echo '	<span style="color: grey">
													'.$row['content'].'
													</span>
													';
											echo "<br />";
										}
										else if($crow['value']==$row['cookie']&&$crow['expire']==0)
										{
											echo '	<span style="color: purple">
														*ID: '.$row['cookie'].'
													</span>
													';
											echo '	<i>
													'.$row['date'].'
													</i><br />
													';
											echo $row['content'];
											echo "<br />";
										}
									}
									if($flag==0)
									{
											echo '	<span style="color: grey">
														*ID: '.$row['cookie'].'
														<i>'.$row['date'].'</i>  (deteled)
													</span><br />
													';
											echo '	<span style="color: grey">
													'.$row['content'].'
													</span>
													';
											echo "<br />";
									}
								}
							}
						}
					}
					else
					{
						echo "	<p style='color: red'>
									I'm sorry, my master. An error has occurred.
								</p>
								";
					}	
				}
			}
		}

		mysql_close($connect);

	?>

	</body>
</html>

