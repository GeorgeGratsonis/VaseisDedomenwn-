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
            <a class="navbar-brand" id="nav-bar-text">School Library - Admin Page</a>
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
                        <?php
                        include 'connection.php';

                        $query = "SELECT School.Name AS School_Name, COUNT(Borrowing.Borrowing_ID) AS Books_Borrowed
                        FROM School
                        JOIN User ON School.School_ID = User.School_ID
                        JOIN Borrowing ON User.User_ID = Borrowing.User_ID
                        WHERE YEAR(Borrowing.Borrowing_Date) = 2023
                        AND MONTH(Borrowing.Borrowing_Date) = 5
                        GROUP BY School.School_ID;
                        ";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) == 0) {
                            echo '<h1 style="margin-top: 5rem;">No Teachers found!</h1>';
                        } else {
                            echo '<div class="table-responsive">';
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Authors</th>';
                            echo '<th>Books written</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            while ($row = mysqli_fetch_row($result)) {
                                echo '<tr>';
                                echo '<td>' . $row[0] . '</td>';
                                echo '<td>' . $row[1] . '</td>';
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

    <script src="{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>

</body>

</html>
