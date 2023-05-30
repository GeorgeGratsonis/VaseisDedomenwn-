<?php

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $oldpassword = $_POST["oldpassword"];
    $newpassword = $_POST["newpassword"];
    $newpasswordrepeat = $_POST["newpasswordrepeat"];

    require_once 'connection.php';
    require_once 'functions.php';

    if (pwdMatch($newpassword, $newpasswordrepeat) !== false) {
        header("location: password.php?error=passwordsdontmatch");
        exit();
    }

    if ($newpassword == $oldpassword) {
        header("location: password.php?error=samepasswords");
        exit();
    }

    changepassword($conn, $username, $password, $newpassword);
}
else {
    header("location: password.php?");
    exit();
}