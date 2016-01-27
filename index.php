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
		<input type="Submit"><br>
		</form>

	<?php

		$connect=mysql_connect('localhost', 'root', '');
		if(!$connect)
		{
			die('Could not connect: '. mysql_error());
		}
		mysql_select_db("IA-database", $connect);

		if($_POST==NULL)
		{
			$new_result=mysql_query("SELECT * FROM IAmoe");
			while($row=mysql_fetch_array($new_result))
			{
				echo $row['content'];
				echo "<br />";
			}
		}

		if($_POST!=NULL)
		{
			$message=$_POST['message'];
			$message=addslashes($message);

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
	?>

	</body>
</html>

