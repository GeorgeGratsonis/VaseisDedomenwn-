<?php
session_start();

require_once 'connection.php';
require_once 'functions.php';

$operator_data = check_libraryoperator_login($conn);

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
        .error-message {
            color: red;
            font-size: 18px;
        }
        .author-name-input {
            width: 325px;
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
        <div class="row" id="row">
            <div class="col-md-12">
                <?php
                $book_id = $_GET['id'];
                $query = "SELECT * FROM Book WHERE Book_ID = $book_id";
                $res1 = mysqli_query($conn, $query);
                $row = mysqli_fetch_row($res1);

                echo '<div class="form-group col-sm-3 mb-3">';
                echo '<label class="form-label">Change information for book: <br><b>' . $row[1] . '</b></label>';
                echo '<hr></div>';
                ?>
                <form class="form-horizontal" name="student-form" method="POST">
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Title</label>
                        <input class="form-control" name="title" placeholder="Title">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Publisher</label>
                        <input class="form-control" name="publisher" placeholder="Publisher">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New ISBN</label>
                        <input class="form-control" name="isbn" placeholder="ISBN">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Number of Pages</label>
                        <input class="form-control" name="pages" placeholder="Number of Pages" type="number" min="50" max="800">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Summary</label>
                        <textarea class="form-control" name="summary" rows="5" placeholder="Summary"></textarea>
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Available Copies</label>
                        <input class="form-control" name="copies" placeholder="Available Copies" type="number" min="0" max="20">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Image URL</label>
                        <input class="form-control" name="image" placeholder="Image URL">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Language</label>
                        <select class="form-control" name="language">
                            <option value=""></option>
                            <option value="English">English</option>
                            <option value="Spanish">Spanish</option>
                            <option value="French">French</option>
                            <option value="Greek">Greek</option>
                            <option value="Italian">Italian</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Keywords</label>
                        <input class="form-control" name="keywords" placeholder="Keywords">
                    </div>
                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">Number of Authors</label>
                        <input class="form-control" name="author_count" placeholder="Number of Authors" type="number" min="1" max="3">
                    </div>

                    <div id="authors-container">
                    </div>

                    <div class="form-group col-sm-3 mb-3">
                        <label class="form-label">New Categories</label>
                        <div>
                            <label for="category1">
                                <input type="checkbox" id="category1" name="categories[]" value="1"> Fiction
                            </label><br>
                            <label for="category2">
                                <input type="checkbox" id="category2" name="categories[]" value="2"> Non-Fiction
                            </label><br>
                            <label for="category3">
                                <input type="checkbox" id="category3" name="categories[]" value="3"> Mystery
                            </label><br>
                            <label for="category4">
                                <input type="checkbox" id="category4" name="categories[]" value="4"> Sci-Fi
                            </label><br>
                            <label for="category5">
                                <input type="checkbox" id="category5" name="categories[]" value="5"> Romance
                            </label><br>
                            <label for="category6">
                                <input type="checkbox" id="category6" name="categories[]" value="6"> Thriller
                            </label><br>
                            <label for="category7">
                                <input type="checkbox" id="category7" name="categories[]" value="7"> Biography
                            </label><br>
                            <label for="category8">
                                <input type="checkbox" id="category8" name="categories[]" value="8"> History
                            </label><br>
                            <label for="category9">
                                <input type="checkbox" id="category9" name="categories[]" value="9"> Fantasy
                            </label><br>
                            <label for="category10">
                                <input type="checkbox" id="category10" name="categories[]" value="10"> Self-Help
                            </label><br>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="show-btn" name="submit_upd_book">Submit</button>
                    <button type="submit" class="btn btn-primary" id="show-btn" formaction="booklist.php">Back</button>
                </form>
            </div>
            <div class="form-group col-sm-3 mb-3">
                <?php
                if (isset($_POST['submit_upd_book'])) {
                    $book_id = $_GET['id'];
                    $title = $_POST['title'];
                    $publisher = $_POST['publisher'];
                    $isbn = $_POST['isbn'];
                    $pages = $_POST['pages'];
                    $summary = $_POST['summary'];
                    $copies = $_POST['copies'];
                    $image = $_POST['image'];
                    $language = $_POST['language'];
                    $keywords = $_POST['keywords'];
                    $categories = isset($_POST['categories']) ? $_POST['categories'] : [];
                    $authorCount = $_POST['author_count'];
                
                    if (empty($title)) {
                        $title = $row[1];
                    }
                    if (empty($publisher)) {
                        $publisher = $row[2];
                    }
                    if (empty($isbn)) {
                        $isbn = $row[3];
                    }
                    if (empty($pages)) {
                        $pages = $row[4];
                    }
                    if (empty($summary)) {
                        $summary = $row[5];
                    }
                    if (empty($copies)) {
                        $copies = $row[6];
                    }
                    if (empty($image)) {
                        $image = $row[7];
                    }
                    if (empty($language)) {
                        $language = $row[8];
                    }
                    if (empty($keywords)) {
                        $keywords = $row[9];
                    }
                
                    if (invalidisbn($isbn) !== false) {
                        echo "<hr><span class='error-message'>Invalid ISBN format!</span>"; 
                    }
                    else if(invalidimageurl($image) !== false){
                        echo "<hr><span class='error-message'>Invalid Image URL format!</span>";
                    } 
                    else if (isbnexists($conn, $isbn, $book_id) !== false) {
                        echo "<hr><span class='error-message'>ISBN already exists!</span>";
                    } 
                    else if (titleexists($conn, $title, $book_id) !== false) {
                        echo "<hr><span class='error-message'>Book Title already exists!</span>";
                    } 
                    else{
                    if (!empty($authorCount)) {
                        $authorFirstNames = $_POST['authorfirstname'];
                        $authorLastNames = $_POST['authorlastname'];
                
                        $query = "DELETE FROM book_author WHERE book_id = '$book_id'";
                        mysqli_query($conn, $query);
                
                        for ($i = 0; $i < $authorCount; $i++) {
                            $firstName = $authorFirstNames[$i];
                            $lastName = $authorLastNames[$i];
                
                            $query = "SELECT Author_ID FROM Author WHERE First_Name = '$firstName' AND Last_Name = '$lastName'";
                            $result = mysqli_query($conn, $query);
                
                            if (mysqli_num_rows($result) == 0) {
                                $query = "INSERT INTO Author (First_Name, Last_Name) VALUES ('$firstName', '$lastName')";
                                mysqli_query($conn, $query);
                            }
                            $query = "SELECT Author_ID FROM Author WHERE First_Name = '$firstName' AND Last_Name = '$lastName'";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_row($result);
                            $author_id = $row[0];
                            $query = "INSERT INTO book_author (book_id, author_id) VALUES ('$book_id', '$author_id')";
                            mysqli_query($conn, $query);
                        }
                    }
                
                    if (!empty($categories)) {
                        $query = "DELETE FROM book_category WHERE book_id = '$book_id'";
                        mysqli_query($conn, $query);
                
                        foreach ($categories as $category_id) {
                            $query = "INSERT INTO book_category (Book_ID, Category_ID) VALUES ('$book_id', '$category_id')";
                            mysqli_query($conn, $query);
                        }
                    }
                
                    $query = "UPDATE Book 
                        SET Title = '$title', Publisher = '$publisher', ISBN = '$isbn', Number_of_pages = '$pages',
                            Summary = '$summary', Available_copies = '$copies', Image = '$image', Language = '$language', Keywords = '$keywords'
                        WHERE Book_ID = '$book_id'";
                
                    if (mysqli_query($conn, $query)) {
                        echo '<script>window.location.href="./booklist.php?error=successupdate";</script>';
                        exit();
                    } else {
                        echo "Error while updating record: " . mysqli_error($conn) . "<br>";
                    }
                }
                }
                ?>
            </div>
        </div>
    </div>


    <script src="{{ url_for('static', filename='bootstrap/js/bootstrap.min.js') }}"></script>

    <script>
        function generateAuthorInputs() {
            var authorCount = parseInt(document.querySelector('input[name="author_count"]').value);

            var container = document.getElementById('authors-container');
            container.innerHTML = '';

            for (var i = 1; i <= authorCount; i++) {
                var authorFirstNameInput = document.createElement('input');
                authorFirstNameInput.className = 'form-control author-name-input';
                authorFirstNameInput.name = 'authorfirstname[]';
                authorFirstNameInput.placeholder = 'Author ' + i + ' First Name';

                var authorLastNameInput = document.createElement('input');
                authorLastNameInput.className = 'form-control author-name-input';
                authorLastNameInput.name = 'authorlastname[]';
                authorLastNameInput.placeholder = 'Author ' + i + ' Last Name';

                container.appendChild(authorFirstNameInput);
                container.appendChild(authorLastNameInput);
            }
        }

        document.querySelector('input[name="author_count"]').addEventListener('change', generateAuthorInputs);

        generateAuthorInputs();
    </script>

</body>

</html>