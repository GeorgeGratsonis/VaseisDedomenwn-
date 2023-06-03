<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';
    
    $operator_data = check_libraryoperator_login($conn);

    $bookId = $_GET['id'];
    $query = "UPDATE Borrowing
            SET Returned = TRUE
            WHERE Book_ID = '$bookId'";
    mysqli_query($conn, $query);
    header("Location: seeborrowings.php?error=successreturn");
    exit();
?>
