<?php
// include_once "includes/signOut.php";
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
            // var_dump(password_verify($password, $foundUser['password']));
            // die();
            if(password_verify($password, $foundUser['password'])){
               $_SESSION['userId'] = $foundUser['id'];
               $_SESSION['userName'] = $foundUser['name'];
               header('location: ../resources/views/dashboard.php');
               $stmt->closeCursor();
               exit();
            } else echo 'Invalid Credentials';
        } else var_dump($stmt->rowCount());
    }else var_dump($errors);
}else var_dump($_POST);


