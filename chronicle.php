<?php
include "i/head.php";
include "i/header.php";
require_once "classes/chronicle.php";
?>
<img src="images/logosmallbeta.png" class="toplogo"> 

<br style="clear: both;">
<?
	$chronicle = Chronicle::getInstance($_GET['id']);
	
	if ($chronicle)
	{
?>

<h2><?=$chronicle->name?></h2>
	    <p>
	    	<?=$chronicle->longdesc?>
	    </p>
	    <p>
	    <a href="read.php?id=<?=$chronicle->id?>" class="readmore">Läs krönika</a>
		</p>
		<div class="box info">
			<div class="dotlight number">
				<?=($chronicle->total_posts() + $chronicle->total_comments())?>
			</div>
			<div class="arrowup">
				<!-- -->
			</div>

	    Skapad av <?= $chronicle->creator()->url() ?>, <?= $chronicle->createddate ?><br>

	    	    Det finns <?=($chronicle->total_posts() + $chronicle->total_comments())?> inlägg i den här krönikan, varav <?=$chronicle->total_comments()?> är kommentarer.<br>
	    	    Senaste inlägg skrevs <?=$chronicle->last_post()->createddate?>

	    	     <ul><h4>Kategorier</h4>
				<?php
				foreach ($chronicle->enumerateCategories() as $category)
				{ ?>
					<li><?= $category->name ?></li>					
			<?	}
				
				?>
	    	     </ul>
</div>

<?php
if($rad['createdby'] == $_SESSION['userid'])
edit_chronicle($_GET['id']);

}
else 
{ ?>
	<h4>Det är väldigt sorgligt</h4>
	<p>Men vi kunde inte hitta den här krönikan.</p> <?		
}
include "i/footer.php";
include "i/foot.php";
?>