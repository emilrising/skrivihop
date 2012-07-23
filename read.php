<?php
include "i/head.php";
include "i/header.php";
include "functions/show_info_in_chronicle.php";

require_once "classes/chronicle.php";
require_once "classes/post.php";

/*
 * Visa kommentarer om det en gång är lagrat i session
 */
if($_SESSION['showcomments']){
	?>
	<script type="text/javascript">
		$(document).ready(function() {
	      $('.showcomment').each(function (j) {
	      	$(this).addClass('expanded');
	        $('#'+this.id+'').load('functions/info_in_chronicles_ajax.php?showcomments='+this.id);
	      });
		});		
	</script>
	<?
}
/*
 * Visa författare om det en gång är lagrat i session
 */
if($_SESSION['showwriter']){
	?>
	<script type="text/javascript">
		$(document).ready(function() {
	      $('.showwriter').each(function (j) {
	      	$(this).addClass('expanded');
			$('#'+this.id+'').load('functions/info_in_chronicles_ajax.php?showwriter='+this.id);
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
	$orderby = "`createddate` ASC";
	$limitby = "";
	$sql = "SELECT * FROM `post` WHERE `chronicleid` = :id AND active != 'no' ORDER BY ".$orderby." ".$limitby." ";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(':id' => $_GET['id']));	
	$stmt->setFetchMode(PDO::FETCH_INTO, new Post);
	
	$i=0;
	foreach ($stmt as $post)
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
		<img src="images/ajax-loader.gif" class="loader">
		</div>
		<div id="comments_<?=$post->id?>" class="showcomment">
		<img src="images/ajax-loader.gif" class="loader">
		</div>
		<?
		$latestpost = $post->id;
	}

?>

<?php
do_write($latestpost);

} 
else 
{ ?>
	<h4>Det är väldigt sorgligt</h4>
	<p>Men vi kunde inte hitta den här krönikan.</p> <?		
}

include "i/footer.php";

include "i/foot.php";
?>