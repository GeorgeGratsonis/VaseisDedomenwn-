<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Library</title>
    <link rel="stylesheet" href="signup.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .text:hover {
            cursor: default;
        }
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
    <nav class="navbar">
        <div class="navbar__container">
            <a href="index.php" id="navbar__logo">School Library</a>
        </div>
    </nav>

    <main class="main">
        <br>
        <h2 class="text">Lets sign up:</h2>
        <br>
        <br>
        <div class="form-container">
            <form action="signup.inc.php" method="post" id="signform">
                <br>
                <label> Insert your Username:</label>
                <input type="text" name="username" required id="username">
                <br>
                <br>
                <label> Insert your Password:</label>
                <input type="password" name="password" required class="input-field" id="password">
                <br>
                <br>
                <label> Insert your Password again:</label>
                <input type="password" name="passwordrepeat" class="input-field" required id="confirmPassword">
                <br>
                <br>
                <label> Insert your First Name:</label>
                <input type="text" name="firstname" required id="firstname">
                <br>
                <br>
                <label> Insert your Last Name:</label>
                <input type="text" name="lastname" required id="lastname">
                <br>
                <br>
                <label> Insert your Age:</label>
                <input type="number" name = "age" required id="age">
                <br>
                <br>
                <label> Select your Role:</label>
                <select name="role" required id="role" onchange="updateAgeRange()">
                    <option value="" selected disabled></option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="library operator">Library Operator</option>
                </select>
                <br>
                <br>
                <label> Select your School:</label>
                <select name="school" required id="school">
                    <option value="" selected disabled></option>
                    <?php
                    include 'connection.php';
                    
                    $query = "SELECT School_ID, Name FROM School ORDER BY School_ID";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $schoolID = $row['School_ID'];
                        $schoolName = $row['Name'];
                        echo '<option value="' . $schoolID . '">' . $schoolID . '. ' . $schoolName .'</option>';
                    }
                    $conn->close();
                    ?>
                </select>
                <br>
                <br>
                <input type="checkbox" onclick="showPassword()"> <span class="text">Show my password</span>
                <br>
                <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "invalidfirstname") {
                            echo "<p class='error-message'>Choose a proper first name!</p>";
                        } else if ($_GET["error"] == "invalidlastname") {
                            echo "<p class='error-message'>Choose a proper last name!</p>";
                        } else if ($_GET["error"] == "passwordsdontmatch") {
                            echo "<p class='error-message'>Passwords don't match!</p>";
                        } else if ($_GET["error"] == "usernametaken") {
                            echo "<p class='error-message'>Username already taken!</p>";
                        } else if ($_GET["error"] == "libraryoperatorexists") {
                            echo "<p class='error-message'>Your school already has a library operator!</p>";
                        } else if ($_GET["error"] == "stmtfailed") {
                            echo "<p class='error-message'>Something went wrong, try again!</p>";
                        } else if ($_GET["error"] == "none") {
                            echo "<p class='noerror-message'>You have signed up!</p>";
                        }
                    }
                ?>
                <button type="submit" name="submit" class="signin__btn">
                    <a>Sign Up</a>
                </button>
            </form>
            <br>
            <a href="signin.php" id="haveaccount">Already have an account? Press here</a>
            <br>
            <br>
        </div>
        <img src="images/pic2.svg" alt="pic" id="main__img">
        <div class="image-container">
        </div>
    </main>

    <script>
        function updateAgeRange() {
            var roleInput = document.getElementById("role");
            var ageInput = document.getElementById("age");

            if (roleInput.value === "student") {
                ageInput.min = 6;
                ageInput.max = 18;
            } else if (roleInput.value === "teacher" || roleInput.value === "library operator") {
                ageInput.min = 25;
                ageInput.max = 80;
            }
        }

        function showPassword() {
            var password = document.getElementById("password");
            var confirmPassword = document.getElementById("confirmPassword");

            if (password.type === "password" || confirmPassword.type === "password") {
                password.type = "text";
                confirmPassword.type = "text";
            } else {
                password.type = "password";
                confirmPassword.type = "password";
            }
        }
    </script>
</body>
</html>