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
        .noerror-message {
            color: green;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: -47px;
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
    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "successapprove") {
                echo "<p class='noerror-message text-center'>Library Operator approved!</p>";
            }
            else if ($_GET["error"] == "successdelete") {
                echo "<p class='noerror-message text-center'>Library Operator deleted!</p>";
            }
        }
    ?>
        <div class="row" id="row">
            <div class="col-md-12">
                <div class="card" id="card-container">
                    <div class="card-body" id="card">
                        <?php
                        $query = "SELECT School.Name, L.First_Name, L.Last_Name, L.Username, L.Age, L.LibraryOperator_ID, L.School_ID 
                        FROM libraryoperator as L
                        JOIN school ON School.School_ID = L.School_ID
                        WHERE Approved = FALSE";
                        $result = mysqli_query($conn, $query);
                        
                        if(mysqli_num_rows($result) == 0){
                            echo '<h1 style="margin-top: 5rem;">No Library Operators found!</h1>';
                        }
                        else{

                            echo '<div class="table-responsive">';
                                echo '<table class="table">';
                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th>School Name</th>';
                                            echo '<th>First Name</th>';
                                            echo '<th>Last Name</th>';
                                            echo '<th>Username</th>';
                                            echo '<th>Age</th>';
                                            echo '<th></th>';
                                            echo '<th></th>';
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
                                            echo '<td>';
                                                echo '<a type="button" href="./approveoperator.php?id=' . $row[5] . '&school=' . $row[6] . '">';
                                                    echo '<i class = "fa fa-check"></i>';
                                                echo '</a>';
                                            echo '</td>';
                                            echo '<td>';
                                                echo '<a type="button" href="./deleteoperator.php?id=' . $row[5] . '">';
                                                    echo '<i class = "fa fa-trash"></i>';
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