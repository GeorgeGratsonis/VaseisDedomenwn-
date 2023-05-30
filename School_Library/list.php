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
                        <form method="GET" action="">
                            <label for="month">Month:</label>
                            <select name="month" id="month">
                                <option value="">None</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>

                            <label for="year">Year:</label>
                            <select name="year" id="year">
                                <option value="">None</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <!-- Add options for the desired years -->
                            </select>

                            <button type="submit" class="btn btn-primary" id="show-btn">Submit</button>
                        </form>

                        <?php
                        include 'connection.php';

                        $selectedMonth = isset($_GET['month']) ? $_GET['month'] : "";
                        $selectedYear = isset($_GET['year']) ? $_GET['year'] : "";

                        $whereClause = "";
                        if ($selectedMonth !== "") {
                            $whereClause .= "AND MONTH(Borrowing.Borrowing_Date) = $selectedMonth";
                        }
                        if ($selectedYear !== "") {
                            $whereClause .= "AND YEAR(Borrowing.Borrowing_Date) = $selectedYear";
                        }

                        $query = "SELECT School.Name AS School_Name, COUNT(Borrowing.Borrowing_ID) AS Borrowings_Count
                            FROM School
                            JOIN User ON School.School_ID = User.School_ID
                            JOIN Borrowing ON User.User_ID = Borrowing.User_ID
                            WHERE 1=1 $whereClause
                            GROUP BY School.School_ID;";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) == 0) {
                            echo '<h1 style="margin-top: 5rem;">No Teachers found!</h1>';
                        } else {
                            echo '<div class="table-responsive">';
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>School</th>';
                            echo '<th>Borrowings Count</th>';
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
