<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'School_Library';
$backup_file = '/Users/georgegratsonis/Desktop/Desktop2023-05-30_20-29-01';

// command to restore
$command = "gunzip < $backup_file | mysql --user=$dbuser --password=$dbpass --host=$dbhost $dbname";

system($command);
header("location: Admin.php")
?>
