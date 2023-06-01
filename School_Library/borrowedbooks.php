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
            <a class="navbar-brand" id="nav-bar-text"  href="user.php">School Library - User Page</a>
            <a id="navbar-items" href="logout.php">
                <i class="fa fa-home "></i> Log out
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row" id="row">
            <div class="col-md-12 box">
                <div class="card" id="card-container">
                    <div class="card-body" id="card">
                        <?php
                        include 'connection.php';

                        $userid = $user_data['User_ID'];
                        $query = "SELECT Book.Title, Book.Publisher, Book.ISBN, Book.Number_of_pages, Book.Summary, Book.Image, Book.Language, Book.Keywords, Borrowing.Borrowing_Date, Borrowing.Returned
                        FROM Borrowing
                        JOIN User ON Borrowing.User_ID = User.User_ID
                        JOIN Book ON Borrowing.Book_ID = Book.Book_ID
                        WHERE User.User_ID = '$userid';";
                        $result = mysqli_query($conn, $query);
                        
                        if(mysqli_num_rows($result) == 0){
                            echo '<h1 style="margin-top: 5rem;">You have not borrowed any books yet!</h1>';
                        }
                        else{
                            echo '<div class="table-responsive">';
                                echo '<table class="table">';
                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th>Title</th>';
                                            echo '<th>Publisher</th>';
                                            echo '<th>ISBN</th>';
                                            echo '<th>Number of pages</th>';
                                            echo '<th>Summary</th>';
                                            echo '<th>Image</th>';
                                            echo '<th>Language</th>';
                                            echo '<th>Keywords</th>';
                                            echo '<th>Borrowing Date</th>';
                                            echo '<th>Returned</th>';
                                            echo '<th>Make a Review</th>';
                                        echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                    while($row = mysqli_fetch_row($result)){
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
                                            if ($row[9] == 1) {
                                                echo '<td>Yes</td>';
                                            }
                                            else {
                                                echo '<td>No</td>';
                                            }
                                            echo '<td>';
                                                echo '<a type="button" href="./review.php?id=' . $row[0]. '">';
                                                    echo '<i class="fa fa-star"></i>';
                                                echo '</a>';
                                            echo '</td>';
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

    <script src = "{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>
    
</body>

</html>