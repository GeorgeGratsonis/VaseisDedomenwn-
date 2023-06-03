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
                        <form method="GET" action="">
                            <label for="category">Category:</label>
                            <select name="category" id="category">
                                <option value="">None</option>
                                <option value="Fiction">Fiction</option>
                                <option value="Non-Fiction">Non-Fiction</option>
                                <option value="Mystery">Mystery</option>
                                <option value="Sci-Fi">Sci-Fi</option>
                                <option value="Romance">Romance</option>
                                <option value="Thriller">Thriller</option>
                                <option value="Biography">Biography</option>
                                <option value="History">History</option>
                                <option value="Fantasy">Fantasy</option>
                                <option value="Self-Help">Self-Help</option>
                            </select>
                            <button type="submit" class="btn btn-primary" id="show-btn">Submit</button>
                        </form>

                        <?php
                        include 'connection.php';

                        $selectedCategory = isset($_GET['category']) ? $_GET['category'] : "";

                        
                        if ($selectedCategory !== "") {
                        $authorQuery = "SELECT DISTINCT CONCAT(Author.First_Name, ' ', Author.Last_Name) AS Author_Fullname
                            FROM Author
                            JOIN Book_Author ON Author.Author_ID = Book_Author.Author_ID
                            JOIN Book ON Book_Author.Book_ID = Book.Book_ID
                            JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
                            JOIN Category ON Book_Category.Category_ID = Category.Category_ID
                            WHERE Category.Name = '$selectedCategory'";

                        $authorResult = mysqli_query($conn, $authorQuery);

                        $teacherQuery = "SELECT DISTINCT CONCAT(User.First_Name, ' ', User.Last_Name) AS Teacher_Fullname
                            FROM User
                            JOIN Borrowing ON User.User_ID = Borrowing.User_ID
                            JOIN Book ON Borrowing.Book_ID = Book.Book_ID
                            JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
                            JOIN Category ON Book_Category.Category_ID = Category.Category_ID
                            WHERE User.Role = 'Teacher'
                            AND Category.Name = '$selectedCategory'";

                        $teacherResult = mysqli_query($conn, $teacherQuery);

                        if (!$authorResult || !$teacherResult) {
                            echo '<h1 style="margin-top: 5rem;">Error occurred while fetching data!</h1>';
                        } else {
                            echo '<div class="table-responsive">';
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Authors</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            if (mysqli_num_rows($authorResult) == 0) {
                                echo '<tr>';
                                echo '<td colspan="1" style="border: none; padding: 0;"><h1 style="margin-top: 1rem;">No Authors found!</h1></td>';
                                echo '</tr>';
                            } else {
                                while ($row = mysqli_fetch_row($authorResult)) {
                                    echo '<tr>';
                                    echo '<td>' . $row[0] . '</td>';
                                    echo '</tr>';
                                }
                            }
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>';
                        
                            echo '<div class="table-responsive">';
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Teachers</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            if (mysqli_num_rows($teacherResult) == 0) {
                                echo '<tr>';
                                echo '<td colspan="1" style="border: none; padding: 0;"><h1 style="margin-top: 1rem;">No Teachers found!</h1></td>';
                                echo '</tr>';
                            } else {
                                while ($row = mysqli_fetch_row($teacherResult)) {
                                    echo '<tr>';
                                    echo '<td>' . $row[0] . '</td>';
                                    echo '</tr>';
                                }
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

<script src="{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>

</body>

</html>