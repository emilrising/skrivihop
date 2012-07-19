<?php
include "shead.php";

function show_writer($id){
	if(logged_in()){
		$sql = "SELECT `createdby`,`createddate`,`editeddate` FROM `post` WHERE id = '".$id."'";
		$res = mysql_query($sql);
		$rad = mysql_fetch_assoc($res);
		?>
		<div class="box info">
			<div class="arrowup">
				<!-- -->
			</div>
			<img src="images/ajax-loader.gif" class="loader">
			<?php
			if($rad['createddate'] > $_SESSION['lastlogin'] OR $rad['editeddate'] > $_SESSION['lastlogin']){
				echo "<img src='images/dotlight8.png' class='new_post'>";
			}
			?>
			 Skrivet av <a href="player.php?id=<?=$rad['createdby']?>"><?=get_user_name($rad['createdby'])?></a>, <?=$rad['createddate']?> <?=($rad['editeddate'] != NULL ? ", ".$rad['editeddate'] : "")?><br>
		</div>

<script>


  //toggle the componenet with class msg_body
  $("#heading<?=$id?>").click(function()
  {
    $(this).next("#more<?=$id?>").slideToggle(500);
  });
  <?php
  if($rad['createdby'] == $_SESSION['userid']){
	overpre($rad);
  ?>

  $(".change_a_post<?=$id?>").click(function () {
 		$('#arrow_up_'+$(this).attr('name')+'').css('right','380px');
		    $('#'+$(this).attr('name')+'').load('functions/do_new_things_ajax.php?do=editpost&postid='+$(this).attr('name'));
  });
  $(".comment_a_post<?=$id?>").click(function () {
	  		$('#arrow_up_'+$(this).attr('name')+'').css('right','244px');
		    $('#'+$(this).attr('name')+'').load('functions/do_new_things_ajax.php?do=commentpost&postid='+$(this).attr('name'));
   });
  $(".block_a_post<?=$id?>").click(function () {
	  		$('#arrow_up_'+$(this).attr('name')+'').css('right','117px');
		    $('#'+$(this).attr('name')+'').load('functions/do_new_things_ajax.php?do=blockpost&postid='+$(this).attr('name'));
  });

  <?php
  }
  else{
  	?>

  $(".comment_a_post<?=$id?>").click(function () {
	  		$('#arrow_up_'+$(this).attr('name')+'').css('right','380px');
		    $('#'+$(this).attr('name')+'').load('functions/do_new_things_ajax.php?do=commentpost&postid='+$(this).attr('name'));
   });
  $(".block_a_post<?=$id?>").click(function () {
	  		$('#arrow_up_'+$(this).attr('name')+'').css('right','272px');
		    $('#'+$(this).attr('name')+'').load('functions/do_new_things_ajax.php?do=blockpost&postid='+$(this).attr('name'));
  });

	<?php
  }
  ?>
   		

</script>


		<?

			edit_post($id);
		

	}
}

function show_comments($id){
	if(logged_in()){
		$sql = "SELECT * FROM `comments` WHERE postid = '".$id."'";
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		$i = 0;
		if($num > 0){
		?>
		<div class="box">
		<div class="dotlight number">
			<?=$num?>
		</div>
		<div class="arrowup">
			<!-- -->
		</div>
		<?php
		while($rad = mysql_fetch_assoc($res)){
			$i++;
		?>
			<div class="comment">
				<div class="dotlight">
					<?=$i?>
				</div>
				<img src="images/ajax-loader.gif" class="loader">
				<p>
					<span class="who"><a href="player.php?id=<?=$rad['createdby']?>"><?=get_user_name($rad['createdby'])?></a> - <?=$rad['createddate']?></span>
					<br />
					<?=stripslashes($rad['body'])?>	
				</p>
			</div>
		<?php
		}
		?>
		</div>
		<?
		}
	}
}

?>