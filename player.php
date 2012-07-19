<?php

include "i/head.php";

include "i/header.php";



$sql = "SELECT * FROM users WHERE id='".$_GET['id']."'";
$res = mysql_query($sql);
$user = mysql_fetch_assoc($res);
?>
<img src="images/logosmallbeta.png" class="toplogo"> 

<br style="clear: both;">

<h2><?=$user[name]?><img src="<?=(strlen($user[avatar]) > 2 ? $user[avatar] : "images/johndoe.png")?>" class="avatar big"></h2>

	    <p>
	    	<?php
	    	$user['description'] = preg_replace("/(http:\/|(www\.))(([^\s<]{4,68})[^\s<]*)/","<a href='http://$2$3' target='_blank'>$1$2$4</a>",$user['description']);
	    	$user['description'] = preg_replace("/(\s@)(([^\s<]{4,68})[^\s<]*)/","<a href='https://twitter.com/#!/$2' target='_blank'>$1$2$4</a>",$user['description']);
	    	echo $user['description'];
	    	?>
	    	
		</p>	
		<p>	
<?php
if($_GET['id'] == $_SESSION['userid'])
edit_player($_GET['id']);
?>
</p>
<?php
if(isset($changed_your_pwd)){
	echo $changed_your_pwd;
}

?>
	<?=latest_post('user:'.$_GET['id'])?>

<div class="box info">
			<div class="arrowup">
				<!-- -->
			</div>
Syntes senast: <?=$user[lastlogin]?>
<?php
if($_SESSION['userid'] == $_GET['id']){
	$sql = "SELECT `chronicleid` FROM `post` WHERE `createdby` = '".$_SESSION['userid']."' GROUP BY `chronicleid`";
	$res = mysql_query($sql);
	$num = mysql_num_rows($res);
	if($num > 0)
		echo "<ul><h4>Andra författares inlägg sen din senaste inloggning</h4>";
	while($active = mysql_fetch_assoc($res)){
		$sql2 = "SELECT `id` FROM `post` WHERE `chronicleid` = '".$active['chronicleid']."' AND `createdby` != '".$_SESSION['userid']."' AND `createddate` > '".$_SESSION['lastlogin']."'";
		$res2 = mysql_query($sql2);
		$posts = mysql_num_rows($res2);
		if($posts > 0){
						?>
						<li><a href="chronicle.php?id=<?=$active['chronicleid']?>"><?=get_chronicle_name($active['chronicleid'])?></a>: <?=$posts?></li>
						<?
		}
		//$total['posts'] = $total['posts']+$posts;
		
		$sql3 = "SELECT `id` FROM `comments` WHERE `chronicleid` = '".$active['chronicleid']."' AND `createdby` != '".$_SESSION['userid']."' AND `createddate` > '".$_SESSION['lastlogin']."'";
		$res3 = mysql_query($sql3);
		$comments = mysql_num_rows($res3);
		if($comments > 0){
						?>
						<li><a href="chronicle.php?id=<?=$active['chronicleid']?>"><?=get_chronicle_name($active['chronicleid'])?>: <?=$comments?></a></li>
						<?
		}
		//$total['comments'] = $total['comments']+$comments;
	}
	if($num > 0)
		echo "</ul>";

}


?>
</div>
<div class="box info">

			<div class="arrowup">
				<!-- -->
			</div>	 

	    	    <ul><h4><?=$user[name]?>s karaktärer</h4>
	    	    	<?php
	    	    	$sql = "SELECT `name`, `id` FROM `characters` WHERE `createdby` = '".$_GET['id']."'";
					$res = mysql_query($sql);
					while($rad = mysql_fetch_assoc($res)){
						?>
						<li><a href="character.php?id=<?=$rad['id']?>"><?=$rad['name']?></a></li>
						<?
					}
	    	    	
	    	    	
	    	    	?>

	    	     </ul>
	    	    <ul><h4><?=$user[name]?>s krönikor</h4>
	    	    	<?php
	    	    	$sql = "SELECT `name`, `id` FROM `chronicles` WHERE `createdby` = '".$_GET['id']."'";
					$res = mysql_query($sql);
					while($rad = mysql_fetch_assoc($res)){
						?>
						<li><a href="chronicle.php?id=<?=$rad['id']?>"><?=$rad['name']?></a></li>
						<?
					}
	    	    	
	    	    	
	    	    	?>

	    	     </ul>
    	     
</div>
<div style="position: relative; top: -28px;" >
<?php
if($_GET['id'] == $_SESSION['userid'])
do_new_stuff();
?>	
</div>
<br style="clear: both;">




<br>
<?php


include "i/footer.php";

include "i/foot.php";
?>
