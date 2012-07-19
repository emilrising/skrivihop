<?php

/* JAVASCRIPT */
function loadWindow($url){
	// function uses javascript to reload a site.
	echo "<script>parent.location.replace('".$url."');</script>";

} // loadWindow($url)




function pre($var){
// This function presents information from array.
	
			echo "<pre style='font-size:9px; text-align: left;'>";
			print_r($var);
			echo "</pre>";

} // pre($var,$userid=31)
function overpre($var){
// This function presents information from array.
	
			echo "<pre style='font-size:9px; text-align: left; position: absolute; top: 5px; right: 5px; background-color:#fff;'>";
			print_r($var);
			echo "</pre>";

} // pre($var,$userid=31)


function get_user_name($id){
	$sql = "SELECT `name` FROM `users` WHERE `id` = '".$id."'";
	$res = mysql_query($sql);
	$rad = mysql_fetch_assoc($res);
	return $rad['name']; 
}

function get_chronicle_name($id){
	$sql = "SELECT `name` FROM `chronicles` WHERE `id` = '".$id."'";
	$res = mysql_query($sql);
	$rad = mysql_fetch_assoc($res);
	return $rad['name']; 
}
function get_category_name($id){
	$sql = "SELECT `name` FROM `categories` WHERE `id` = '".$id."'";
	$res = mysql_query($sql);
	$rad = mysql_fetch_assoc($res);
	return $rad['name']; 
}
function br2nl( $input ) {
 return preg_replace('/<br(\s+)?\/?>/i', "\n", $input);
}
function insert_ready($body){
	$body = strip_tags($body);
	$body = htmlspecialchars($body);
	$body = str_replace("\r","<br>",$body); 
	$body = str_replace("\n","<br>",$body); 
	$body = str_replace("<br><br>","<br>",$body); 
	$body = mysql_real_escape_string($body);
	$body = addslashes($body);
	return $body;
}


?>