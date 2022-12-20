<?php
include_once "includes/connection.php";
include_once "includes/session.php";
include_once "includes/functions.php";

if(isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $fieldNames = ['name', 'email', 'confirmPassword', 'password'];
    $errors = validate($fieldNames);
    if (empty($errors)){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'insert into users (name, email, password) values (?, ?, ?)';
        $stmt = $db->prepare($sql);
        if($stmt->execute([$name, $email, $password ])){
            if (isset($_POST['add_user'])) {
                $_SESSION['success'] = 'new user created';
                // var_dump($_SESSION['success']);exit;
                header('location: ../backend/users.php');
                exit();
            }
            $_SESSION['success'] = 'new user created';
            header('location: ../signIn.php');
            $stmt->closeCursor();
            exit();
        }
    }
}