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
        .error-message {
            color: red;
            font-size: 18px;
        }
        .noerror-message {
            color: green;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md" id="nav-bar">
        <div id="navbar-div" class="container-fluid">
            <a class="navbar-brand" id="nav-bar-text" href="libraryoperator.php">School Library - Library Operator Page</a>
            <a id="navbar-items" href="logout.php">
                <i class="fa fa-home" href="logout.php"></i> Log out
            </a>
        </div>
    </nav>

    <div class="container">
    <div class="row" id="row">
        <div class="col-md-12">
            <form class="form-horizontal" name="student-form" method="POST">

                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">User Fullname</label>
                    <select name="user">
                        <option value="" selected disabled>Select User</option>
                        <?php                    
                            $query = "SELECT * FROM User WHERE LibraryOperator_ID = $operator_data[LibraryOperator_ID] AND Approved = TRUE";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_row($result)) {
                                echo '<option value="' . $row[0] . '">' . $row[3] . ' ' . $row[4] .' ('. $row[6] .')</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">Book Title</label>
                    <select name="book">
                        <option value="" selected disabled>Select Book</option>
                        <?php                    
                            $query = "SELECT * FROM Book
                                JOIN Book_LibraryOperator ON Book_LibraryOperator.Book_ID = Book.Book_ID
                                WHERE Book_LibraryOperator.LibraryOperator_ID = '$operator_data[LibraryOperator_ID]'";                  
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_row($result)) {
                                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                            }
                        ?>
                    </select>
                    </div>
                <button type="submit" class="btn btn-primary" id="show-btn" name="submit_add_borrowing">Submit</button>
                <button type="submit" class="btn btn-primary" id="show-btn" formaction="seeborrowings.php">Back</button>
            </form>
        </div>
        <div class="form-group col-sm-3 mb-3">
            <?php
                if(isset($_POST['submit_add_borrowing'])){
                    
                    $user = $_POST['user'];
                    $book = $_POST['book'];
                    $borrowingDate = date("Y-m-d");
                    $returnDate = date("Y-m-d", strtotime("+7 days", strtotime($borrowingDate)));
                    $borrowingDate = "'" . $borrowingDate . "'";
                    $returnDate = "'" . $returnDate . "'";

                    if (empty($user) || empty($book)) {
                        echo "<hr><span class='error-message'>Please fill in all the fields!</span>";
                    } 
                    else{
                        try {
                            $query = "INSERT INTO Borrowing (Borrowing_Date, Return_Date, User_ID, LibraryOperator_ID, Book_ID) 
                                VALUES ($borrowingDate, $returnDate, '$user', '$operator_data[LibraryOperator_ID]', '$book')";
                            mysqli_query($conn, $query);
                            echo "<hr><span class='noerror-message'>Borrowing submitted!</span>";
                        } catch (Exception $e) {
                            echo "<hr><span class='error-message'>" . $e->getMessage() . "</span>";
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