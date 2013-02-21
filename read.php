<?php
include "i/head.php";
include "i/header.php";

require_once "classes/chronicle.php";
require_once "classes/post.php";

// TODO: Idé: spara tillståndet med en vanlig cookie, och låt logiken vara helt på klient-sidan
//       Alltså flytta markörerna 'showcomments' och 'showwriter' från sessionen och använd ren
//       Javascript för att hantera och spara tillståndet.
/*
 * Visa kommentarer om det en gång är lagrat i session
 */
if($_SESSION['showcomments'])
{
	?>
	<script type="text/javascript">
		$(document).ready(function() {
	      $('.showcomment').each(function (j) {
	      	$(this).addClass('expanded');
	        $('#'+this.id+'').load('ajax.php?action=fetchcomments&id='+this.id);
	      });
		});
	</script>
	<?
}

/*
 * Visa författare om det en gång är lagrat i session
 */
if($_SESSION['showwriter'])
{
	?>
	<script type="text/javascript">
		$(document).ready(function() {
	      $('.showwriter').each(function (j) {
	      	$(this).addClass('expanded');
			$('#'+this.id+'').load('ajax.php?action=showwriter&id='+this.id);
	      });
		});		
	</script>
	<?
}

$chronicle = Chronicle::getInstance($_GET['id']);

if ($chronicle)
{
?>
<img src="images/logosmallbeta.png" class="toplogo"> 
<h2><?=$chronicle->name?></h2>
<?=filter_chronicle()?>
<br style="clear: both;">
<?php	
	$i=0;
	foreach ($chronicle->enumeratePosts() as $post)
	{
		$i++;
		?>
		<a name="<?=$i?>"></a>
		<p>
			<?php
			if($post->active == 'blocked')
			echo "<b class='blocked'>Det här inlägget är anmält ".$post->editeddate.". Det modereras just nu.</b>";
			else
			echo $post->body;
			?>
  
	    </p>
		<div id="writer_<?=$post->id?>" class="showwriter">
		</div>
		<div id="comments_<?=$post->id?>" class="showcomment">
		</div>
		<img src="images/ajax-loader.gif" class="loader">
		<?
	}
?>

<?php
	do_write($chronicle->last_post()->id);

} 
else 
{ ?>
	<h4>Det är väldigt sorgligt</h4>
	<p>Men vi kunde inte hitta den här krönikan.</p> <?		
}

include "i/footer.php";
include "i/foot.php";
?>