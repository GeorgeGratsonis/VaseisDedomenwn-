<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'School_Library';
$backup_file = '/Applications/MAMP/htdocs/School_Library/School_Library2023-05-30-16-51-50.gz';

// command to restore
$command = "gunzip < $backup_file | mysql --user=$dbuser --password=$dbpass --host=$dbhost $dbname";

system($command);
header("location: Admin.php")
?>
