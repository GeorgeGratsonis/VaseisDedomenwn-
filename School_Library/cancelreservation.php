<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';
    
    $user_data = check_user_login($conn);

    $reservationId = $_GET['id'];
    $query = "DELETE FROM Reservation
        WHERE Reservation_ID = '$reservationId'";
    mysqli_query($conn, $query);
    header("Location: activereservations.php?error=successcancel");
    exit();
?>