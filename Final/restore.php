<?php

if (isset($_POST["submit"])) {
$conn = mysqli_connect("localhost", "root", "", "School_Library");
$filePath = "school_library.sql";
function restoreMysqlDB($filePath, $conn)
{
    $sql = '';
    $error = '';
    
    if (file_exists($filePath)) {
        $lines = file($filePath);
        
        foreach ($lines as $line) {
            
            // Ignoring comments from the SQL script
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            
            $sql .= $line;

            if (substr(trim($line), - 1, 1) == ';') {
                try {
                    $result = mysqli_query($conn, $sql);
                }
                catch (Exception $e) {
                    header("location: admin.php?error=failedrestore");
                    exit();
                }
                if (! $result) {
                    $error .= mysqli_error($conn) . "\n";
                }
                $sql = '';
            }
        } // end foreach
        
        if ($error) {
            header("location: admin.php?error=failedrestore");
            exit();
        } else {
            $response = array(
                "type" => "success",
                "message" => "Database Restore Completed Successfully."
            );
        }
    } // end if file exists
    header("location: admin.php?error=successrestore");
    return $response;
}
restoreMysqlDB($filePath,$conn);
}
else {
    header("location: admin.php?error=failedrestore");
    exit();
}