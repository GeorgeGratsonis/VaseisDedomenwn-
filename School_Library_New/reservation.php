<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';
    
    $user_data = check_user_login($conn);

    $bookId = $_GET['id'];
    $userId = $user_data['User_ID'];
    $reservationDate = date("Y-m-d");
    $reservationDate = "'" . $reservationDate . "'";
    $query = "SELECT LibraryOperator_ID FROM user WHERE user_id = $userId";
    mysqli_query($conn, $query);
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $libraryOperatorId = $row[0];
    try {
        $query = "INSERT INTO Reservation (Reservation_Date, User_ID, LibraryOperator_ID, Book_ID) 
            VALUES ($reservationDate, '$userId', '$libraryOperatorId', '$bookId')";
        mysqli_query($conn, $query);
        header("Location: searchbooks.php?error=successreservation");
        exit();
    } catch (Exception $e) {
        header("Location: searchbooks.php?error=exception&message=" . urlencode($e->getMessage()));
        exit();
    }
    
?>