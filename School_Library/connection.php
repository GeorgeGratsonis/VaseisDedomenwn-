<?php
   
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$db = "school_library";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db);

if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
