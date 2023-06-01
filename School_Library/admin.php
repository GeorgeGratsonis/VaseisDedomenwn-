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
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="bootstrap.css">
    <style>
        .error-message {
            color: red;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: -47px;
        }

        .noerror-message {
            color: green;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: -47px;
        }

        .button {
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            padding: 5px 10px;
            height: 100%;
            width: 100%;
            border: none;
            outline: none;
            border-radius: 4px;
            background: #969bd8;
            color: #fff;
        }

        .button:hover {
            background: #211d52;
            transition: all 0.3s ease;
        }

        #navbar-items {
            display: flex;
            align-items: center;
        }

        #navbar-items i {
            margin-right: 10px;
        }

        #navbar-items .button {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md" id="nav-bar">
        <div id="navbar-div" class="container-fluid">
            <a class="navbar-brand" id="nav-bar-text">School Library - Admin Page</a>
            <div id="navbar-items">
                <form action="backup.php" method="post">
                    <button type="submit" class="button">Backup</button>
                </form>
                &nbsp;
                &nbsp;
                <form action="restore.php" method="post">
                    <button type="submit" class="button">Restore</button>
                </form>
                &nbsp;
                &nbsp;
                <a id="navbar-items" href="logout.php"><i class="fa fa-home"></i> Log out</a> 
            </div>
        </div>
    </nav>

    <div class="container" id="row-container">
    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "successbackup") {
                echo "<p class='noerror-message text-center'>Successful backup!</p>";
            } else if ($_GET["error"] == "successrestore") {
                echo "<p class='noerror-message text-center'>Successful restore!</p>";
            } else if ($_GET["error"] == "failedrestore") {
                echo "<p class='error-message text-center'>Restore failed!</p>";
            }
        }
    ?>
        <div class="row" id="row">
            <div class="col-md-4 box2">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Admin Info</h4>
                        <p class="card-text" id="paragraph">View your information</p>
                        <a class="btn btn-primary" id="show-btn" href="admininfo.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Library Operators with same Loans</h4>
                        <p class="card-text" id="paragraph">View operators who have loaned the same amount of books (over 20) in a year<br></p>
                        <a class="btn btn-primary" id="show-btn" href="sameloans.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Top 3 Pairing of Book Categories</h4>
                        <p class="card-text" id="paragraph">View the 3 most preferred categories pairs<br></p>
                        <a class="btn btn-primary" id="show-btn" href="top3.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 box1">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Top Borrowers</h4>
                        <p class="card-text" id="paragraph">View teachers under 40 years old who have borrowed the most books</p>
                        <a class="btn btn-primary" id="show-btn" href="topborrowers.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Borrowings per School</h4>
                        <p class="card-text" id="paragraph">Search criteria: Year/Month<br></p>
                        <a class="btn btn-primary" id="show-btn" href="schoolborrowing.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Least liked authors</h4>
                        <p class="card-text" id="paragraph">View authors whose books have not been borrowed<br></p>
                        <a class="btn btn-primary" id="show-btn" href="leastauthors.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 box1">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Authors and Teachers</h4>
                        <p class="card-text" id="paragraph">View authors who belong to a category and teachers who borrowed from it<br></p>
                        <a class="btn btn-primary" id="show-btn" href="authorsandteachers.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Lazy authors</h4>
                        <p class="card-text" id="paragraph">View authors who have written <=5 books less than the author with the most books<br></p>
                        <a class="btn btn-primary" id="show-btn" href="lazyauthors.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Schools</h4>
                        <p class="card-text" id="paragraph">View all schools<br></p>
                        <a class="btn btn-primary" id="show-btn" href="schoolslist.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 box1">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Library Operators</h4>
                        <p class="card-text" id="paragraph">View all library operators<br></p>
                        <a class="btn btn-primary" id="show-btn" href="libraryoperatorslist.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Library Operators's Applications</h4>
                        <p class="card-text" id="paragraph">View teachers who have applied for library operator<br></p>
                        <a class="btn btn-primary" id="show-btn" href="applications.php">Show</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script src = "{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>
    
</body>

</html>
