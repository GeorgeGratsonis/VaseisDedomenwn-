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
    <link rel="stylesheet" href="styles.css">
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
            <a class="navbar-brand" id="nav-bar-text"  href="operator.php">School Library - operator Page</a>
            <a id="navbar-items" href="logout.php">
                <i class="fa fa-home" href="logout.php"></i> Log out
            </a>
        </div>
    </nav>

    <div class="container">
    <div class="row" id="row">
        <div class="col-md-12">
            <?php
                $id = $_GET['id'];
                $query = "SELECT libraryoperator.first_name, libraryoperator.last_name, libraryoperator.username FROM libraryoperator WHERE libraryoperator_id = $id";
                $res1 = mysqli_query($conn, $query);
                $row = mysqli_fetch_row($res1);

                echo '<div class="form-group col-sm-3 mb-3">';
                    echo '<label class = "form-label">Change your information:</label>';
                    
                echo '<hr></div>';
            
                
                
            ?>
            <form class="form-horizontal" name="student-form" method="POST">
                
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">New First Name</label>
                    <input class = "form-control", name="firstname", placeholder="First Name">
                </div>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">New Last Name</label>
                    <input class = "form-control", name="lastname", placeholder="Last Name">
                </div>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">New Username</label>
                    <input class = "form-control", name="username", placeholder="Username">
                </div>
                <button type="submit" class="btn btn-primary" id="show-btn" name="submit_upd_operator">Submit</button>
                <button type="submit" class="btn btn-primary" id="show-btn" formaction="operatorinfo.php">Back</button>
            </form>
        </div>
        <div class="form-group col-sm-3 mb-3">
            <?php
                if(isset($_POST['submit_upd_operator'])){
                    
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $username = $_POST['username'];
                    if ($firstname == "") {
                        $firstname = $row[0];
                    }
                    if ($lastname == "") {
                        $lastname = $row[1];
                    }
                    if ($username == "") {
                        $username = $row[2];
                    }
                    
                    if (invalidfirstname($firstname) !== false) {
                        echo "<hr><span class='error-message'>Choose a proper first name!</span>"; 
                    }
                    else if (invalidlastname($lastname) !== false) {
                        echo "<hr><span class='error-message'>Choose a proper last name!</span>"; 
                    }
                    else{
                        $query = "UPDATE libraryoperator 
                                SET first_name = '$firstname', last_name = '$lastname', username = '$username'
                                WHERE libraryoperator_id = $id";
                        if (mysqli_query($conn, $query)) {
                            header("Location: ./operatorinfo.php?error=successupdate");
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