<?php
$server = "localhost";
$user = "root";
$pwd = "";
$db = "canteen";
$conn = mysqli_connect($server, $user, $pwd,$db);
if(!$conn){
die("connection failed".mysqli_connect_error());
} 
?>