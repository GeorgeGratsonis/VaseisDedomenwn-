<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';
    
    $operator_data = check_libraryoperator_login($conn);

    $userId = $_GET['id'];
    $query = "DELETE FROM User
            WHERE User_ID = '$userId'";
    mysqli_query($conn, $query);
    header("Location: operatorusers.php?error=successdelete");
    exit();
    
?>