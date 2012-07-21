<?php
include "i/head.php";
include "i/header.php";
require_once "classes/character.php";

$character = Character::build_object($_GET['id']);

if ($character)
{
?>
<img src="images/logosmallbeta.png" class="toplogo"> 


<br style="clear: both;">

<h2><?=$character->name?></h2>
	    <p>
	    	<?=$character->longdesc?>
	    </p>
		<div class="box info">

			<div class="arrowup">
				<!-- -->
			</div>

	    Skapad av <?= $character->creator()->url() ?>, <?=$character->createddate?><br>
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

} 
else 
{
		?>
			<h4>Det är väldigt sorgligt</h4>
				<p>
					Men vi kunde inte hitta den karaktär du letar efter.
				</p>
			<?php
	}


include "i/footer.php";

include "i/foot.php";
?>