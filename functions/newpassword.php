<?php
include "shead.php";

		if($_GET['newpasswordplease']){

			?>
			<form class="box overlay" method="post">
						<div class="arrowup">
				
							<!-- -->
				
						</div>
			<label for="username">Användarnamn</label>
			<input type="email" name="npw_email" placeholder="Användarnamn" value="<?=$_GET['username']?>" required>
			<input type="submit" name="npw_submit" value="Skicka mig ett nytt lösenord">
			<br style="clear: both;">
			<br style="clear: both;">
			</form>
			
			<?
		}
		


?>