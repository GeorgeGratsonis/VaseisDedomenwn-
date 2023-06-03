<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>School Library</title>
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
                            <div class="input-group">
                                <input type="text" class="form-control" name="title" placeholder="Search by Title" aria-label="Search">
                                <input type="text" class="form-control" name="category" placeholder="Search by Category" aria-label="Search">
                                <input type="text" class="form-control" name="author" placeholder="Search by Author" aria-label="Search">
                                <input type="number" class="form-control" name="copies" placeholder="Search by Available Copies" aria-label="Search">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>

                        <?php
                        include 'connection.php';

                        $title = $_GET['title'] ?? '';
                        $category = $_GET['category'] ?? '';
                        $author = $_GET['author'] ?? '';
                        $copies = $_GET['copies'] ?? '';

                        $query = "SELECT Book.Title, GROUP_CONCAT(DISTINCT CONCAT(Author.First_Name, ' ', Author.Last_Name) SEPARATOR ', ') AS Authors
                        FROM Book
                        JOIN Book_Author ON Book.Book_ID = Book_Author.Book_ID
                        JOIN Author ON Book_Author.Author_ID = Author.Author_ID
                        JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
                        JOIN Category ON Book_Category.Category_ID = Category.Category_ID
                        WHERE 1=1 ";

                        if ($title) {
                            $query .= "AND Book.Title LIKE '%$title%' ";
                        }

                        if ($category) {
                            $query .= "AND Category.Name LIKE '%$category%' ";
                        }

                        if ($author) {
                            $query .= "AND CONCAT(Author.First_Name, ' ', Author.Last_Name) LIKE '%$author%' ";
                        }

                        if ($copies) {
                            $query .= "AND Book.Available_copies = '$copies' ";
                        }

                        $query .= "GROUP BY Book.Title;";

                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) == 0) {
                            echo '<h1 style="margin-top: 5rem;">No Books found!</h1>';
                        } else {
                            echo '<div class="table-responsive">';
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Book Title</th>';
                            echo '<th>Authors</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['Title'] . '</td>';
                                echo '<td>' . $row['Authors'] . '</td>';
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
