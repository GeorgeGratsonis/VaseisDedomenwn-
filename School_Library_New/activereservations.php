<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';

	$user_data = check_user_login($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>School Library</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="bootstrap.css">
    <style>
        .error-message {
            color: red;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: -47px;
        }
        .noerror-message {
            color: green;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: -47px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md" id="nav-bar"> 
        <div id="navbar-div" class="container-fluid">
            <a class="navbar-brand" id="nav-bar-text" href="user.php">School Library - User Page</a>
            <a id="navbar-items" href="logout.php">
                <i class="fa fa-home "></i> Log out
            </a>
        </div>
    </nav>

    <div class="container">
    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "successcomplete") {
                echo "<p class='noerror-message text-center'>Reservation completed!</p>";
            }
            else if ($_GET["error"] == "successcancel") {
                echo "<p class='noerror-message text-center'>Reservation cancelled!</p>";
            }
            else if ($_GET['error'] === 'exception') {
                $errorMessage = urldecode($_GET['message']);
                echo "<p class='error-message text-center'>" . $errorMessage . "</p>";
            }
        }
    ?>
        <div class="row" id="row">
            <div class="col-md-12">
                <div class="card" id="card-container">
                    <div class="card-body" id="card">
                        <?php
                        $query = "SELECT Book.Title, R.Reservation_Date, R.Status, R.Reservation_ID
                        FROM Reservation as R
                        JOIN book ON Book.Book_ID = R.Book_ID
                        WHERE User_ID = '$user_data[User_ID]'
                        AND Status != 'Completed'";
                        $result = mysqli_query($conn, $query);
                        
                        if(mysqli_num_rows($result) == 0){
                            echo '<h1 style="margin-top: 5rem;">No Active Reservations found!</h1>';
                        }
                        else{
                            echo '<div class="table-responsive">';
                                echo '<table class="table">';
                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th>Book Title</th>';
                                            echo '<th>Reservation Date</th>';
                                            echo '<th>Status</th>';
                                            echo '<th></th>';
                                            echo '<th></th>';
                                        echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                    while($row = mysqli_fetch_row($result)){
                                        echo '<tr>';
                                            echo '<td>' . $row[0] . '</td>';
                                            echo '<td>' . $row[1] . '</td>';
                                            echo '<td>' . $row[2] . '</td>';
                                            if ($row[2] == 'Pending') {
                                                echo '<td>';
                                                echo '<a type="button" href="./completereservation.php?id=' . $row[3] . '">';
                                                    echo '<i class = "fa fa-check"></i>';
                                                echo '</a>';
                                                echo '</td>';
                                                echo '<td>';
                                                echo '<a type="button" href="./cancelreservation.php?id=' . $row[3] . '">';
                                                    echo '<i class = "fa fa-x"></i>';
                                                echo '</a>';
                                                echo '</td>';
                                            }             
                                            if ($row[2] == 'On Hold') {
                                                echo '<td></td>';
                                                echo '<td>';
                                                echo '<a type="button" href="./cancelreservation.php?id=' . $row[3] . '">';
                                                    echo '<i class = "fa fa-x"></i>';
                                                echo '</a>';
                                            echo '</td>';
                                            }
                                        echo '</tr>';
                                    }
                                    echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <a action></a>
                </div>
            </div>
        </div>
    </div>

    <script src = "{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>
    
</body>

</html>