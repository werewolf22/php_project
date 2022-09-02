<?php

require_once 'db.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['signup'])) {

    session_start();

    $user_id = $_SESSION['userid'];

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (emptyInputSignup($username, $email, $password, $confirm_password) !== false) {
        if ($user_id !== false) {
            header("location: ../user_add.php?error=emptyinput");
            exit();
        }
        header("location: ../signup.php?error=emptyinput");
        exit();
    }

    if (invalidEmail($email) !== false) {
        if ($user_id !== false) {
            header("location: ../user_add.php?error=invalidemail");
            exit();
        }
        header("location: ../signup.php?error=invalidemail");
        exit();
    }

    if (passwordNotMatch($password, $confirm_password) !== false) {
        if (isset($_SESSION['userid'])) {
            header("location: ../user_add.php?error=passwordsdontmatch");
            exit();
        }
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }

    if (emailExists($conn, $email) !== false) {
        if (isset($_SESSION['userid'])) {
            header("location: ../user_add.php?error=emailtaken");
            exit();
        }
        header("location: ../signup.php?error=emailtaken");
        exit();
    }

    createUser($conn, $username, $email, $password);
} else {
    header("location: ../signup.php");
    exit();
}
