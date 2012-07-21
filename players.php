<?php
include "i/head.php";
include "i/header.php";

require_once "classes/user.php";

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
		$where = "AND `name` LIKE :Name";
	}

	if($_GET[orderby] == 'latest'){
		$orderby = "`createddate` DESC";
	}
	elseif($_GET['orderby'] == 'alphabetic'){
		$orderby = "`name` ASC";
	}
	else
		$orderby = "`createddate` DESC";

	$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE active = 'yes'");
	$num = $stmt->fetchColumn(0);

	if ($num > 0)
	{
		$sql = "SELECT * FROM users WHERE active = 'yes' ".$where." ORDER BY ".$orderby." LIMIT ".$limit."";
	
		$stmt = $pdo->prepare($sql);
	
		// Depending on the input we might not actually need a parameter, so use bindParam and ignore return value.
		$stmt->bindParam(":Name", $_GET['search']);
		$stmt->execute();	
		$stmt->setFetchMode(PDO::FETCH_INTO, new User);
	
		foreach ($stmt as $user)
		{ ?>
			<h4><?= $user->url() ?></h4>
			<div class="box info">
	
				<div class="arrowup">
					<!-- -->
				</div>
				Syntes senast: <?= $user->lastlogin ?><br>
				Senaste inlägg: <?= $user->latestpost()->createddate ?>
			</div>	
			
			<?php
		}
	}
	else
	{
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