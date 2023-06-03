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
        <br>
        <h2>Lets sign in:</h2>
        <div class="form-container">
            <form action="signin.inc.php" method="post" id="signform">
                <label>Username:</label>
                <input type="text" name="username" required id="username">
                <label>Password:</label>
                <input type="password" name="password" required class="input-field" id="password">

                <button type="submit" name="submit" class="signin__btn">
                    <a>Sign In</a>
                </button>

                <br>
                <input type="checkbox" onclick="showPassword()"> <span class="text">Show my password</span>
                <br>
                <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "wrongusername") {
                            echo "<p class='error-message'>Username doesn't exist!</p>";
                        } else if ($_GET["error"] == "wrongpassword") {
                            echo "<p class='error-message'>Wrong password!</p>";
                        } else if ($_GET["error"] == "notapproved") {
                            echo "<p class='error-message'>Your account is currently disabled!</p>";
                        } else if ($_GET["error"] == "stmtfailed") {
                            echo "<p class='error-message'>Something went wrong, try again!</p>";
                        }
                    }
                ?>
            </form>
            <br>
            <button onclick = "location.href='password.php'" class="change-password">
                <a>Change your Password?</a>
            </button>
            <br>
            <br>
        </form>
    </div>
    <img src="images/pic3.svg" alt="pic" id="main__img">
    <div class="image-container">
    </div>
    </main>

    <script>
        function showPassword() {
            var password = document.getElementById("password");

            if (password.type === "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }
        }
    </script>
</body>

</html>