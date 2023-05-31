<?php

if (isset($_POST["submit"])) {

    $mysqlUserName      = "root";
    $mysqlPassword      = "";
    $mysqlHostName      = "localhost";
    $DbName             = "school_library";
    $backup_name        = "C:\XAMPP\htdocs\School_Library\backup.sql";
    $tables             = array("administrator", "school", "libraryoperator", "user", "book",  "author", "category", "borrowing", "reservation", "review", "book_author", "book_category", "book_libraryoperator");

    Export_Database($mysqlHostName,$mysqlUserName,$mysqlPassword,$DbName,  $tables=false, $backup_name=false );

    function Export_Database($host, $user, $pass, $name, $tables = false, $backup_name = false)
{
    $mysqli = new mysqli($host, $user, $pass, $name);
    $mysqli->select_db($name);
    $mysqli->query("SET NAMES 'utf8'");

    $table_order = array(
        'administrator',
        'school',
        'libraryoperator',
        'user',
        'book',
        'author',
        'category',
        'borrowing',
        'reservation',
        'review',
        'book_author',
        'book_category',
        'book_libraryoperator'
    );

    if ($tables === false) {
        $queryTables = $mysqli->query('SHOW TABLES');
        while ($row = $queryTables->fetch_row()) {
            $target_tables[] = $row[0];
        }
    } else {
        $target_tables = $tables;
    }

    $ordered_tables = array_intersect($table_order, $target_tables);

    $content = '';

    foreach ($ordered_tables as $table) {
        $result = $mysqli->query('SELECT * FROM ' . $table);
        $fields_amount = $result->field_count;
        $rows_num = $mysqli->affected_rows;
        $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
        $TableMLine = $res->fetch_row();
        $content .= (!empty($content) ? "\n\n" : '') . $TableMLine[1] . ";\n\n";

        for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
            while ($row = $result->fetch_row()) {
                // when started (and every after 100 command cycle):
                if ($st_counter % 100 == 0 || $st_counter == 0) {
                    $content .= "\nINSERT INTO " . $table . " VALUES";
                }
                $content .= "\n(";
                for ($j = 0; $j < $fields_amount; $j++) {
                    $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                    if (isset($row[$j])) {
                        $content .= '"' . $row[$j] . '"';
                    } else {
                        $content .= '""';
                    }
                    if ($j < ($fields_amount - 1)) {
                        $content .= ',';
                    }
                }
                $content .= ")";
                // every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle earlier
                if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                    $content .= ";";
                } else {
                    $content .= ",";
                }
                $st_counter = $st_counter + 1;
            }
        }
        $content .= "\n\n\n";
    }

    $date = date("Y-m-d");
    $backup_name = $backup_name ? $backup_name : $name . ".$date.sql";

    // Save the backup file to the desired directory
    $backup_path = $backup_name;
    file_put_contents($backup_path, $content);

    // Download the backup file
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . basename($backup_path) . "\"");
    header("location: admin.php?error=successbackup");
    readfile($backup_path);
    exit;
}
}
else {
    header("location: admin.php");
    exit();
}