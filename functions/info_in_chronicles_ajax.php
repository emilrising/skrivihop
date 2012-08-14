<?php
include "shead.php";
include "show_info_in_chronicle.php";

if($_GET['nocomments'])
	$_SESSION['showcomments'] = FALSE;

if($_GET['showcomments'])
{
	$data = explode('_',$_GET['showcomments']);
	show_comments($data[1]);
	$_SESSION['showcomments'] = TRUE;
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