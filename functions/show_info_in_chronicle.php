<?php
require_once "i/shead.php";
require_once "classes/post.php";

function show_writer($id)
{
	global $currentUser;
	global $pdo;
	
	if ($currentUser)
	{
		$post = Post::getInstance($id);
		
		if ($post)
		{
		?>
		<div class="box info">
			<div class="arrowup">
				<!-- -->
			</div>
			<?php
			if ($post->createddate > $currentUser->lastlogin || $post->editeddate > $currentUser->lastlogin)
			{
				echo "<img src='images/dotlight8.png' class='new_post'>";
			}
			?>
			 Skrivet av <?= $post->creator()->url() ?>, <?= $post->editeddate ?><br>
		</div>
<script>

  //toggle the componenet with class msg_body
  $("#heading<?=$id?>").click(function()
  {
    $(this).next("#more<?=$id?>").slideToggle(500);
  });
  <?php
	if($post->createdby == $currentUser->id)
	{

  ?>

  $(".change_a_post<?=$id?>").click(function () {
 		$('#arrow_up_'+$(this).attr('name')+'').css('right','380px');
		    $('#'+$(this).attr('name')+'').load('ajax.php?action=editpost&id='+$(this).attr('name'));
  });
  $(".comment_a_post<?=$id?>").click(function () {
	  		$('#arrow_up_'+$(this).attr('name')+'').css('right','244px');
		    $('#'+$(this).attr('name')+'').load('ajax.php?action=commentpost&id='+$(this).attr('name'));
   });
  $(".block_a_post<?=$id?>").click(function () {
	  		$('#arrow_up_'+$(this).attr('name')+'').css('right','117px');
		    $('#'+$(this).attr('name')+'').load('ajax.php?action=blockpost&id='+$(this).attr('name'));
  });

  <?php
		}
	}
	else
	{
  	?>

  $(".comment_a_post<?=$id?>").click(function () {
	  		$('#arrow_up_'+$(this).attr('name')+'').css('right','380px');
		    $('#'+$(this).attr('name')+'').load('ajax.php?action=commentpost&id='+$(this).attr('name'));
   });
  $(".block_a_post<?=$id?>").click(function () {
	  		$('#arrow_up_'+$(this).attr('name')+'').css('right','272px');
		    $('#'+$(this).attr('name')+'').load('ajax.php?action=blockpost&id='+$(this).attr('name'));
  });

	<?php
  }
  ?>
</script>
<?
			edit_post($id);
	}
}

function show_comments($id)
{
		$post = Post::getInstance($id);
				
		if ($post)
		{
			$num = $post->countComments();
			if ($num > 0)
			{
		?>
		<div class="box">
		<div class="dotlight number">
			<?=$num?>
		</div>
		<div class="arrowup">
			<!-- -->
		</div>
		<?php
				foreach ( $post->enumerateComments() as $comment)
				{
					$i++;
		?>
			<div class="comment">
				<div class="dotlight">
					<?=$i?>
				</div>
				<p>
					<span class="who"><?= $comment->creator()->url() ?> - <?= $comment->createddate ?></span>
					<br />
					<?= $comment->body ?>
				</p>
			</div>
		<?php
				}
		?>
		</div>
<?php
		}
	}
}

?>