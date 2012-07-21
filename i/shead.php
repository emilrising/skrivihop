<?php
// check if head exists skip if dont
if(!$shead){
session_start();
date_default_timezone_set('Europe/Stockholm');

// include database connection
require_once("dbc.php");

// include functions
include "functions/general.php";

// include standards
include "functions/logedin.php";
// include "functions/latestpost.php";

/*
	if($_SESSION[loggedin]!=md5('N0H0tD0gBuns')){
		//session_destroy();
	}
*/

}
// set heads true so it will not repeate itself
$shead = true;
if($_GET[logout]){
	do_logout();
}
?>