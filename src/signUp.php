<?php

include_once "includes/connection.php";
include_once "includes/session.php";
include_once "includes/functions.php";

if(isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $fieldNames = ['name', 'email', 'confirmPassword', 'password'];
    $errors = validate($fieldNames);
    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'insert into users (name, email, password) values (?, ?, ?)';
        $stmt = $db->prepare($sql);
        if($stmt->execute([$name, $email, $password ])) {
            
            $_SESSION['success'] = 'new user created';
            header('location: ../resources/views/signIn.php');
            $stmt->closeCursor();
            exit();
        }
    } else {
        var_dump($errors);
    }
}

if(isset($_POST['add_user'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $registrationNo = trim($_POST['registration_no']);
    $phoneNo = trim($_POST['phone_no']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $fieldNames = ['name', 'email', 'confirmPassword', 'password'];
    $errors = validate($fieldNames);
    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'insert into users (name, email, registration_no, phone_no, password) values (?, ?, ?, ?, ?)';
        $stmt = $db->prepare($sql);
        if($stmt->execute([$name, $email,$registrationNo, $phoneNo, $password ])) {
            $_SESSION['success'] = 'new student created';
            // var_dump($_SESSION['success']);exit;
            header('location: ../resources/views/users.php');
            exit();
        }
    } else {
        $_SESSION['error'] = $errors;
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
}
