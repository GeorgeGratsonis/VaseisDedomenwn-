<?php

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $passwordrepeat = $_POST["passwordrepeat"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $age = $_POST["age"];
    $role = $_POST["role"];
    $school = $_POST["school"];

    require_once 'connection.php';
    require_once 'functions.php';

    if (invalidfirstname($firstname) !== false) {
        header("location: signup.php?error=invalidfirstname");
        exit();
    }

    if (invalidlastname($lastname) !== false) {
        header("location: signup.php?error=invalidlastname");
        exit();
    }

    if (pwdMatch($password, $passwordrepeat) !== false) {
        header("location: signup.php?error=passwordsdontmatch");
        exit();
    }

    if (usernametaken($conn, $username) !== false) {
        header("location: signup.php?error=usernametaken");
        exit();
    }

    if($role == 'library operator') {
        if (libraryoperatorexists($conn, $school) !== false) {
            header("location: signup.php?error=libraryoperatorexists");
            exit();
        }
    }

    if($role == 'library operator') {
        createLibraryOperator($conn, $firstname, $lastname, $username, $password, $school);
    } else {
        createUser($conn, $firstname, $lastname, $username, $password, $age, $role, $school);
    }
}
else {
    header("location: signup.php?");
    exit();
}