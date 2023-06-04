<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';
    
    $operator_data = check_libraryoperator_login($conn);

    $reviewId = $_GET['id'];
    $query = "DELETE FROM Review
            WHERE Review_ID = '$reviewId'";
    mysqli_query($conn, $query);
    header("Location: seereviews.php?error=successreject");
    exit();
    
?>