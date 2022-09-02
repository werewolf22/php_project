<?php
include_once "includes/connection.php";

if(isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $fieldNames = ['name', 'email', 'password', 'confirmPassword'];
    $errors = validate($fieldNames);
    if (empty($errors)){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'insert into users (name, email, password) values (?, ?, ?)';
        $stmt = $db->prepare($sql);
        if($stmt->execute([$name, $email, $password ])){
            $message = 'new user created';
            header('location: ../resources/views/signIn.php?success=1');
            $stmt->closeCursor();
            exit();
        }
    }
}