<?php

require_once 'db.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (emptyInputLogin($email, $password) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $email, $password);
} else {
    header("location: ../login.php");
    exit();
}
