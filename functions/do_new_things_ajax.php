<?php
include "shead.php";


if($_GET['do'] == 'character'){
	do_new_char_simple();
}
elseif($_GET['do'] == 'chronicle'){
	do_new_chronicle_simple();
}
elseif($_GET['do'] == 'editpost'){
	edit_post_simple($_GET['postid']);
}
elseif($_GET['do'] == 'commentpost'){
	comment_post_simple($_GET['postid']);
}
elseif($_GET['do'] == 'blockpost'){
	block_post_simple($_GET['postid']);
}



?>