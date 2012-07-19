<?php

function latest_post($whom='all'){
	//Latest post, all posts.
	if($whom == 'all'){
		$sql = "SELECT * FROM `post` WHERE active = 'yes' ORDER BY `createddate` DESC LIMIT 1";
		$res = mysql_query($sql);
		$rad = mysql_fetch_assoc($res);
		?>
			<div class="box">
		
					<div class="arrowup">
		
						<!-- -->
		
					</div>
		
			<h2>Senaste inlägg</h2>
		
			<p>"<i><?=$rad['body']?></i>"</p>
			
			<p class="byuser">
		
				Av <a href="player.php?id=<?=$rad['createdby']?>"><?=get_user_name($rad['createdby'])?></a>,<br>
		
		
		
			från krönikan <a href="chronicle.php?id=<?=$rad['chronicleid']?>"><?=get_chronicle_name($rad['chronicleid'])?></a>
		
			</p>
		
			<br style="clear:both;">
		
		
		
			</div>
		
		<?
	}
	else{
		$who = explode(':',$whom);
		
		if($who[0] == 'chronicle'){
			$sql = "SELECT * FROM `post` WHERE `chronicleid` = '".$who[1]."' AND active = 'yes' ORDER BY `createddate` DESC LIMIT 1";
			$res = mysql_query($sql);
			$rad = mysql_fetch_assoc($res);
			?>
				<div class="box">
			
						<div class="arrowup">
			
							<!-- -->
			
						</div>
			
				<h2>Senaste inlägg</h2>
			
				<p>"<i><?=$rad['body']?></i>"</p>
				
				<p class="byuser">
			
					Av <a href="player.php?id=<?=$rad['createdby']?>"><?=get_user_name($rad['createdby'])?></a>
			
			
			
				
			
				</p>
			
				<br style="clear:both;">
			
			
			
				</div>
			
			<?
			
		}
		elseif($who[0] == 'user'){
			$sql = "SELECT * FROM `post` WHERE `createdby` = '".$who[1]."' AND active = 'yes' ORDER BY `createddate` DESC LIMIT 1";
			$res = mysql_query($sql);
			$rad = mysql_fetch_assoc($res);
			?>
				<div class="box">
			
						<div class="arrowup">
			
							<!-- -->
			
						</div>
			
				<h2>Senaste inlägg</h2>
			
				<p>"<i><?=$rad['body']?></i>"</p>
				
				<p class="byuser">
			
					Från krönikan <a href="chronicle.php?id=<?=$rad['chronicleid']?>"><?=get_chronicle_name($rad['chronicleid'])?></a>
			
			
			
				
			
				</p>
			
				<br style="clear:both;">
			
			
			
				</div>
			
			<?
		}
	}
	
	
}

?>