<!DOCTYPE html>
<html>
	<body>
		
		<p>
			<a href="ia_song.html"><img src="1.jpg" width="330" height="480"/></a>
		</p><br>
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
			$message = $_POST['message'];
			if(strcmp($message, "shuzu")==0)
			{
				echo "A gift for you ~";
				echo "<br>";
				echo '<embed height="415" width="544" quality="high" allowfullscreen="true" type="application/x-shockwave-flash" src="http://static.hdslb.com/miniloader.swf" flashvars="aid=1479974&page=1" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"></embed>';
			}
			elseif(strlen($message)>0)
			{
				echo $message;
			}
		?>

	</body>
</html>

