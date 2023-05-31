<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Library Users</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="bootstrap.css">
    <style>
        .form-control {
            height: 50px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md" id="nav-bar">
        <div id="navbar-div" class="container-fluid">
            <a class="navbar-brand" id="nav-bar-text">Library Users - Admin Page</a>
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
                            <div class="input-group">
                                <input type="text" class="form-control" name="firstName" placeholder="Search by First Name" aria-label="Search">
                                <input type="text" class="form-control" name="lastName" placeholder="Search by Last Name" aria-label="Search">
                                <input type="number" class="form-control" name="delayDays" placeholder="Search by Days of Delay" aria-label="Search">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>

                        <?php
                        include 'connection.php';

                        $firstName = $_GET['firstName'] ?? '';
                        $lastName = $_GET['lastName'] ?? '';
                        $delayDays = $_GET['delayDays'] ?? '';

                        $query = "SELECT CONCAT(User.First_Name, ' ', User.Last_Name) As User_Fullname, User.Role, DATEDIFF(CURRENT_DATE, Borrowing.Return_Date) AS Delay_Days
                        FROM User
                        JOIN Borrowing ON User.User_ID = Borrowing.User_ID
                        WHERE Borrowing.Returned = FALSE ";

                        if ($firstName) {
                            $query .= "AND User.First_Name LIKE '%$firstName%' ";
                        }

                        if ($lastName) {
                            $query .= "AND User.Last_Name LIKE '%$lastName%' ";
                        }

                        if ($delayDays) {
                            $query .= "AND DATEDIFF(CURRENT_DATE, Borrowing.Return_Date) > $delayDays ";
                        }

                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) == 0) {
                            echo '<h1 style="margin-top: 5rem;">No Users found!</h1>';
                        } else {
                            echo '<div class="table-responsive">';
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>User Full Name</th>';
                            echo '<th>Role</th>';
                            echo '<th>Delay Days</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['User_Fullname'] . '</td>';
                                echo '<td>' . $row['Role'] . '</td>';
                                echo '<td>' . $row['Delay_Days'] . '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
