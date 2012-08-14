<?php
include "i/head.php";
include "i/header.php";
require_once "classes/character.php";

$character = Character::getInstance($_GET['id']);

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
	if ($character->createdby == $currentUser->id)
	{ ?>
		<div class="postfooter">

		<div class="dotlight heading">

			+

		</div>

		<div class="menu more">

			<div class="arrowup">

				<!-- -->

			</div>

			 <a>Ändra Karaktär</a>

			<br style="clear: both;">

			<div class="box">

				<div class="arrowup">

					<!-- -->

				</div>

				<form class="write" method="post">
					<input type="hidden" name="char" value="<?= $character->id ?>">
					<label for="name">Karaktärens namn:</label>
					<input type="text" name="name" value="<?= $character->name ?>"><br><br>
					<label for="longdesc">Beskrivning:</label><br>
					<textarea name="longdesc"><?= br2nl($character->longdesc) ?></textarea>

					<br>

					<input type="submit" name="submit">

				</form>

				<br style="clear: both;">

			</div>

			<br style="clear: both;">

		</div>

		<br style="clear: both;">

	</div>
<?	}
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