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
            <a class="navbar-brand" id="nav-bar-text">User Reviews - Admin Page</a>
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
                                <input type="text" class="form-control" name="categoryName" placeholder="Search by Category Name" aria-label="Search">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>

                        <?php
                        include 'connection.php';

                        $userFullname = $_GET['userFullname'] ?? '';
                        $categoryName = $_GET['categoryName'] ?? '';

                        $query = "SELECT CONCAT(User.First_Name, ' ', User.Last_Name) As User_Fullname,
                                AVG(Review.Rating) AS User_Average_Rating,
                                Category.Name AS Category,
                                AVG(Review.Rating) AS Category_Average_Rating
                                FROM User
                                JOIN Review ON User.User_ID = Review.User_ID
                                JOIN Book ON Review.Book_ID = Book.Book_ID
                                JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
                                JOIN Category ON Book_Category.Category_ID = Category.Category_ID
                                WHERE 1=1 ";

                        if ($userFullname) {
                            $query .= "AND CONCAT(User.First_Name, ' ', User.Last_Name) LIKE '%$userFullname%' ";
                        }

                        if ($categoryName) {
                            $query .= "AND Category.Name LIKE '%$categoryName%' ";
                        }

                        $query .= "GROUP BY User.User_ID, Category.Category_ID;";

                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) == 0) {
                            echo '<h1 style="margin-top: 5rem;">No Reviews found!</h1>';
                        } else {
                            echo '<div class="table-responsive">';
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>User Full Name</th>';
                            echo '<th>User Average Rating</th>';
                            echo '<th>Category</th>';
                            echo '<th>Category Average Rating</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['User_Fullname'] . '</td>';
                                echo '<td>' . number_format($row['User_Average_Rating'], 2) . '</td>';
                                echo '<td>' . $row['Category'] . '</td>';
                                echo '<td>' . number_format($row['Category_Average_Rating'], 2) . '</td>';
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
