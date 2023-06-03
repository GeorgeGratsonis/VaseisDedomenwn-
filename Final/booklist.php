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
    <title>School Library</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="bootstrap.css">
    <style>
        #nav-bar {
            background-color: #6957e3;
        }
  
        #show-btn {
            background-color: #6957e3;
            border-radius: 16px;
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
                <i class="fa fa-home"></i> Log out
            </a>
        </div>
    </nav>

    <div class="container">
    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "successupdate") {
                echo "<p class='noerror-message text-center'>Book info updated!</p>";
            }
            else if ($_GET["error"] == "successadd") {
                echo "<p class='noerror-message text-center'>Book added!</p>";
            }
        }
    ?>
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

                            <label for="available-copies">Available Copies:</label>
                            <input type="number" name="available_copies" id="available-copies">

                            <button type="submit" class="btn btn-primary" id="show-btn">Submit</button>
                        </form>

                        <?php
                        include 'connection.php';

                        $selectedTitle = isset($_GET['title']) ? $_GET['title'] : "";
                        $selectedCategory = isset($_GET['category']) ? $_GET['category'] : "";
                        $selectedAuthor = isset($_GET['author']) ? $_GET['author'] : "";
                        $selectedAvailableCopies = isset($_GET['available_copies']) ? $_GET['available_copies'] : "";

                        if ($selectedTitle !== "" || $selectedAuthor !== "" || $selectedCategory !== "" || $selectedAvailableCopies !== "") {
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
                            if ($selectedAvailableCopies !== "") {
                                $whereClause .= "AND Book.Available_copies = '$selectedAvailableCopies'";
                            }

                            $query = "SELECT Book.Title, Book.Publisher, Book.ISBN, Book.Number_of_pages, Book.Summary, Book.Available_copies, Book.Image, Book.Language, Book.Keywords,
                            (SELECT GROUP_CONCAT(DISTINCT CONCAT(Author.First_Name, ' ', Author.Last_Name)) FROM Book_Author
                            JOIN Author ON Book_Author.Author_ID = Author.Author_ID
                            WHERE Book_Author.Book_ID = Book.Book_ID) AS Authors,
                            (SELECT GROUP_CONCAT(DISTINCT Category.Name) FROM Book_Category
                            JOIN Category ON Book_Category.Category_ID = Category.Category_ID
                            WHERE Book_Category.Book_ID = Book.Book_ID) AS Categories,
                            Book.Book_ID
                            FROM Book
                            JOIN Book_Author ON Book.Book_ID = Book_Author.Book_ID
                            JOIN Author ON Book_Author.Author_ID = Author.Author_ID
                            JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
                            JOIN Category ON Book_Category.Category_ID = Category.Category_ID
                            JOIN book_libraryoperator ON Book.Book_ID = book_libraryoperator.Book_ID
                            WHERE Book_LibraryOperator.LibraryOperator_ID = '$operator_data[LibraryOperator_ID]' $whereClause
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
                                echo '<th></th>';
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
                                        echo '<a href="./updatebook.php?id=' . $row[11]. '">';
                                            echo '<i class="fa fa-edit"></i>';
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
                        <br>
                        <a class="btn btn-primary" id="show-btn" href="addbook.php">Add Book</a>     
                    </div>
                    <a action></a>
                </div>
            </div>
        </div>
        &nbsp;
        &nbsp;
    <script src = "{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>
    
    </body>
    
    </html>