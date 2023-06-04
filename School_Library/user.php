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
    <link rel = "stylesheet" href = "css/admin.css">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel = "stylesheet" href = "bootstrap/css/bootstrap.min.css">
</head>


<body>
    <nav class="navbar navbar-light navbar-expand-md" id="nav-bar">
        <div id="navbar-div" class="container-fluid">
            <a class="navbar-brand" id="nav-bar-text">School Library - User Page</a>
            <a id="navbar-items" href="logout.php">
                <i class="fa fa-home "></i> Log out
            </a>
        </div>
    </nav>

    <div class="container" id="row-container">
        <div class="row" id="row">
            <div class="col-md-4 box2">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Borrower's Card</h4>
                        <p class="card-text" id="paragraph">View your information</p>
                        <a class="btn btn-primary" id="show-btn" href="userinfo.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Search For Books</h4>
                        <p class="card-text" id="paragraph">Search criteria: title/category/author<br></p>
                        <a class="btn btn-primary" id="show-btn" href="searchbooks.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Borrowed Books</h4>
                        <p class="card-text" id="paragraph">List of all books you borrowed<br></p>
                        <a class="btn btn-primary" id="show-btn" href="borrowedbooks.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Reservations</h4>
                        <p class="card-text" id="paragraph">View your active reservations<br></p>
                        <a class="btn btn-primary" id="show-btn" href="activereservations.php">Show</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src = "{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>
    
</body>

</html>