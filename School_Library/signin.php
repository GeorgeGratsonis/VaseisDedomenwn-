<?php 

session_start();

    include 'connection.php';
    $conn = OpenCon();
	include 'functions.php';


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(!empty($username) && !empty($password) && !is_numeric($username))
		{

			//read from database
			$query = "select * from user where username = '$username' limit 1";
			$result = mysqli_query($conn, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{

						$_SESSION['user_id'] = $user_data['user_id'];
						header("Location: user.php");
						die;
					}
				}
			}
			
			echo "wrong username or password!";
		}else
		{
			echo "wrong username or password!";
		}
	}

?>

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
        <br>
        <h2>Lets sign in:</h2>
        <div class="form-container">
            <form id="signform" method = "post">
                <label>Username</label>
                <input id="username" type="text" name="username" required id="username">
                <label>Password</label>
                <input id="password" type="password" name="password" required class="input-field">

                <button onclick = "location.href='user.php'" class="signin__btn">
                    <a>Sign In</a>
                </button>

                <br>
                <input type="checkbox" onclick="showPassword()"> <span class="text">Show my password</span>
            </form>
            <br>
            <button onclick = "location.href='password.php'" class="change-password">
                <a>Forgot your Password?</a>
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