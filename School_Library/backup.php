<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'School_Library';
$backup_file = $dbname . date("Y-m-d-H-i-s") . '.gz';

// command to backup
$command = "mysqldump --user=$dbuser --password=$dbpass --host=$dbhost $dbname | gzip > $backup_file";

system($command);
header("location: Admin.php");
exit();
?>
