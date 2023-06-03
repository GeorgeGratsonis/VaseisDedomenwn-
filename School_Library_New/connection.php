<?php
   
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "school_library";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db);

if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}