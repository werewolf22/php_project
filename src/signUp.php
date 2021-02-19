<?php
include_once "includes/connection.php";

if(isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $fieldNames = ['name', 'email', 'password', 'confirmPassword'];
    foreach ($fieldNames as $fieldName){
        if (!isset(${$fieldName}) || empty(${$fieldName})){
            $errors[$fieldName]= "required";
            // if multiple errors occur in same field errors are saved in array
            if($fieldName == 'password'){
                if($password !== $confirmPassword){
                    if(isset($errors[$fieldName])){
                        $errors[$fieldName][] = $errors[$fieldName];
                        $errors[$fieldName][] = 'unmached password';
                    }else{
                        $errors[$fieldName] = 'unmached password';
                    }
                }
            }
        }
    }
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