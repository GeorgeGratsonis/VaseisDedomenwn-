<?php
session_start();

require_once 'connection.php';
require_once 'functions.php';

$admin_data = check_LibraryOperator_login($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Book Library</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="bootstrap.css">
    <style>
        .error-message {
            color: red;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md" id="nav-bar">
        <div id="navbar-div" class="container-fluid">
            <a class="navbar-brand" id="nav-bar-text" href="admin.php">Book Library - Operator Page</a>
            <a id="navbar-items" href="logout.php">
                <i class="fa fa-home" href="logout.php"></i> Log out
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row" id="row">
            <div class="col-md-12">
                <?php
                $book_id = $_GET['id'];
                $query = "SELECT * FROM Book WHERE Book_ID = $book_id";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $book_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);

                echo '<div class="form-group col-sm-3 mb-3">';
                echo '<label class="form-label">Change information for Book:' . $row['Title'] . '</b></label>';
                echo '<hr></div>';
                ?>
                <form class="form-horizontal" name="book-form" method="POST">

                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Title</label>
                        <input class="form-control" name="title" placeholder="Title" value="<?php echo $row['Title']; ?>">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Publisher</label>
                        <input class="form-control" name="publisher" placeholder="Publisher" value="<?php echo $row['Publisher']; ?>">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New ISBN</label>
                        <input class="form-control" name="isbn" placeholder="ISBN" value="<?php echo $row['ISBN']; ?>">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Number of Pages</label>
                        <input class="form-control" name="pages" placeholder="Number of Pages" value="<?php echo $row['Number_of_pages']; ?>">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Summary</label>
                        <textarea class="form-control" name="summary" rows="4" placeholder="Summary"><?php echo $row['Summary']; ?></textarea>
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Available Copies</label>
                        <input class="form-control" name="copies" placeholder="Available Copies" value="<?php echo $row['Available_copies']; ?>">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Image URL</label>
                        <input class="form-control" name="image" placeholder="Image URL" value="<?php echo $row['Image']; ?>">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Language</label>
                        <input class="form-control" name="language" placeholder="Language" value="<?php echo $row['Language']; ?>">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Keywords</label>
                        <input class="form-control" name="keywords" placeholder="Keywords" value="<?php echo $row['Keywords']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" id="show-btn" name="submit_upd">Submit</button>
                    <button type="submit" class="btn btn-primary" id="show-btn" formaction="booklist.php">Back</button>
                </form>
            </div>
            <div class="form-group col-sm-3 mb-3">
                <?php
                if (isset($_POST['submit_upd'])) {
                    $title = $_POST['title'];
                    $publisher = $_POST['publisher'];
                    $isbn = $_POST['isbn'];
                    $pages = $_POST['pages'];
                    $summary = $_POST['summary'];
                    $copies = $_POST['copies'];
                    $image = $_POST['image'];
                    $language = $_POST['language'];
                    $keywords = $_POST['keywords'];

                    $query = "UPDATE Book 
                              SET `Title` = '$title', `Publisher` = '$publisher', `ISBN` = '$isbn', `Number_of_pages` = '$pages',
                                  `Summary` = '$summary', `Available_copies` = '$copies', `Image` = '$image', `Language` = '$language, `Keywords` = '$keywords'
                              WHERE `Book_ID` = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "sssisissii", $title, $publisher, $isbn, $pages, $summary, $copies, $image, $language, $keywords, $book_id);
                    if (mysqli_stmt_execute($stmt)) {
                        header("Location: ./bookslist.php?error=successupdate");
                        exit();
                    } else {
                        echo "Error while updating record: " . mysqli_error($conn) . "<br>";
                    }
                }
                ?>
            </div>
        </div>
    </div>


    <script src="{{ url_for('static', filename='bootstrap/js/bootstrap.min.js') }}"></script>

</body>

</html>
