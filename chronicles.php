<?php
include "i/head.php";
include "i/header.php";
require_once "classes/chronicle.php";

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
<h2>Aktiva krönikor </h2>
<div class="submenu">
	
	<div class="dotlight heading">
		+
	</div>
	<div class="menu more">
		<div class="arrowup">
			<!-- -->
		</div>
		<a href="?orderby=latest">Senast uppdaterade</a> - <a href="?orderby=alphabetic">A till Ö</a> - <a id="filter" title="chronicles">Filtrera</a> <span class="limit">Visa <br><input type="text" value="<?=$shownr?>" autofocus onchange="parent.location='?shownr='+this.value"/></span> 
	</div>
	<div id="filter_search"></div>
	<br style="clear: both;">
</div>
<br style="clear: both;">
<?php

	if($_GET['search']){
		$where = "WHERE `name` LIKE :Name";
	}
	
	if($_GET[orderby] == 'latest'){
	$sql = "SELECT * FROM 
			(
			SELECT p.createddate, p.body, c.name, c.shortdesc, c.id 
			FROM `chronicles` AS c 
			JOIN post AS p ON c.id = p.chronicleid 
			ORDER BY p.createddate DESC
			) AS my_table_tmp
			GROUP BY id
			ORDER BY createddate DESC LIMIT ".$limit."
			";	

	}
	elseif($_GET['orderby'] == 'alphabetic'){
		$sql = "SELECT * FROM `chronicles` ".$where." ORDER BY `name` ASC LIMIT ".$limit."";
	}
	else{
		$orderby = "`createddate` DESC";
		$sql = "SELECT * FROM `chronicles` ".$where." ORDER BY ".$orderby." LIMIT ".$limit."";
	}
	
	$stmt = $pdo->prepare("SELECT COUNT(*) ".$where." FROM chronicles");
	$stmt->bindParam(":Name", $_GET['search']);
	$stmt->execute();
	$num = $stmt->fetchColumn(0);
	
	if ($num > 0)
	{
		$stmt = $pdo->prepare($sql);
	
		// Depending on the input we might not actually need a parameter, so use bindParam and ignore return value.
		$stmt->bindParam(":Name", $_GET['search']);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_INTO, new Chronicle);

		foreach ($stmt as $chronicle)
		{ ?>
			<h4><?= $chronicle->url() ?></h4>
			<p><?= $chronicle->shortdesc ?></p>
		<?
		}
	}
	else 
	{ ?>
			<h4>Det är väldigt sorgligt</h4>
				<p>
					Men vi kunde inte hitta de krönikor du letar efter.
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
<br>
<?php
	do_new_stuff(Action::NewChronicle);
?>
<br style="clear: both;">
<?php
include "i/footer.php";

include "i/foot.php";
?>