<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="signup.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .text:hover {
            cursor: default;
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
                <input type="text" name="usename" required id="username">
                <br>
                <br>
                <label> Insert your Password:</label>
                <input type="password" name="password" required class="input-field" id="password" oninput="validatePassword()">
                <br>
                <br>
                <label> Insert your Password again:</label>
                <input type="password" name="passwordrepeat" class="input-field" required id="confirmPassword" oninput="validatePassword()">
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
                <select name="role" required id="role">
                    <option value="" selected disabled></option>
                    <option value="student">Student</option>
                    <option value="teacher">Professor</option>
                    <option value="parent">Library Operator</option>
                </select>
                <br>
                <br>
                <label> Select your School:</label>
                <select name="school" required id="school">
                    <option value="" selected disabled></option>
                    <?php
                    include 'connection.php';
                    $conn = OpenCon();
                    
                    $query = "SELECT School_ID, Name FROM School ORDER BY School_ID";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $schoolID = $row['School_ID'];
                        $schoolName = $row['Name'];
                        echo '<option value="' . $schoolID . '">' . $schoolID . '. ' . $schoolName .'</option>';
                    }
                    ?>
                </select>
                <br>
                <br>
                <input type="checkbox" onclick="showPassword()"> <span class="text">Show my password</span>
                <br>
                <span id="passwordMismatch" style="color: red; display: none;">Passwords do not match!</span>
                <button class="signin__btn" type="submit" name="submit">
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
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var mismatchMessage = document.getElementById("passwordMismatch");
            
            if (confirmPassword.length != 0 && password.length != 0) {
                if (password != confirmPassword) {
                    mismatchMessage.style.display = "block";
                } else {
                    mismatchMessage.style.display = "none";
                } 
            } else {
                mismatchMessage.style.display = "none";
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