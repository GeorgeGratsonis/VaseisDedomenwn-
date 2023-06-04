<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';
    
    $operator_data = check_libraryoperator_login($conn);

    $userId = $_GET['id'];
    $query = "UPDATE USER
            SET Approved = FALSE
            WHERE User_ID = '$userId'";
    mysqli_query($conn, $query);
    header("Location: operatorusers.php?error=successdisable");
    exit();
    
?>