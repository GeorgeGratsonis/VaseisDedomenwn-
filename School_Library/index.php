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
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="navbar__container">
            <span id="navbar__logo">School Library</span>
            <ul class="navbar__menu">
                <li class="navbar__btn">
                    <a href="signin.php" class="button">
                        Sign In
                    </a>
                </li>    
            </ul>
        </div>
    </nav>


    <div class="main">
        <div class="main__container">
            <div class="main__content">
                <h2>Εφαρμογή Διαχείρησης Βιβλιοθήκης-Δίκτυο Σχολικών Βιβλιοθηκών 
                </h2>
                <button onclick = "location.href='signup.php'" class="main__btn">
                    <a>Get Started</a>
                </button>
            </div>
            <div class="main__img--container">
                <img src="images/pic1.svg" alt="pic" id="main__img">
            </div>
        </div>
    </div>
</body>

</html>