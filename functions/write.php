<?php

require_once('classes/action.php');

function do_write($latestpost=FALSE)
{
	global $currentUser;
	
	if($currentUser)
	{
	?>
		<div class="postfooter">

		<div class="dotlight heading">

			+

		</div>

		<div class="menu more">

			<div class="arrowup">

				<!-- -->

			</div>

			 <a id="write_click">Skriv</a> - <a id="comment_click">Kommentera</a> - <a id="block_click">Anmäl</a>

			<br style="clear: both;">

			<div class="box">

				<div class="arrowup" id="write_arrow" style="right: 425px;">

					<!-- -->

				</div>

				<form class="write" method="post">
					<input type="hidden" name="chronicle" value="<?=$_GET['id']?>">
					<input type="hidden" name="post" value="<?=$latestpost?>">

					<input type="radio" name="type" id="write" checked="checked" value="write">

					<label for="paragraph">Skriv</label>

					<input type="radio" name="type" id="comment" value="comment">

					<label for="comment">Kommentera</label>
					
					<input type="radio" name="type" id="block" value="block">

					<label for="comment">Anmälan</label>

					<textarea name="body"></textarea>

					<br>

					<input type="submit" name="submit" value="Skicka">

				</form>

				<br style="clear: both;">

			</div>

			<br style="clear: both;">

		</div>

		<br style="clear: both;">

	</div>

	<br style="clear: both;">

</div>
	
	
	
	<?
	}
}

function do_new_chronicle_simple()
{
	if(logged_in()){
	?>
<img src="images/ajax-loader.gif" class="loader">



					<input type="hidden" name="type" id="newchronicle" checked="checked" value="newchronicle">



					<label for="name">Krönikans namn:</label>
					<input type="text" name="name" placeholder="Krönikans namn"><br><br>
					<label for="shortdesc">Kort beskrivning:</label><br>
					<textarea name="shortdesc"></textarea><br>
					<label for="longdesc">Lång beskrivning:</label><br>
					<textarea name="longdesc"></textarea>

					<br>

					<input type="submit" name="submit">


	
	
	
	<?
	}
}

function do_new_char_simple()
{
	global $currentUser;
	
	if($currentUser)
	{
	?>
		<img src="images/ajax-loader.gif" class="loader">

					<input type="hidden" name="type" id="newchar" checked="checked" value="newchar">

					<label for="name">Karaktärens namn:</label>
					<input type="text" name="name" placeholder="Karaktärens namn"><br><br>
					<label for="longdesc">Beskrivning:</label><br>
					<textarea name="longdesc"></textarea>

					<br>

					<input type="submit" name="submit">
<?
	}
}

function edit_player()
{
	global $currentUser;
	
	if ($currentUser)
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
				<i><?= $errorMessage ?></i>
			</div>

			<br style="clear: both;">

		</div>

		<br style="clear: both;">

	</div>
	
<br style="clear: both;">
<br style="clear: both;">	
	
	<?
	}
}

function do_new_stuff()
{
	/* TODO Here we could simplify a lot by not actually using an AJAX call, instead generating the 
	 *      required forms inline similarly to how the links are generated.
	 *      Also, we might consider emitting the jQuery code to show/hide the forms when the links 
	 *      are clicked in this function as well.
	 */
	
	global $currentUser;
	
	if ($currentUser)
	{
		$create_action_link = function($type) { return Action::CreateActionLink($type); };
		
		?> 
		<div class="postfooter">

		<div class="dotlight heading">

			+

		</div>

		<div class="menu more">

			<div class="arrowup">

				<!-- -->

			</div>
			<?= join(" - ", array_map($create_action_link, func_get_args())); ?>
			<br style="clear: both;">

			<div class="box" >
				<div class="arrowup" id="do_new_arrow">

					<!-- -->

				</div>
				<form class="write" method="post" id="do_new_stuff">
				<img src="images/ajax-loader.gif" class="loader">
				</form>

			<br style="clear: both;">
			</div>

			<br style="clear: both;">

		</div>

		<br style="clear: both;">

	</div>
	
<br style="clear: both;">
<br style="clear: both;">	
<?
	}
}

