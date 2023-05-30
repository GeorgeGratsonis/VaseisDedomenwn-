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
                            <label for="category">Category:</label>
                            <select name="category" id="category">
                                <option value="12">Self-Help</option>
                                <option value="1">Fiction</option>
                                <option value="2">Non-Fiction</option>
                                <option value="3">Mystery</option>
                                <option value="4">Sci-Fi</option>
                                <option value="5">Romance</option>
                                <option value="6">Thriller</option>
                                <option value="8">Biography</option>
                                <option value="9">History</option>
                                <option value="10">Fantasy</option>
                            </select>
                            <button type="submit" class="btn btn-primary" id="show-btn">Submit</button>
                        </form>

                        <?php
                        include 'connection.php';

                        $selectedCategory = isset($_GET['category']) && !empty($_GET['category']) ? $_GET['category'] : null;

                        $authorQuery = "SELECT DISTINCT CONCAT(Author.First_Name, ' ', Author.Last_Name) AS Author_Fullname
                            FROM Author
                            JOIN Book_Author ON Author.Author_ID = Book_Author.Author_ID
                            JOIN Book ON Book_Author.Book_ID = Book.Book_ID
                            JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
                            JOIN Category ON Book_Category.Category_ID = Category.Category_ID";

                        if (!empty($selectedCategory)) {
                            // Append WHERE clause if a category is selected
                            $authorQuery .= " WHERE Category.Category_ID = $selectedCategory";
                        }

                        $authorResult = mysqli_query($conn, $authorQuery);

                        $professorQuery = "SELECT DISTINCT CONCAT(User.First_Name, ' ', User.Last_Name) AS Professor_Fullname
                            FROM User
                            JOIN Borrowing ON User.User_ID = Borrowing.User_ID
                            JOIN Book ON Borrowing.Book_ID = Book.Book_ID
                            JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
                            JOIN Category ON Book_Category.Category_ID = Category.Category_ID
                            WHERE User.Role = 'Professor'";

if (!empty($selectedCategory)) {
    // Append AND clause if a category is selected
    $professorQuery .= " AND Category.Category_ID = $selectedCategory";
}

$professorResult = mysqli_query($conn, $professorQuery);

if (!$authorResult || !$professorResult) {
    echo '<h1 style="margin-top: 5rem;">Error occurred while fetching data!</h1>';
} else {
    echo '<div class="table-responsive">';
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Author</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_row($authorResult)) {
        echo '<tr>';
        echo '<td>' . $row[0] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';

    echo '<div class="table-responsive">';
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Professor</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_row($professorResult)) {
        echo '<tr>';
        echo '<td>' . $row[0] . '</td>';
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