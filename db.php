<?php
	$server = "localhost";
	$user = "root";
	$pass = "";
	$db = "ml";
	$conn = mysqli_connect($server, $user, $pass, $db);
	
	date_default_timezone_set("Asia/Manila");
	$dateToday = date("Y-m-d"); 
	$timeToday = date("H:i:s");
?>