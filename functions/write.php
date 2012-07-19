<?php

function do_write($latestpost=FALSE){
	if(logged_in()){
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
function do_new_chronicle(){
	if(logged_in()){
	?>
		<div class="postfooter">

		<div class="dotlight heading">

			+

		</div>

		<div class="menu more">

			<div class="arrowup">

				<!-- -->

			</div>

			 <a>Ny Krönika</a>

			<br style="clear: both;">

			<div class="box">

				<div class="arrowup">

					<!-- -->

				</div>

				<form class="write" method="post">



					<input type="hidden" name="type" id="newchronicle" checked="checked" value="newchronicle">



					<label for="name">Krönikans namn:</label>
					<input type="text" name="name" placeholder="Krönikans namn"><br><br>
					<label for="shortdesc">Kort beskrivning:</label><br>
					<textarea name="shortdesc"></textarea><br>
					<label for="longdesc">Lång beskrivning:</label><br>
					<textarea name="longdesc"></textarea>

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
function do_new_chronicle_simple(){
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
function do_new_char(){
	if(logged_in()){
	?>
		<div class="postfooter">

		<div class="dotlight heading">

			+

		</div>

		<div class="menu more">

			<div class="arrowup">

				<!-- -->

			</div>

			 <a>Ny Karaktär</a>

			<br style="clear: both;">

			<div class="box">

				<div class="arrowup">

					<!-- -->

				</div>

				<form class="write" method="post">



					<input type="hidden" name="type" id="newchar" checked="checked" value="newchar">



					<label for="name">Karaktärens namn:</label>
					<input type="text" name="name" placeholder="Karaktärens namn"><br><br>
					<label for="longdesc">Beskrivning:</label><br>
					<textarea name="longdesc"></textarea>

					<br>

					<input type="submit" name="submit">

				</form>

				<br style="clear: both;">

			</div>

			<br style="clear: both;">

		</div>

		<br style="clear: both;">

	</div>

	
	
	
	<?
	}
}
function do_new_char_simple(){
	if(logged_in()){
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
function edit_player($id){
		if(logged_in()){
			
	$sql = "SELECT * FROM `users` WHERE id = '".$id."'";
	$res = mysql_query($sql);
	$usr = mysql_fetch_assoc($res);
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



					<input type="hidden" name="type" id="editplayer" checked="checked" value="editplayer">
					<input type="hidden" name="player" id="editplayer" value="<?=$usr['id']?>">



					<label for="name">Ditt Namn:</label>
					<input type="text" name="name" value="<?=$usr['name']?>"><br><br>
					<label for="avatar">Avatar:</label>
					<input type="text" name="avatar" value="<?=$usr['avatar']?>"><br><br>
					<label for="longdesc">Beskrivning:</label><br>
					<textarea name="description"><?=br2nl($usr['description'])?></textarea>
					<br>
					<div id="edit-player">
					<a href="#" onclick="$('#edit-player').load('functions/newpassword.php?newpasswordplease=true&username=<?=$_SESSION[username]?>');">få ett nytt lösenord</a>
					</div>
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
<br style="clear: both;">	
	
	
	<?
	}
}
function do_new_stuff(){
	if(logged_in()){
		?> 
		<div class="postfooter">

		<div class="dotlight heading">

			+

		</div>

		<div class="menu more">

			<div class="arrowup">

				<!-- -->

			</div>

			 	<a  id="do_new_char">Ny Karaktär</a> - <a  id="do_new_chronicle" >Ny Krönika</a> 

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
function edit_chronicle($id){
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
function edit_char($id){
	if(logged_in()){
		$sql = "SELECT * FROM `characters` WHERE id = '".$id."'";
		$res = mysql_query($sql);
		$char = mysql_fetch_assoc($res);
	?>
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



					<input type="hidden" name="type" id="editchar" checked="checked" value="editchar">


					<input type="hidden" name="char" value="<?=$id?>">
					<label for="name">Karaktärens namn:</label>
					<input type="text" name="name" value="<?=$char['name']?>"><br><br>
					<label for="longdesc">Beskrivning:</label><br>
					<textarea name="longdesc"><?=br2nl($char['longdesc'])?></textarea>

					<br>

					<input type="submit" name="submit">

				</form>

				<br style="clear: both;">

			</div>

			<br style="clear: both;">

		</div>

		<br style="clear: both;">

	</div>

	
	
	
	<?
	}
}
function edit_post($id){
	if(logged_in()){

		$sql = "SELECT * FROM `post` WHERE `id` = '".$id."'";
		$res = mysql_query($sql);
		$post = mysql_fetch_assoc($res);
	?>
		<div class="postfooter" style="position: relative; top: -30px; clear: both;">

		<div class="dotlight" id="heading<?=$post['id']?>">

			+

		</div>

		<div class="menu" id="more<?=$post['id']?>" style="display: none; clear: both;">
			<div class="arrowup" >

				<!-- -->

			</div>
			<?php
			if($post['createdby'] == $_SESSION['userid']){
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
function edit_post_simple($id){
	if(logged_in()){
		$sql = "SELECT * FROM `post` WHERE `id` = '".$id."'";
		$res = mysql_query($sql);
		$post = mysql_fetch_assoc($res);
	?>
<img src="images/ajax-loader.gif" class="loader">


					<input type="hidden" name="type" id="editpost" checked="checked" value="editpost">


					<input type="hidden" name="post" value="<?=$id?>">
					<textarea name="body"><?=br2nl($post['body'])?></textarea>

					<br>

					<input type="submit" name="submit">

	
	<?
	}
}
function comment_post_simple($id){
	if(logged_in()){
		$sql = "SELECT * FROM `post` WHERE `id` = '".$id."'";
		$res = mysql_query($sql);
		$post = mysql_fetch_assoc($res);
	?>
<img src="images/ajax-loader.gif" class="loader">





					<input type="hidden" name="chronicle" value="<?=$post['chronicleid']?>">
					<input type="hidden" name="post" value="<?=$id?>">
					<input type="radio" name="type" id="comment" value="comment" checked="checked">
					<textarea name="body"></textarea>
					<br>
					<input type="submit" name="submit">

	
	<?
	}
}
function block_post_simple($id){
	if(logged_in()){
		$sql = "SELECT * FROM `post` WHERE `id` = '".$id."'";
		$res = mysql_query($sql);
		$post = mysql_fetch_assoc($res);
	?>
<img src="images/ajax-loader.gif" class="loader">

					<input type="hidden" name="chronicle" value="<?=$post['chronicleid']?>">
					<input type="hidden" name="post" value="<?=$id?>">
					<input type="radio" name="type" id="block" value="block" checked="checked">
					<textarea name="body"></textarea>
					<br>
					<input type="submit" name="submit">

	
	<?
	}
}
?>