<?php

// Initialize the global variable $pdo which will be used for all database communication.

$pdo; 

try {
	$pdo = new PDO();
} 
catch (PDOException $ex)
{
	echo $pdo->errorInfo();
	exit();
}	

?>