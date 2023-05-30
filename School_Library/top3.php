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

                        $query = "SELECT C1.Name AS Category1, C2.Name AS Category2, COUNT(*) AS Borrowings
                        FROM Book_Category BC1
                        JOIN Book_Category BC2 ON BC1.Book_ID = BC2.Book_ID AND BC1.Category_ID < BC2.Category_ID
                        JOIN Borrowing B ON BC1.Book_ID = B.Book_ID
                        JOIN Category C1 ON BC1.Category_ID = C1.Category_ID
                        JOIN Category C2 ON BC2.Category_ID = C2.Category_ID
                        GROUP BY C1.Name, C2.Name
                        ORDER BY Borrowings DESC
                        LIMIT 3";

                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) == 0) {
                            echo '<h1 style="margin-top: 5rem;">No Library Operators found!</h1>';
                        } else {
                            echo '<div class="table-responsive">';
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th></th>';
                            echo '<th>Best pairs</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            $count = 1;
                            while ($row = mysqli_fetch_row($result)) {
                                echo '<tr>';
                                echo '<td>' . $count . '</td>';
                                echo '<td>' . $row[0] . ' - ' . $row[1] . '</td>';
                                echo '</tr>';
                                $count++;
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

    <script src="{{ url_for('static', filename='bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
