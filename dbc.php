<?php

// You should of course correct the call mysql_connect here 
$link = mysql_connect( ... );
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db('skrivihop_net',$link);

mysql_query("SET NAMES 'utf8'");

?>