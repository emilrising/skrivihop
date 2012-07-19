<?php
function logged_in(){
	if($_SESSION['logedin'] == md5('N0H0tD0gBuns'))
		return TRUE;
}
function do_logout(){
	session_destroy();
}
function updates_since_last($returntype='all'){
	$sql = "SELECT `chronicleid` FROM `post` WHERE `createdby` = '".$_SESSION['userid']."' GROUP BY `chronicleid`";
	$res = mysql_query($sql);

	while($active = mysql_fetch_assoc($res)){
		$sql2 = "SELECT `id` FROM `post` WHERE `chronicleid` = '".$active['chronicleid']."' AND `createdby` != '".$_SESSION['userid']."' AND `createddate` > '".$_SESSION['lastlogin']."'";
		$res2 = mysql_query($sql2);
		$posts = mysql_num_rows($res2);

		$total['posts'] = $total['posts']+$posts;
		
		$sql3 = "SELECT `id` FROM `comments` WHERE `chronicleid` = '".$active['chronicleid']."' AND `createdby` != '".$_SESSION['userid']."' AND `createddate` > '".$_SESSION['lastlogin']."'";
		$res3 = mysql_query($sql3);
		$comments = mysql_num_rows($res3);
		
		$total['comments'] = $total['comments']+$comments;
	}
	if($returntype != 'all')
		return $total[$returntype];
	else	
		return ($total['posts']+$total['comments']);
}

function do_top_header(){
	if(logged_in()){
	?>
				<div id="accountinfo">
					<div class="dotlight">
						<?=updates_since_last()?>
					</div>
					<a href="player.php?id=<?=$_SESSION['userid']?>">Mitt konto</a>&nbsp;&nbsp-&nbsp;&nbsp;<a href="index.php?logout=true">Logga ut</a>
				</div>
	
	
	
	<?
	}
}

function filter_chronicle(){
	if(logged_in()){
		?> 
	<div class="submenu">
	
	<div class="dotlight heading">
		+
	</div>
	<div class="menu more">
		<div class="arrowup">
			<!-- -->
		</div>
		<a  id="showcomments">Visa kommentarer</a> - <a  id="showwriters" >Visa författatinformation</a> 
	</div>
	<br style="clear: both;">
	</div>
<?
	}
}
include "write.php";
?>