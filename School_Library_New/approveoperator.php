<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';
    
    $admin_data = check_admin_login($conn);

    $newoperatorid = $_GET['id'];
    $school = $_GET['school'];
    $query = "SELECT libraryoperator_ID
            FROM libraryoperator
            WHERE Approved = TRUE
            AND School_ID = $school";
    mysqli_query($conn, $query);
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $oldoperatorid = $row[0];
    $query = "UPDATE LibraryOperator
            SET Approved = FALSE
            WHERE LibraryOperator_ID = $oldoperatorid";
    mysqli_query($conn, $query);
    $query = "UPDATE User
            SET LibraryOperator_ID = $newoperatorid
            WHERE LibraryOperator_ID = $oldoperatorid";
    mysqli_query($conn, $query);
    $query = "UPDATE Book_LibraryOperator
            SET LibraryOperator_ID = $newoperatorid
            WHERE LibraryOperator_ID = $oldoperatorid";
    mysqli_query($conn, $query);
    $query = "UPDATE Review
            SET LibraryOperator_ID = $newoperatorid
            WHERE LibraryOperator_ID = $oldoperatorid
            AND Approved = FALSE";
    mysqli_query($conn, $query);
    $query = "UPDATE LibraryOperator
            SET Approved = TRUE
            WHERE LibraryOperator_ID = $newoperatorid";
    mysqli_query($conn, $query);
    header("Location: applications.php?error=successapprove");
    exit();
?>