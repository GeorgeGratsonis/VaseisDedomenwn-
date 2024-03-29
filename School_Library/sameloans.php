<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';

	$admin_data = check_admin_login($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>School Library</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="bootstrap.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md" id="nav-bar">
        <div id="navbar-div" class="container-fluid">
            <a class="navbar-brand" id="nav-bar-text"  href="admin.php">School Library - Admin Page</a>
            <a id="navbar-items" href="logout.php">
                <i class="fa fa-home" href="logout.php"></i> Log out
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row" id="row">
            <div class="col-md-12">
                <div class="card" id="card-container">
                    <div class="card-body" id="card">
                        <form method="GET" action="">
                            <label for="year">Year:</label>
                            <select name="year" id="year">
                                <option value="">None</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>

                            <button type="submit" class="btn btn-primary" id="show-btn">Submit</button>
                        </form>

                        <?php

                        $selectedYear = isset($_GET['year']) ? $_GET['year'] : "";
                              
                        if ($selectedYear != "") {
                        $query = "SELECT GROUP_CONCAT(CONCAT(LibraryOperator.First_Name, ' ', LibraryOperator.Last_Name) SEPARATOR ', ') AS LibraryOperators_Fullnames, Borrowing.Loans
                        FROM (
                        SELECT Borrowing.LibraryOperator_ID, COUNT(*) AS Loans
                        FROM Borrowing
                        WHERE YEAR(Borrowing.Borrowing_Date) = $selectedYear
                        GROUP BY Borrowing.LibraryOperator_ID
                        HAVING COUNT(*) > 20
                        ) AS Borrowing
                        JOIN LibraryOperator ON Borrowing.LibraryOperator_ID = LibraryOperator.LibraryOperator_ID
                        GROUP BY Borrowing.Loans
                        HAVING COUNT(*) > 1;"; 
                        $result = mysqli_query($conn, $query);

                        if(mysqli_num_rows($result) == 0){
                            echo '<h1 style="margin-top: 5rem;">No Library Operators found!</h1>';
                        }
                        else{

                            echo '<div class="table-responsive">';
                                echo '<table class="table">';
                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th>Library Operators</th>';
                                            echo '<th>Loans</th>';
                                        echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                    while($row = mysqli_fetch_row($result)){
                                        echo '<tr>';
                                            echo '<td>' . $row[0] . '</td>';
                                            echo '<td>' . $row[1] . '</td>';
                                            echo '<td>';
                                                echo '</a>';
                                            echo '</td>';
                                        echo '</tr>';
                                    }
                                    echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                        }
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
