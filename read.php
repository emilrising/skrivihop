<?php
include "i/head.php";

include "i/header.php";

include "functions/show_info_in_chronicle.php";

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
?>
<img src="images/logosmallbeta.png" class="toplogo"> 
<h2><?=get_chronicle_name($_GET['id'])?></h2>
<?=filter_chronicle()?>
<br style="clear: both;">
<?php
	$orderby = "`createddate` ASC";
	$limitby = "";
	$sql = "SELECT * FROM `post` WHERE `chronicleid` = '".$_GET['id']."' AND active != 'no' ORDER BY ".$orderby." ".$limitby." ";
	$res = mysql_query($sql);
	$i=0;
	while($rad = mysql_fetch_assoc($res)){
	$i++;
		?>
		<a name="<?=$i?>"></a>
		<p>
			<?php
			if($rad['active'] == 'blocked')
			echo "<b class='blocked'>Det här inlägget är anmält ".$rad['editeddate'].". Det modereras just nu.</b>";
			else
			echo stripslashes($rad['body']);
			?>
  
	    </p>
		<div id="writer_<?=$rad['id']?>" class="showwriter">
		<img src="images/ajax-loader.gif" class="loader">
		</div>
		<div id="comments_<?=$rad['id']?>" class="showcomment">
		<img src="images/ajax-loader.gif" class="loader">
		</div>
		<?
		$latestpost = $rad['id'];

	}

?>

<?php
do_write($latestpost);
?>

		


<?php
include "i/footer.php";

include "i/foot.php";
?>