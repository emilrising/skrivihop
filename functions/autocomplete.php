<?php
include "shead.php";
/*
$q = strtolower($_GET["q"]);
if (!$q) return;
$items = array(
"Great <em>Bittern</em>"=>"Botaurus stellaris",
"Little <em>Grebe</em>"=>"Tachybaptus ruficollis",
"Black-necked Grebe"=>"Podiceps nigricollis",
"Little Bittern"=>"Ixobrychus minutus",
"Black-crowned Night Heron"=>"Nycticorax nycticorax",
"Purple Heron"=>"Ardea purpurea"

);

foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		echo "$key|$value\n";
	}
}
 * */

if($_GET){
$q = strtolower($_GET["q"]);
	if (!$q) return;
$sql = "SELECT * FROM `categories` WHERE `name` LIKE '".$q."%' AND `active` = 'yes'";
$res = mysql_query($sql);
while($rad = mysql_fetch_assoc($res)){
	if (strpos(strtolower($rad['name']), $q) !== false) {
		echo $rad['name']."\n";
	}
}
	
}
?>