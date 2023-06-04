<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';

    $user_data = check_LibraryOperator_login($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>User Reviews</title>
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
            <a class="navbar-brand" id="nav-bar-text"  href="libraryoperator.php">School Library - Library Operator Page</a>
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
                                <input type="text" class="form-control" name="userFullname" placeholder="Search by User Full Name" aria-label="Search">
                                <select name="category" id="category">
                                    <option value="">Select Category</option>
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
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>

                        <?php
                            include 'connection.php';

                            $userFullname = $_GET['userFullname'] ?? '';
                            $categoryName = $_GET['category'] ?? '';

                            if (!empty($userFullname) && !empty($categoryName)) {
                                $query = "SELECT CONCAT(User.First_Name, ' ', User.Last_Name) AS User_Fullname, AVG(Review.Rating) AS User_Average_Rating
                                        FROM User
                                        JOIN Review ON User.User_ID = Review.User_ID
                                        JOIN Book_Category ON Review.Book_ID = Book_Category.Book_ID
                                        JOIN Category ON Book_Category.Category_ID = Category.Category_ID
                                        WHERE CONCAT(User.First_Name, ' ', User.Last_Name) = ? AND Category.Name = ?
                                        GROUP BY User.User_ID, Category.Name";

                                $stmt = $conn->prepare($query);
                                $stmt->bind_param('ss', $userFullname, $categoryName);
                            } else if (!empty($userFullname)) {
                                $query = "SELECT CONCAT(User.First_Name, ' ', User.Last_Name) AS User_Fullname, Category.Name AS Category, AVG(Review.Rating) AS User_Average_Rating
                                        FROM User
                                        JOIN Review ON User.User_ID = Review.User_ID
                                        JOIN Book_Category ON Review.Book_ID = Book_Category.Book_ID
                                        JOIN Category ON Book_Category.Category_ID = Category.Category_ID
                                        WHERE CONCAT(User.First_Name, ' ', User.Last_Name) = ?
                                        GROUP BY User.User_ID, Category.Name";

                                $stmt = $conn->prepare($query);
                                $stmt->bind_param('s', $userFullname);
                            } else if (!empty($categoryName)) {
                                $query = "SELECT CONCAT(User.First_Name, ' ', User.Last_Name) AS User_Fullname, AVG(Review.Rating) AS User_Average_Rating
                                        FROM User
                                        JOIN Review ON User.User_ID = Review.User_ID
                                        JOIN Book_Category ON Review.Book_ID = Book_Category.Book_ID
                                        JOIN Category ON Book_Category.Category_ID = Category.Category_ID
                                        WHERE Category.Name = ?
                                        GROUP BY User.User_ID";

                                $stmt = $conn->prepare($query);
                                $stmt->bind_param('s', $categoryName);
                            } else {
                                echo '<h1 style="margin-top: 5rem;">No Reviews found!</h1>';
                                return;
                            }

                            $stmt->execute();
                            $result = $stmt->get_result();

                            if (mysqli_num_rows($result) == 0) {
                                echo '<h1 style="margin-top: 5rem;">No Reviews found!</h1>';
                            } else {
                                echo '<div class="table-responsive">';
                                echo '<table class="table">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>User Full Name</th>';
                                echo '<th>Category</th>';
                                echo '<th>User Average Rating</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>';
                                    echo '<td>' . $row['User_Fullname'] . '</td>';
                                    if (isset($row['Category'])) {
                                        echo '<td>' . $row['Category'] . '</td>';
                                    } else {
                                        echo '<td>' . $categoryName . '</td>';
                                    }
                                    echo '<td>' . number_format($row['User_Average_Rating'], 2) . '</td>';
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
