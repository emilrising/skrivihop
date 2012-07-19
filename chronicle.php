<?php
include "i/head.php";

include "i/header.php";
?>
<img src="images/logosmallbeta.png" class="toplogo"> 

<br style="clear: both;">
<?
	$sql = "SELECT * FROM `chronicles` WHERE `id` = '".$_GET['id']."'";
	$res = mysql_query($sql);
	$rad = mysql_fetch_assoc($res);

?>

<h2><?=stripslashes($rad['name'])?></h2>
	    <p>
	    	<?=stripslashes($rad['longdesc'])?>
	    </p>
	    <p>
	    <a href="read.php?id=<?=$rad['id']?>" class="readmore">Läs krönika</a>
		</p>
		<div class="box info">			
			<?php
			$num_posts = mysql_num_rows(mysql_query("SELECT id FROM `post` WHERE `chronicleid` = '".$_GET['id']."'"));
			$num_comments = mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE `chronicleid` = '".$_GET['id']."'"));
			$latest_post = mysql_fetch_assoc(mysql_query("SELECT `createddate` FROM `post` WHERE `chronicleid` = '".$_GET['id']."' ORDER BY `createddate` LIMIT 1"));

			?>
			<div class="dotlight number">
				<?=($num_posts+$num_comments)?>
			</div>
			<div class="arrowup">
				<!-- -->
			</div>

	    Skapad av <a href="http://web.archive.org/web/20040611010738/http://pegasus.halsduk.net/pegasus.php?showplayer=1"><?=get_user_name($rad['createdby'])?></a>, <?=$rad['createddate']?><br>

	    	    Det finns <?=($num_posts+$num_comments)?> inlägg i den här krönikan, varav <?=$num_comments?> är kommentarer.<br>
	    	      Senaste inlägg skrevs <?=$latest_post['createddate']?>

	    	     <ul><h4>Kategorier</h4>
				<?php
				$sql = "SELECT * FROM `categoryrelations` WHERE `toid` = '".$_GET['id']."'";
				$res = mysql_query($sql);
				$num = mysql_num_rows($res);
				if($num > 0){
					while($cat = mysql_fetch_assoc($res)){
						echo "<li>".get_category_name($cat['categoryid'])."</li>";
					}
				}
				
				?>
	    	     </ul>

</div>

<?php
if($rad['createdby'] == $_SESSION['userid'])
edit_chronicle($_GET['id']);

include "i/footer.php";

include "i/foot.php";
?>