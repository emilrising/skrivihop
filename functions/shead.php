<?php
// check if head exists skip if dont
if(!$shead){
session_start();
date_default_timezone_set('Europe/Stockholm');


// include database connection
require_once("../dbc.php");
// include functions
include "general.php";
include "logedin.php";
include "latestpost.php";


}
// set heads true so it will not repeate itself
$shead = true;

?>