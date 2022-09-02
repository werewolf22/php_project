<?php
include_once "includes/connection.php";
include_once "includes/functions.php";

// after email submission
if (isset($_POST['forgotPasswordSubmit'])){
    $email = trim($_POST['email']);

    $sql = 'select email from users where email = ? limit 0,1';
    $stmt = $db->prepare($sql);
    $stmt->execute([$email]);
    // var_dump($stmt->rowCount());
    if ($stmt->rowCount()== 1){
        $foundUser = $stmt->fetch();
        $stmt->closeCursor(); // not needed as per senior sir because once the page load cycle is complete and all the involved script have compiled in server the db connectioin closes automatically in php
        $email= $foundUser['email'];
        $token = md5($foundUser['email']);
        
        $sql = 'insert into password_resets (email,token,created_at) value(?,?,?) on duplicate key update token=?,created_at=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$email, $token, date('Y-m-d h:i:sa'), $token, date('Y-m-d h:i:sa')]);
        if ($stmt->rowCount()== 1){

            $protocol = (isset($_SERVER['https']) && $_SERVER['https'] != "off")? 'https': 'http';
            $url = $protocol .'://'. $_SERVER['SERVER_NAME'];
            $resetLink = $url.'/projects/practise/officePractise/php_project/src/forgotPassword.php?token='.$token;
            $message='<p>A request was made to change your password. If this request was made by you, please click the link below to create a new password.</p>'."\r\n";
            $message.="\t".'<p><a href="'.$resetLink.'">Password Reset Link</a></p>'; 
            htmlMail($email, 'Password Reset Link',$message);
            header('location: ../resources/views/signIn.php');
            $stmt->closeCursor();
            exit();
        }
    }
}

// after  clicking on mailed link

if(isset($_GET['token'])){
    $sql = 'select email from password_resets where token=? limit 0,1';
    $stmt = $db->prepare($sql);
    $stmt->execute([$_GET['token']]);
    if ($stmt->rowCount()==1){
        $passwordResets = $stmt->fetch();
        header('location: ../resources/views/forgotPasswordReset.php?email='. $passwordResets->email);
    }
}


// change password

if (isset($_POST['forgotPasswordResetSubmit'])){
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $email = trim($_POST['email']);
    $fieldNames = ['password', 'confirmPassword'];
    $errors = validate($fieldNames);
    if (empty($errors)){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'update users set password = ? where email = ?';
        $stmt = $db->prepare($sql);
        // if($stmt->execute([$password, $email])){
        $coreSql = 'update users set password = '.$password.' where email = '.$email;
        if(mysqli_query($con, $coreSql)){
            // var_dump($stmt->execute([$password, $email]));die(); // need to check to debug PDO
            $message = 'successful password reset';
            header('location: ../resources/views/signIn.php?success=1');
            $stmt->closeCursor();
            exit();
        }
    }
}