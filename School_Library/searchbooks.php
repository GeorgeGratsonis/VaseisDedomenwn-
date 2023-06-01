<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';

	$user_data = check_user_login($conn);

?>

<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>
        School Library
    </title>
    <link rel = "stylesheet" href = "css/styles.css">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel = "stylesheet" href = "bootstrap/css/bootstrap.min.css">
    <style>
        #nav-bar {
            background-color: #6957e3;
        }
  
        #show-btn {
            background-color: #6957e3;
            border-radius: 16px;
        }
    </style>
</head>


<body>
    <nav class="navbar navbar-light navbar-expand-md" id="nav-bar"> 
        <div id="navbar-div" class="container-fluid">
            <a class="navbar-brand" id="nav-bar-text" href="user.php">School Library - User Page</a>
            <a id="navbar-items" href="logout.php">
                <i class="fa fa-home "></i> Log out
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row" id="row">
            <div class="col-md-12">
                <div class="card" id="card-container">
                    <div class="card-body" id="card">
                        <form method="GET" action="">
                            <label for="title">Book Title:</label>
                            <input type="text" name="title" id="title">

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

                            <label for="author">Author:</label>
                            <input type="text" name="author" id="author">

                            <button type="submit" class="btn btn-primary" id="show-btn">Submit</button>
                        </form>

                        <?php
                        include 'connection.php';

                        $selectedTitle = isset($_GET['title']) ? $_GET['title'] : "";
                        $selectedCategory = isset($_GET['category']) ? $_GET['category'] : "";
                        $selectedAuthor = isset($_GET['author']) ? $_GET['author'] : "";

                        if ($selectedTitle !== "" || $selectedAuthor !== "" || $selectedCategory !== "") {
                        $whereClause = "";
                        if ($selectedTitle !== "") {
                            $whereClause .= "AND Book.Title = '$selectedTitle'";
                        }
                        if ($selectedAuthor !== "") {
                            $whereClause .= "AND CONCAT(Author.First_Name, ' ', Author.Last_Name) = '$selectedAuthor'";
                        }
                        if ($selectedCategory !== "") {
                            $whereClause .= "AND Category.Name = '$selectedCategory'";
                        }

                        $query = "SELECT Book.Title, Book.Publisher, Book.ISBN, Book.Number_of_pages, Book.Summary, Book.Available_copies, Book.Image, Book.Language, Book.Keywords,
                        GROUP_CONCAT(DISTINCT CONCAT(Author.First_Name, ' ', Author.Last_Name)) AS Authors, GROUP_CONCAT(DISTINCT Category.Name) AS Categories
                        FROM Book
                        JOIN Book_Author ON Book.Book_ID = Book_Author.Book_ID
                        JOIN Author ON Book_Author.Author_ID = Author.Author_ID
                        JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
                        JOIN Category ON Book_Category.Category_ID = Category.Category_ID
                        WHERE 1=1 $whereClause
                        GROUP BY Book.Book_ID;";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) == 0) {
                            echo '<h1 style="margin-top: 5rem;">No Books found!</h1>';
                        } else {
                            echo '<div class="table-responsive">';
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Title</th>';
                            echo '<th>Publisher</th>';
                            echo '<th>ISBN</th>';
                            echo '<th>Number of pages</th>';
                            echo '<th>Summary</th>';
                            echo '<th>Available copies</th>';
                            echo '<th>Image</th>';
                            echo '<th>Language</th>';
                            echo '<th>Keywords</th>';
                            echo '<th>Authors</th>';
                            echo '<th>Categories</th>';
                            echo '<th>Borrow this Book</th>';
                            echo '<th>Make a Reservation for this Book</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            while ($row = mysqli_fetch_row($result)) {
                                echo '<tr>';
                                echo '<td>' . $row[0] . '</td>';
                                echo '<td>' . $row[1] . '</td>';
                                echo '<td>' . $row[2] . '</td>';
                                echo '<td>' . $row[3] . '</td>';
                                echo '<td>' . $row[4] . '</td>';
                                echo '<td>' . $row[5] . '</td>';
                                echo '<td>' . $row[6] . '</td>';
                                echo '<td>' . $row[7] . '</td>';
                                echo '<td>' . $row[8] . '</td>';
                                echo '<td>' . $row[9] . '</td>';
                                echo '<td>' . $row[10] . '</td>';
                                echo '<td>';
                                echo '<a type="button" href="./borrowing.php?id=' . $row[0]. '">';
                                echo '<i class="fa fa-book"></i>';
                                echo '</a>';
                                echo '</td>';
                                echo '<td>';
                                echo '<a type="button" href="./reservation.php?id=' . $row[0]. '">';
                                echo '<i class="fa fa-calendar"></i>';
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

    <script src="{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>

</body>

</html>