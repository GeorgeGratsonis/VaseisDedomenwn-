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
            <a class="navbar-brand" id="nav-bar-text" href="admin.php">School Library - Admin Page</a>
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

                        $query = "SELECT CONCAT(Author.First_Name, ' ', Author.Last_Name) AS Author_Fullname, COUNT(*) AS Books_Written
                        FROM Author
                        JOIN Book_Author ON Author.Author_ID = Book_Author.Author_ID
                        GROUP BY Author.Author_ID, Author.First_Name, Author.Last_Name
                        HAVING COUNT(*) <= (
                            SELECT MAX(Book_Count) - 5
                            FROM (
                                SELECT COUNT(*) AS Book_Count
                                FROM Book_Author
                                GROUP BY Author_ID
                            ) AS Counts
                        )
                        ORDER BY Books_Written DESC;";
                        
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) == 0) {
                            echo '<h1 style="margin-top: 5rem;">No Authors found!</h1>';
                        } else {
                            echo '<div class="table-responsive">';
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Authors</th>';
                            echo '<th>Books Written</th>';
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

    &nbsp;
    &nbsp;
    <script src="{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>

</body>

</html>
