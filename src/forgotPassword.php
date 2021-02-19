<?php
include_once "includes/connection.php";
include_once "includes/functions.php";
if (isset($_POST['forgotPasswordSubmit'])){
    $email = trim($_POST['email']);
    $sql = 'select email from users where email = ? limit 0,1';
    $stmt = $db->prepare($sql);
    $stmt->execute([$email]);
    // var_dump($stmt->rowCount());
    if ($stmt->rowCount()== 1){
        $foundUser = $stmt->fetch();
        $stmt->closeCursor();
        $email= $foundUser['email'];
        $token = md5($foundUser['email']);
        $sql = 'insert into password_resets (email,token,created_at) value(?,?,?) on duplicate key update token=?,created_at=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$email, $token, time(), $token, time()]);
        if ($stmt->rowCount()== 1){

            $protocol = (isset($_SERVER['https']) && $_SERVER['https'] != "off")? 'https': 'http';
            $url = $protocol .'://'. $_SERVER['SERVER_NAME'];
            $resetLink = $url.'/resources/views/forgotPasswordReset.php?token='.$token;
            $message='<p>A request was made to change your password. If this request was made by you, please click the link below to create a new password.</p>'."\r\n";
            $message.="\t".'<p><a href="'.$resetLink.'">Password Reset Link</a></p>'; 
            htmlMail($email, 'Password Reset Link',$message);
            header('location: ../resources/views/signIn.php');
            $stmt->closeCursor();
            exit();
        }
    }
}