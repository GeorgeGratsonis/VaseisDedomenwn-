<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>
        School Library
    </title>
    <link rel = "stylesheet" href = "admin.css">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel = "stylesheet" href = "bootstrap.css">
    

</head>


<body>
<nav class="navbar navbar-light navbar-expand-md" id="nav-bar">
    <div id="navbar-div" class="container-fluid">
        <a class="navbar-brand" id="nav-bar-text">School Library - Admin Page</a>
        <form action="backup.php" method="post" style="display: inline;">
            <button type="submit" class="btn btn-primary">Backup</button>
        </form>
        <form action="restore.php" method="post" style="display: inline;">
            <button type="submit" class="btn btn-primary">Restore</button>
        </form>
        <a id="navbar-items" href="logout.php">
            <i class="fa fa-home"></i> Log out
        </a>
        
    </div>
</nav>


    <div class="container" id="row-container">
        <div class="row" id="row">
            <div class="col-md-4 box2">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">View Admin Info</h4>
                        <p class="card-text" id="paragraph">View your information</p>
                        <a class="btn btn-primary" id="show-btn" href="userinfo.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Mad operators:</h4>
                        <p class="card-text" id="paragraph">See which operators have rented the same ammount of books (over 20) in a year<br></p>
                        <a class="btn btn-primary" id="show-btn" href="madoperators.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Top 3 pairing of book categories</h4>
                        <p class="card-text" id="paragraph">See the most common categories of books that are liked by users<br></p>
                        <a class="btn btn-primary" id="show-btn" href="top3.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 box1">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Top borrowers</h4>
                        <p class="card-text" id="paragraph">See how many teachers under 40 years old borrowed the most books</p>
                        <a class="btn btn-primary" id="show-btn" href="topborrowers.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">School's Library borrowing list</h4>
                        <p class="card-text" id="paragraph">Search criteria: Year/Month<br></p>
                        <a class="btn btn-primary" id="show-btn" href="list.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Least liked authors:</h4>
                        <p class="card-text" id="paragraph">See the authors which none of their books has been borrowed:<br></p>
                        <a class="btn btn-primary" id="show-btn" href="leastauthors.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Authors and teacher's</h4>
                        <p class="card-text" id="paragraph">See the authors and how many teachers borrowed from this category<br></p>
                        <a class="btn btn-primary" id="show-btn" href="authorsandteachers.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Lazy authors:</h4>
                        <p class="card-text" id="paragraph"> Authors which have written <=5 books less the the author with the most books:<br></p>
                        <a class="btn btn-primary" id="show-btn" href="lazyauthors.php">Show</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script src = "{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>
    
</body>

</html>
