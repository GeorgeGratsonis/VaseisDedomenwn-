<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';

    $operator_data = check_LibraryOperator_login($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Library Users</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="bootstrap.css">
    <style>
        .form-control {
            height: 50px;
            font-size: 16px;
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
            <a class="navbar-brand" id="nav-bar-text" href="libraryoperator.php">School Library - Library Operator Page</a>
            <a id="navbar-items" href="logout.php">
                <i class="fa fa-home" href="logout.php"></i> Log out
            </a>
        </div>
    </nav>

    <div class="container">
    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "successreturn") {
                echo "<p class='noerror-message text-center'>Book Returned!</p>";
            }
        }
    ?>
        <div class="row" id="row">
            <div class="col-md-12">
                <div class="card" id="card-container">
                    <div class="card-body" id="card">
                        <form method="GET" action="">
                            <div class="input-group">
                                <input type="text" class="form-control" name="firstName" placeholder="Search by First Name" aria-label="Search">
                                <input type="text" class="form-control" name="lastName" placeholder="Search by Last Name" aria-label="Search">
                                <input type="text" class="form-control" name="booktitle" placeholder="Search by Book title" aria-label="Search">
                                <button type="submit" class="btn btn-primary" id="show-btn">Submit</button>
                            </div>
                        </form>

                        <?php
                            include 'connection.php';

                            $firstName = $_GET['firstName'] ?? '';
                            $lastName = $_GET['lastName'] ?? '';
                            $delayDays = $_GET['delayDays'] ?? '';

                            $query = "SELECT Borrowing.Returned, Borrowing.Borrowing_Date, Book.Title AS Book_Title, CONCAT(User.First_Name, ' ', User.Last_Name) As User_Fullname, User.Role, Book.Book_ID
                                FROM User
                                JOIN Borrowing ON User.User_ID = Borrowing.User_ID
                                JOIN Book ON Borrowing.Book_ID = Book.Book_ID
                                WHERE Borrowing.LibraryOperator_ID = '$operator_data[LibraryOperator_ID]'";

                            if ($firstName) {
                                $query .= " AND User.First_Name LIKE '%$firstName%'";
                            }

                            if ($lastName) {
                                $query .= " AND User.Last_Name LIKE '%$lastName%'";
                            }

                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) == 0) {
                                echo '<h1 style="margin-top: 5rem;">No Users found!</h1>';
                            } else {
                                echo '<div class="table-responsive">';
                                echo '<table class="table">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>Borrowing Date</th>';
                                echo '<th>Book Title</th>';
                                echo '<th>User Full Name</th>';
                                echo '<th>Role</th>';
                                echo '<th>Returned</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>';
                                    echo '<td>' . $row['Borrowing_Date'] . '</td>';
                                    echo '<td>' . $row['Book_Title'] . '</td>';
                                    echo '<td>' . $row['User_Fullname'] . '</td>';
                                    echo '<td>' . $row['Role'] . '</td>';
                                    if ($row['Returned'] == TRUE) {
                                        echo '<td>Yes</td>';
                                        echo '<td></td>';
                                    } else {
                                        echo '<td>No</td>';
                                        echo '<td>';
                                            echo '<a type="button" href="./return.php?id=' . $row['Book_ID']. '">';
                                                echo '<i class="fa fa-check"></i>';
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
                        <br>
                        <a class="btn btn-primary" id="show-btn" href="addborrowing.php">Add Borrowing</a>     
                    </div>
                </div>
            </div>
        </div>
    </div>
    &nbsp;
    &nbsp;
    <script src="{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
