<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';
    
    $operator_data = check_libraryoperator_login($conn);

    $reservationId = $_GET['id'];
    try {
        $query = "UPDATE Reservation
            SET Status = 'Completed'
            WHERE Reservation_ID = '$reservationId'";
        mysqli_query($conn, $query);
        $query = "SELECT * FROM Reservation
            WHERE Reservation_ID = '$reservationId'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($result);
        $borrowingDate = date("Y-m-d");
        $returnDate = date("Y-m-d", strtotime("+7 days", strtotime($borrowingDate)));
        $borrowingDate = "'" . $borrowingDate . "'";
        $returnDate = "'" . $returnDate . "'";
        $query = "INSERT INTO Borrowing (Borrowing_Date, Return_Date, User_ID, LibraryOperator_ID, Book_ID) 
            VALUES ($borrowingDate, $returnDate, '$row[3]', '$row[4]', '$row[5]')";
        mysqli_query($conn, $query);
        header("Location: seereservations.php?error=successcomplete");
        exit();
    } catch (Exception $e) {
        header("Location: seereservations.php?error=exception&message=" . urlencode($e->getMessage()));
        exit();
    }
    
?>