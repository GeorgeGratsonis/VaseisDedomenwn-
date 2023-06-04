<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Library</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet"> 
    <style>
        body {
            height: 100%;
            overflow: hidden;
        }
        .button {
            font-size: 18px;
            padding: 10px 20px; 
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="navbar__container">
            <span id="navbar__logo">School Library</span>
            <ul class="navbar__menu">
                <li class="navbar__btn">
                    <form action="signin.php" method="post">
                        <button type="submit" name="submit" class="button">
                            <a>Sign in</a>
                        </button>
                    </form>
                </li>    
            </ul>
        </div>
    </nav>


    <div class="main">
        <div class="main__container">
            <div class="main__content">
                <h2>Εφαρμογή Διαχείρησης Βιβλιοθήκης-Δίκτυο Σχολικών Βιβλιοθηκών 
                </h2>
                <form action="signup.php" method="post">
                    <button type="submit" name="submit" class="main__btn">
                        <a>Get Started</a>
                    </button>
                </form>
            </div>
            <div class="main__img--container">
                <img src="images/pic1.svg" alt="pic" id="main__img">
            </div>
        </div>
    </div>
</body>

</html>