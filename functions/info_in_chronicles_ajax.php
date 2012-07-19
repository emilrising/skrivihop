<?php
include "shead.php";
include "show_info_in_chronicle.php";



if($_GET['close'])
exit();

if($_GET['showcomments']){
	$data = explode('_',$_GET['showcomments']);
	show_comments($data[1]);
	//Let's remember ok?
	if(!$_SESSION['showcomments'])
		$_SESSION['showcomments'] = TRUE;
	elseif($_SESSION['showcomments'] == TRUE)
		unset($_SESSION['showcomments']);	
}
if($_GET['showwriter']){

	$data = explode('_',$_GET['showwriter']);	
	show_writer($data[1]);
	//Let's remember ok?
	if(!$_SESSION['showwriter'])
		$_SESSION['showwriter'] = TRUE;
	elseif($_SESSION['showwriter'] == TRUE)
		unset($_SESSION['showwriter']);	
}
?>