<?php
include "i/shead.php";

include "captcha.php";

?>
<?php
create_image();

?><br>
<label for="name">Ditt namn:</label>
<input type="text" name="name" placeholder="Ditt namn" <?=(isset($create_new_user) ? "value='".$create_new_user['name']."'" : "")?>><br>
<label for="captcha">Skriv in texten i bilden</label>
<input type="text" name="capthca" placeholder="Texten i bilden"><img src="capthca.png?date=<?=date('His')?>" style="position: relative;top: 13px;">
<?php



?>


