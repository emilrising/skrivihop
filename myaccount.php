<?php

include "i/head.php";

include "i/header.php";



$sql = "SELECT * FROM users WHERE id='".$_GET['id']."'";
$res = mysql_query($sql);
$user = mysql_fetch_assoc($res);
?>
<img src="images/logosmallbeta.png" class="toplogo"> 

<br style="clear: both;">

<h2><?=$user[name]?><img src="<?=$user[avatar]?>" class="avatar big"></h2>

	    <p>
	    	<?=$user[description]?>
		</p>		

	<?=latest_post('user:'.$_GET['id'])?>


<div class="box info">

			<div class="arrowup">
				<!-- -->
			</div>	 

	    	    <ul><h4>Karaktärer</h4>
	    	    	<?php
	    	    	$sql = "SELECT `name`, `id` FROM `characters` WHERE `createdby` = '".$_GET['id']."'";
					$res = mysql_query($sql);
					while($rad = mysql_fetch_assoc($res)){
						?>
						<li><a href=""><?=$rad['name']?></a></li>
						<?
					}
	    	    	
	    	    	
	    	    	?>

	    	     </ul>
	    	     
</div>


<div class="box info">
			<div class="arrowup">
				<!-- -->
			</div>
Syntes senast: <?=$user[lastlogin]?>
</div>

<?php
include "i/footer.php";

include "i/foot.php";
?>
