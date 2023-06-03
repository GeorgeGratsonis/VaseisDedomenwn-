<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';

	$admin_data = check_admin_login($conn);

    $id = $_GET['id'];
    $query = "DELETE
            FROM libraryoperator
            WHERE LibraryOperator_ID = $id";
    mysqli_query($conn, $query);
    header("Location: applications.php?error=successreject");
    exit();
?>