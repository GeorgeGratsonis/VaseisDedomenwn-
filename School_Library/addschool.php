<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';

	$admin_data = check_admin_login($conn);

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
            <a class="navbar-brand" id="nav-bar-text"  href="admin.php">School Library - Admin Page</a>
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
                    <label class = "form-label">Name</label>
                    <input class = "form-control", name="name", placeholder="Name">

                </div>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">Address</label>
                    <input class = "form-control", name="address", placeholder="Address">
                </div>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">City</label>
                    <input class = "form-control", name="city", placeholder="City">
                </div>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">Email Address</label>
                    <input class = "form-control", name="email", placeholder="email@example.com">
                </div>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">Phone Number</label>
                    <input class = "form-control", name="phone", placeholder="Phone Number">
                </div>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">Director</label>
                    <input class = "form-control", name="director", placeholder="Director's Fullname">
                </div>
                <button type="submit" class="btn btn-primary" id="show-btn" name="submit_add">Submit</button>
                <button type="submit" class="btn btn-primary" id="show-btn" formaction="schoolslist.php">Back</button>
            </form>
        </div>
        <div class="form-group col-sm-3 mb-3">
            <?php
                if(isset($_POST['submit_add'])){
                    
                    $name = $_POST['name'];
                    $address = $_POST['address'];
                    $city = $_POST['city'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];
                    $director = $_POST['director'];

                    if (empty($name) || empty($address) || empty($city) || empty($email) || empty($phone) || empty($director)) {
                        echo "<hr><span class='error-message'>Please fill in all the fields!</span>";
                    } else if (invalidname($director) !== false) {
                        echo "<hr><span class='error-message'>Choose a proper director name!</span>"; 
                    }
                    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        echo "<hr><span class='error-message'>Invalid email format!</span>";
                    } 
                    else if (invalidphone($phone) !== false) {
                        echo "<hr><span class='error-message'>Invalid phone number format!</span>";
                    } 
                    else if (phoneexists($conn, $phone, 0) === true) {
                        echo "<hr><span class='error-message'>Phone number already taken!</span>";
                    } 
                    else if (schoolexists($conn, $name, 0) === true) {
                        echo "<hr><span class='error-message'>School name already exists!</span>";
                    } 
                    else{
                        $query = "INSERT INTO school (name, address, city, email, phone_number, director_fullname, admin_id)
                                VALUES ('$name', '$address', '$city', '$email', '$phone', '$director', $admin_data[Admin_ID])";
                        if (mysqli_query($conn, $query)) {
                            header("Location: ./schoolslist.php?error=successadd");
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