<?php
	include "i/head.php";
	include "i/header.php";
	echo '<img src="images/logosmallbeta.png" class="toplogo"> 
			<br style="clear: both;">';
	$sql_terms = "SELECT * FROM sitetexts WHERE name = 'termsandconditions'";
	$res_terms = mysql_query($sql_terms);
	$terms = mysql_fetch_assoc($res_terms);

	echo "<h1>".$terms['heading']."</h1>";
	echo "<p>".$terms['text']."</p>";
	
	include "i/footer.php";
	include "i/foot.php";
?>