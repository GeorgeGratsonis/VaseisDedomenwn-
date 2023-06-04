<?php 
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';

	$operator_data = check_libraryoperator_login($conn);

?>

<!DOCTYPE html>
<html lang = "en">

<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>
        School Library
    </title>
    <link rel = "stylesheet" href = "admin.css">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel = "stylesheet" href = "bootstrap.css">
    

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


    <div class="container" id="row-container">
        <div class="row" id="row">
            <div class="col-md-4 box2">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Operator Info</h4>
                        <p class="card-text" id="paragraph">View your information</p>
                        <a class="btn btn-primary" id="show-btn" href="operatorinfo.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">School's Library Books</h4>
                        <p class="card-text" id="paragraph">Search criteria: Title/Category/Author/Copies<br></p>
                        <a class="btn btn-primary" id="show-btn" href="booklist.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Delayed Borrowings</h4>
                        <p class="card-text" id="paragraph">Search criteria: User/Days of Delay<br></p>
                        <a class="btn btn-primary" id="show-btn" href="operatorborrowings.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 box1">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Average Ratings</h4>
                        <p class="card-text" id="paragraph">Search criteria: User/Categories <br></p>
                        <a class="btn btn-primary" id="show-btn" href="operatorratings.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">School's Users</h4>
                        <p class="card-text" id="paragraph">See your school users<br></p>
                        <a class="btn btn-primary" id="show-btn" href="operatorusers.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Borrowings</h4>
                        <p class="card-text" id="paragraph">See your school's borrowings<br></p>
                        <a class="btn btn-primary" id="show-btn" href="seeborrowings.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 box1">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Reviews</h4>
                        <p class="card-text" id="paragraph">Accept or reject student's reviews<br></p>
                        <a class="btn btn-primary" id="show-btn" href="seereviews.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Reservations</h4>
                        <p class="card-text" id="paragraph">See your school's reservations<br></p>
                        <a class="btn btn-primary" id="show-btn" href="seereservations.php">Show</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script src = "{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>
    
</body>

</html>
