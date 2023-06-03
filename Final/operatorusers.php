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
            margin-top: 20px;
            margin-bottom: -47px;
        }
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
            <a class="navbar-brand" id="nav-bar-text" href="libraryoperator.php">School Library - Library Operator Page</a>
            <a id="navbar-items" href="logout.php">
                <i class="fa fa-home"></i> Log out
            </a>
        </div>
    </nav>

    <div class="container">
    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "successenable") {
                echo "<p class='noerror-message text-center'>User enabled!</p>";
            }
            else if ($_GET["error"] == "successdisable") {
                echo "<p class='noerror-message text-center'>User disabled!</p>";
            }
            else if ($_GET["error"] == "successdelete") {
                echo "<p class='noerror-message text-center'>User deleted!</p>";
            }
        }
    ?>
        <div class="row" id="row">
            <div class="col-md-12">
                <div class="card" id="card-container">
                    <div class="card-body" id="card">
                        <?php
                        $School_ID = $operator_data['School_ID'];
                        $query = "SELECT * FROM User WHERE School_ID = $School_ID";
                        $result = mysqli_query($conn, $query);
                        
                        if(mysqli_num_rows($result) == 0){
                            echo '<h1 style="margin-top: 5rem;">No Users found!</h1>';
                        }
                        else{
                            echo '<div class="table-responsive">';
                                echo '<table class="table">';
                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th>First Name</th>';
                                            echo '<th>Last Name</th>';
                                            echo '<th>Username</th>';
                                            echo '<th>Age</th>';
                                            echo '<th>Role</th>';
                                            echo '<th>Status</th>';
                                            echo '<th>Enable/Disable</th>';
                                            echo '<th>Delete</th>';
                                        echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                    while($row = mysqli_fetch_assoc($result)){
                                        echo '<tr>';
                                            echo '<td>' . $row['First_Name'] . '</td>';
                                            echo '<td>' . $row['Last_Name'] . '</td>';
                                            echo '<td>' . $row['Username'] . '</td>';
                                            echo '<td>' . $row['Age'] . '</td>';
                                            echo '<td>' . $row['Role'] . '</td>';
                                            if ($row['Approved'] == TRUE) {
                                                echo '<td><span style="color: green;">Enabled</span></td>';
                                            } else {
                                                echo '<td><span style="color: red;">Disabled</span></td>';
                                            }
                                            echo '<td>';
                                            if ($row['Approved'] == TRUE) {
                                                echo '<a href="./disableuser.php?id=' . $row['User_ID']. '">';
                                                echo '<i class="fa fa-x"></i>';
                                                echo '</a>';
                                            } else {
                                                echo '<a href="./enableuser.php?id=' . $row['User_ID']. '">';
                                                echo '<i class="fa fa-check"></i>';
                                                echo '</a>';
                                            }
                                            echo '</td>';
                                            echo '<td>';
                                                echo '<a href="./deleteuser.php?id=' . $row['User_ID']. '">';
                                                    echo '<i class="fa fa-trash"></i>';
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
                </div>
            </div>
        </div>
    </div>
    &nbsp;
    &nbsp;
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>