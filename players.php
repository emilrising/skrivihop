<?php
include "i/head.php";

include "i/header.php";

	if($_GET['shownr']){
		$shownr = $_GET['shownr'];
	}
	else{
		$shownr = 5;
	}

	if($_GET['page']){
		$limit = "".(($shownr*($_GET['page']))-$shownr).",".($shownr)."";
	}
	else
		$limit = $shownr;
?>
<img src="images/logosmallbeta.png" class="toplogo"> 
<h2>Författare</h2>
<div class="submenu">
	
	<div class="dotlight heading">
		+
	</div>
	<div class="menu more">
		<div class="arrowup">
			<!-- -->
		</div>
			<a href="?orderby=latest">Senast registrerade</a> - <a href="?orderby=alphabetic">A till Ö</a> - <a id="filter" title="players">Filtrera</a> <span class="limit">Visa <br><input type="text" value="<?=$shownr?>" autofocus onchange="parent.location='?shownr='+this.value"/></span> 
	</div>
	<div id="filter_search"></div>
	<br style="clear: both;">
</div>
<br style="clear: both;">
<?php
	if($_GET['search']){
		$where = "AND `name` LIKE '%".mysql_real_escape_string($_GET['search'])."%'";
	}

	if($_GET[orderby] == 'latest'){
		$orderby = "`createddate` DESC";
	}
	elseif($_GET['orderby'] == 'alphabetic'){
		$orderby = "`name` ASC";
	}
	else
		$orderby = "`createddate` DESC";
	$sql = "SELECT * FROM users WHERE active = 'yes' ".$where." ORDER BY ".$orderby." LIMIT ".$limit."";
	$res = mysql_query($sql);
	$num = mysql_num_rows($res);
	if($num > 0){
		while($writer = mysql_fetch_assoc($res)){
			$latestpost = mysql_fetch_assoc(mysql_query("SELECT `createddate` FROM `post` WHERE createdby = '".$writer['id']."' ORDER BY createddate DESC LIMIT 1"));
			?>
			<h4>
			<a href="player.php?id=<?=$writer['id']?>"><?=$writer['name']?></a><br>
			</h4>
			<div class="box info">
	
				<div class="arrowup">
					<!-- -->
				</div>Syntes senast: <?=$writer['lastlogin']?>,<br> Senaste inlägg: <?=$latestpost['createddate']?>
			</div>	
			
			<?php
		}
	}
	else{
			?>
			<h4>Det är väldigt sorgligt</h4>
				<p>
					Men vi kunde inte hitta de författare du letar efter.
				</p>
			<?php
	}

?>


	

<br style="clear: both;">

<div class="pagination">
<?php
	$sql2 = "SELECT * FROM users WHERE active = 'yes'";
	$res2 = mysql_query($sql2);
	$num = mysql_num_rows($res2);

	if($_GET['page'])
		$current = $_GET['page'];
	else
		$current = 1;
	
	if($num < $shownr)
		$pages = 1;
	else
		$pages = ceil($num/$shownr);
	echo "<span class='left'>Du är på sidan ".$current." av ".$pages." sidor. </span>";
	for ($i = 1; $i <= ($pages > 10 ? 10 : $pages); $i++) {
	    echo "<a href='?page=".$i."".($_GET['orderby'] ? "&orderby=".$_GET['orderby'] : "")."".($_GET['shownr'] ? "&shownr=".$shownr : "")."' ".($i == $current ? ' class="currentpage"' : '').">".$i."</a>";
	}
	if($pages > 10){
		echo "<a href='?page=".($i)."".($_GET['orderby'] ? "&orderby=".$_GET['orderby'] : "")."".($_GET['shownr'] ? "&shownr=".$shownr : "")."'>...</a>";
		echo "<a href='?page=".$pages."".($_GET['orderby'] ? "&orderby=".$_GET['orderby'] : "")."".($_GET['shownr'] ? "&shownr=".$shownr : "")."'>".$pages."</a>";
	}
?>

</div>
<br style="clear: both;">
<?php
include "i/footer.php";

include "i/foot.php";
?>