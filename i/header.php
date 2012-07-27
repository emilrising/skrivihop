<?

?>
		<div id="header">
			<div id="top">
<?				
			if($currentUser){
?>
				<div id="accountinfo">
					<div class="dotlight">
						<?=updates_since_last()?>
					</div>
					<?= $currentUser->url() ?>&nbsp;&nbsp-&nbsp;&nbsp;<a href="index.php?logout=true">Logga ut</a>
				</div>
<?
			}
?>

			</div>
			<div id="topmenu">
				<div class="dotlight">
					<div class="menu">
						<div class="arrowup"></div>
						<a href="index.php" id="startlink">Start</a> - <a href="chronicles.php">Krönikor</a> - <a href="characters.php">Karaktärer</a> - <a href="players.php">Författare</a>
					</div>
				</div>
			</div>
		</div>
		<br style="clear:both;">
<div id="content">