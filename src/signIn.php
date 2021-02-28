<?php
include_once "includes/session.php";
include_once "includes/connection.php";
include_once "includes/functions.php";
if(isset($_POST['submit'])){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    $fieldNames= ['email', 'password'];
    
    $errors = validate($fieldNames);
    if (empty($errors)){
        $sql = "select * from users where email = ? limit 0, 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        if ($stmt->rowCount()==1){
            $foundUser = $stmt->fetch();
            if(password_verify($password, $foundUser['password'])){
               $_SESSION['userId'] = $foundUser['id'];
               $_SESSION['userName'] = $foundUser['name'];
               header('location: ../resources/views/dashboard.php');
               $stmt->closeCursor();
               exit();
            }
        }
    }
}


