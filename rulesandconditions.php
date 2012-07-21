<?php
	include "i/head.php";
	include "i/header.php";
	
	require_once "classes/sitetext.php";
	
	echo '<img src="images/logosmallbeta.png" class="toplogo"> 
			<br style="clear: both;">';
			
	$terms = SiteText::getInstance('termsandconditions');

	echo "<h1>$terms->heading</h1>";
	echo "<p>$terms->text</p>";
	
	include "i/footer.php";
	include "i/foot.php";
?>