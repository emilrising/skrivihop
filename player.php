<?php

include "i/head.php";
include "i/header.php";

require_once("classes/user.php");

$user = User::build_object($_GET['id']);

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
if($_GET['id'] == $_SESSION['userid'])
edit_player($_GET['id']);
?>
</p>
<?php

if(isset($changed_your_pwd)){
	echo $changed_your_pwd;
}

$latest = $user->latestpost();
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

<div class="box info">
			<div class="arrowup">
				<!-- -->
			</div>
Syntes senast: <?= $user->lastlogin ?>
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

	    	    <ul><h4>Karaktärer</h4>
	    	    	<?php
	    	    	
	    	    	foreach ($user->characters() as $character)
					{
						?>
						<li><?= $character->url() ?></li>
						<?
					}
					
	    	    	?>
	    	     </ul>
	    	    <ul><h4>Krönikor</h4>
	    	    	<?php

	    	    	foreach ($user->chronicles() as $chronicle)
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
if($_GET['id'] == $_SESSION['userid'])
do_new_stuff();
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
