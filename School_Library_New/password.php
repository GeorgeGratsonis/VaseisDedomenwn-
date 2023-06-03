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
        #newpassword {
            color: black;
        }
        #confirmnewPassword {
            color: black;
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
            <form action="password.inc.php" method="post" id="signform">
                <br>
                <label> Insert your Username:</label>
                <input type="text" name="username" required id="username">
                <br>
                <br>
                <label> Insert your current Password:</label>
                <input type="password" name="oldpassword" required class="input-field" id="password">
                <br>
                <br>
                <label> Insert your new Password:</label>
                <input type="password" name="newpassword" required class="input-field" id="newpassword">
                <br>
                <br>
                <label> Insert your new Password again:</label>
                <input type="password" name="newpasswordrepeat" class="input-field" required id="confirmnewPassword">
                <br>
                <br>
                <input type="checkbox" onclick="showPassword()"> <span class="text">Show my password</span>
                <br>
                <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "wrongusername") {
                            echo "<p class='error-message'>Username doesn't exist!</p>";
                        } else if ($_GET["error"] == "wrongpassword") {
                            echo "<p class='error-message'>Wrong password!</p>";
                        } else if ($_GET["error"] == "passwordsdontmatch") {
                            echo "<p class='error-message'>Passwords don't match!</p>";
                        } else if ($_GET["error"] == "samepasswords") {
                            echo "<p class='error-message'>New password same as current password!</p>";
                        } else if ($_GET["error"] == "stmtfailed") {
                            echo "<p class='error-message'>Something went wrong, try again!</p>";
                        } else if ($_GET["error"] == "none") {
                            echo "<p class='noerror-message'>Password changed!</p>";
                        }
                    }
                ?>
                <button type="submit" name="submit" class="signin__btn">
                    <a>Change Password</a>
                </button>
            </form>
        </div>
        <img src="images/pic4.svg" alt="pic" id="main__img">
        <div class="image-container">
        </div>
    </main>

    <script>
        function showPassword() {
            var password = document.getElementById("password");
            var newpassword = document.getElementById("newpassword");
            var confirmnewPassword = document.getElementById("confirmnewPassword");

            if (password.type === "password" || newpassword.type === "password" || confirmnewPassword.type === "password") {
                password.type = "text";
                newpassword.type = "text";
                confirmnewPassword.type = "text";
            } else {
                password.type = "password";
                newpassword.type = "password";
                confirmnewPassword.type = "password";
            }
        }
    </script>
</body>
</html>