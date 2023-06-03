<?php

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once 'connection.php';
    require_once 'functions.php';

    loginUser($conn, $username, $password);
}
else {
    header("location: signin.php?");
    exit();
}