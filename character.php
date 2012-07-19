<?php
include "i/head.php";

include "i/header.php";

$sql = "SELECT * FROM `characters` WHERE `id` = '".$_GET['id']."'";
$res = mysql_query($sql);
$char = mysql_fetch_assoc($res);
?>
<img src="images/logosmallbeta.png" class="toplogo"> 


<br style="clear: both;">

<h2><?=$char['name']?></h2>
	    <p>
	    	<?=$char['longdesc']?>
	    </p>
		<div class="box info">

			<div class="arrowup">
				<!-- -->
			</div>

	    Skapad av <a href="player.php?id=<?=$char['createdby']?>"><?=get_user_name($char['createdby'])?></a>, <?=$char['createddate']?><br>
<?php
/* todo:
	    	    <ul><h4>Aktiv i krönikor</h4>
	    	     	<li>
	    	     	test
	    	     	</li>
	    	     	<li>
	    	     	test2
	    	     	</li>
	    	     </ul>
	    	     
	    	     <ul><h4>Kategorier</h4>
	    	     	<li>
	    	     	diskussion
	    	     	</li>
	    	     	<li>
	    	     		meta
	    	     	</li>
	    	     </ul>
 * 
 */ ?>
</div>

<?php
if($char['createdby'] == $_SESSION['userid'])
edit_char($_GET['id']);

include "i/footer.php";

include "i/foot.php";
?>