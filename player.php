<?php

include "i/head.php";
include "i/header.php";

require_once('classes/action.php');
require_once("classes/user.php");

$user = User::getInstance($_GET['id']);

if ($user)
{
?>

<img src="images/logosmallbeta.png" class="toplogo"> 

<br style="clear: both;">

<h2><?=$user->name?><img src="<?=(strlen($user->avatar) > 2 ? $user->avatar : "images/johndoe.png")?>" class="avatar big"></h2>

	    <p>
	    	<?= $user->formatted_description() ?>
		</p>
		<p>
<?php
if ($user->isCurrentUser())
{
?>
	<div class="postfooter">
		<div class="dotlight heading">
			+
		</div>

		<div class="menu more" >
			<div class="arrowup">
				<!-- -->
			</div>
			 <a id="changewriter_click">Författarbeskrivning</a>
			<br style="clear: both;">
			<div class="box">
				<div class="arrowup" id="edit_writer">
					<!-- -->
				</div>
				<form class="write" method="post">
					<input type="hidden" name="type" value="editplayer">
					<label for="name">Ditt Namn:</label>
					<input type="text" name="name" value="<?= $currentUser->name ?>"><br><br>
					<label for="avatar">Avatar:</label>
					<input type="text" name="avatar" value="<?= $currentUser->avatar ?>"><br><br>
					<label for="longdesc">Beskrivning:</label><br>
					<textarea name="description"><?= $currentUser->description ?></textarea>
					<br>
					<input type="submit" name="submit" value="Ändra">
				</form>

				<br style="clear: both;">
				<div class="error"><?= $errorMessage ?></div>
			</div>
			<br style="clear: both;">
		</div>
		<br style="clear: both;">
	</div>	
<?
}
?>
</p>
<?php
$latest = $user->latestpost();

if ($latest)
{
?>
	<div class="box">
		<div class="arrowup">
			<!-- -->
		</div>
		
		<h2>Senaste inlägg</h2>
		
		<p>"<i><?=$latest->body?></i>"</p>
				
		<p class="byuser">
			Från krönikan <?= $latest->chronicle()->url() ?>
		</p>
			
		<br style="clear:both;">
			
	</div>
<?
}
?>
<div class="box info">
			<div class="arrowup">
				<!-- -->
			</div>
Syntes senast: <?= $user->lastlogin ?>
<?php
if($user->isCurrentUser())
{
	echo "<ul><h4>Andra författares inlägg sen din senaste inloggning</h4>";

   	foreach ($user->enumerateChronicles() as $chronicle)
	{
?>
		<li><?= $chronicle->url() ?>: <?= $chronicle->countPosts($user->lastlogin) ?> poster, <?= $chronicle->countComments($user->lastlogin) ?> kommentarer</li>
<?
	}
	echo "</ul>";	
}


?>
</div>
<div class="box info">

			<div class="arrowup">
				<!-- -->
			</div>	 

	    	    <ul><h4>Karaktärer</h4>
	    	    	<?php
	    	    	
	    	    	foreach ($user->enumerateCharacters() as $character)
					{
						?>
						<li><?= $character->url() ?></li>
						<?
					}
					
	    	    	?>
	    	     </ul>
	    	    <ul><h4>Krönikor</h4>
	    	    	<?php

	    	    	foreach ($user->enumerateChronicles() as $chronicle)
					{
						?>
						<li><?= $chronicle->url() ?></li>
						<?
					}
	    	    	
	    	    	?>

	    	     </ul>
    	     
</div>
<div style="position: relative; top: -28px;" >
<?php
if($user->isCurrentUser())
{
	do_new_stuff(Action::NewCharacter, Action::NewChronicle);
}
?>	
</div>
<br style="clear: both;">

<br>
<?php

}
else {
	?>
	<h4>Det är väldigt sorgligt</h4>
	<p>Men vi kunde inte hitta den här författaren.</p> <?		
}
include "i/footer.php";
include "i/foot.php";
?>