function edit_chronicle($id)
{
	if(logged_in()){
		$sql = "SELECT * FROM `chronicles` WHERE id = '".$id."'";
		$res = mysql_query($sql);
		$chronicle = mysql_fetch_assoc($res);
	?>
		<div class="postfooter">

		<div class="dotlight heading">

			+

		</div>

		<div class="menu more">

			<div class="arrowup">

				<!-- -->

			</div>

			 <a>Ändra Krönika</a>

			<br style="clear: both;">

			<div class="box">

				<div class="arrowup">

					<!-- -->

				</div>

				<form class="write" method="post">



					<input type="hidden" name="type" id="editchronicle" checked="checked" value="editchronicle">


					<input type="hidden" name="chronicle" value="<?=$id?>">
					<label for="name">Krönikans namn:</label>
					<input type="text" name="name" value="<?=$chronicle['name']?>"><br><br>
					<label for="shortdesc">Kort beskrivning:</label><br>
					<textarea name="shortdesc"><?=br2nl($chronicle['shortdesc'])?></textarea><br>
					<label for="longdesc">Lång beskrivning:</label><br>
					<textarea name="longdesc"><?=br2nl($chronicle['longdesc'])?></textarea>
					<label for="q">Kategorier:</label><br>
					<input type="text" name="categories" id="categories">
					<br>

					<input type="submit" name="submit">

				</form>

				<br style="clear: both;">

			</div>

			<br style="clear: both;">

		</div>

		<br style="clear: both;">

	</div>

	<br style="clear: both;">

</div>
	
	
	
	<?
	}
}

function edit_post($id)
{
	global $currentUser;
	
	if ($currentUser)
	{
		$post = Post::getInstance($id);
	?>
		<div class="postfooter" style="position: relative; top: -30px; clear: both;">

		<div class="dotlight" id="heading<?=$post->id?>">
			+
		</div>

		<div class="menu" id="more<?=$post->id?>" style="display: none; clear: both;">
			<div class="arrowup" >
				<!-- -->
			</div>
			<?php
			if($post->creator()->isCurrentUser()){
			?>
			 <a class="change_a_post<?=$id?>" id="change_a_post_<?=$id?>" name="<?=$id?>">Ändra inlägg</a> - 
			<?php
			}
			?>
			<a class="comment_a_post<?=$id?>" id="comment_a_post_<?=$id?>" name="<?=$id?>">Kommentera</a> - <a id="block_a_post_<?=$id?>" class="block_a_post<?=$id?>" name="<?=$id?>">Anmäl</a>
			<br style="clear: both;">

			<div class="box">

				<div class="arrowup" id="arrow_up_<?=$id?>">
					<!-- -->
				</div>

				<form class="write" method="post" id="<?=$id?>">

				</form>

				<br style="clear: both;">

			</div>

			<br style="clear: both;">

		</div>
	</div>
<br style="clear: both;">
	
	<?
	}
}
function edit_post_simple($id)
{
	global $currentUser;
	if($currentUser)
	{
		$post = Post::getInstance($id);
	?>
<img src="images/ajax-loader.gif" class="loader">


					<input type="hidden" name="type" id="editpost" checked="checked" value="editpost">


					<input type="hidden" name="post" value="<?=$id?>">
					<textarea name="body"><?=br2nl($post->body)?></textarea>
					<br>
					<input type="submit" name="submit">
	<?
	}
}

function comment_post_simple($id)
{
	global $currentUser;
	
	if($currentUser)
	{
		$post = Post::getInstance($id);
	?>
<img src="images/ajax-loader.gif" class="loader">

					<input type="hidden" name="chronicle" value="<?=$post->chronicleid?>">
					<input type="hidden" name="post" value="<?=$id?>">
					<input type="radio" name="type" id="comment" value="comment" checked="checked">
					<textarea name="body"></textarea>
					<br>
					<input type="submit" name="submit">
	<?
	}
}

function block_post_simple($id)
{
	global $currentUser;
	
	if($currentUser)
	{
		$post = Post::getInstance($id);
	?>
<img src="images/ajax-loader.gif" class="loader">

					<input type="hidden" name="chronicle" value="<?=$post->chronicleid?>">
					<input type="hidden" name="post" value="<?=$id?>">
					<input type="radio" name="type" id="block" value="block" checked="checked">
					<textarea name="body"></textarea>
					<br>
					<input type="submit" name="submit">
	<?
	}
}
?>