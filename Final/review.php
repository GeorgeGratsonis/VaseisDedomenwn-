<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';

	$user_data = check_user_login($conn);

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
            <?php
                $id = $_GET['id'];
                $query = "SELECT book.title FROM book WHERE book_id = $id";
                $res1 = mysqli_query($conn, $query);
                $row = mysqli_fetch_row($res1);

                echo '<div class="form-group col-sm-3 mb-3">';
                    echo '<label class = "form-label">Make a review for book <br><b>' . $row[0] . ':</b></label>';
                    
                echo '<hr></div>';
            
                
                
            ?>
            <form class="form-horizontal" name="student-form" method="POST">
                
                <div class="form-group col-sm-3 mb-3">
                    <label class="form-label">Rating</label>
                    <select name="rating" id="rating">
                        <option value=""></option>
                        <option value="1">1. Strongly Dislike</option>
                        <option value="2">2. Dislike</option>
                        <option value="3">3. Neither Like nor Dislike</option>
                        <option value="4">4. Like</option>
                        <option value="5">5. Strongly Like</option>
                    </select>
                </div>
                <div class="form-group col-sm-6 mb-3">
                    <label class = "form-label">Text</label>
                    <textarea class="form-control" name="text" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" id="show-btn" name="submit_review">Submit</button>
                <button type="submit" class="btn btn-primary" id="show-btn" formaction="borrowedbooks.php">Back</button>
            </form>
        </div>
        <div class="form-group col-sm-3 mb-3">
            <?php
                if (isset($_POST['submit_review'])) {
                    $rating = $_POST['rating'];
                    $text = trim($_POST['text']);
                
                    if (!isset($rating) || $rating === '' || !isset($text) || $text === '') {
                        echo "<hr><span class='error-message'>Please fill in all the fields!</span>";
                    } else {
                        $rating = $_POST['rating'];
                        $text = $_POST['text'];
                        $userid = $user_data['User_ID'];
    
                        $query = "SELECT libraryoperator_id FROM user WHERE user_id = $userid";
                        $res1 = mysqli_query($conn, $query);
                        $row = mysqli_fetch_row($res1);
                        $operatorid = $row[0];

                        if ($user_data['Role'] == 'Student') {
                            $query = "INSERT INTO review (rating, text, book_id, user_id, libraryoperator_id) 
                                VALUES ('$rating', '$text', '$id', '$userid', '$operatorid')";
                        }
                        else {
                            $query = "INSERT INTO review (rating, text, approved, book_id, user_id, libraryoperator_id) 
                                VALUES ('$rating', '$text', 1, '$id', '$userid', '$operatorid')";
                        }
                        if (mysqli_query($conn, $query)) {
                            header("Location: ./borrowedbooks.php?error=successreview");
                            exit();
                        }
                        else{
                            echo "Error while updating record: <br>" . mysqli_error($conn) . "<br>";
                        }      
                    }  
                }
                
            ?>

        </div>
    </div>
    </div>


    <script src = "{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>
    
</body>

</html>