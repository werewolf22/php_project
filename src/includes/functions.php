<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader for forgot password
require __DIR__.'/../../vendor/autoload.php';
require 'mailConfig.php';

function htmlMail($to,$subject,$body){ // sends an html email
    $headers='MIME-Version: 1.0'."\r\n";
    $headers.='Content-type: text/html; charset=iso-8859-1'."\r\n";
    $headers.='From: Surya <surya@gmail.com>'."\r\n";
    $message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"'."\r\n";
    $message.="\t".'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\r\n";
    $message.='<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">'."\r\n";
    $message.='<head>'."\r\n";
    $message.="\t".'<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />'."\r\n";
    $message.="\t".'<meta http-equiv="Content-Language" content="en-us" />'."\r\n";
    $message.="\t".'<title>'.$subject.'</title>'."\r\n";
    $message.='</head>'."\r\n";
    $message.='<body>'."\r\n";
    $message.="\t".$body."\r\n";
    $message.='</body>'."\r\n";
    $message.='</html>';

    // message that will be displayed when everything is OK :)
    $okMessage = 'email sent!';
    
    // If something goes wrong, we will display this message.
    $errorMessage = 'There was an error while submitting the email. Please try again later';
    
    /*
     *  LET'S DO THE SENDING
     */
    
    // if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
    error_reporting(E_ALL & ~E_NOTICE);
    
    try
    {
    
        
        // All the necessary headers for the email.
        $mail = new PHPMailer(true); // true enables exception
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
    
        //Set the hostname of the mail server
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6
        $mail->Host = SMTP_HOST;
    
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = SMTP_PORT;
    
        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = SMTP_ENCRYPTION;
    
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
    
        //Username to use for SMTP authentication - use full email address for gmail
        //We have configured this variable in the config section
        $mail->Username = SMTP_USERNAME;
    
        //Password to use for SMTP authentication
        //We have configured this variable in the config section
        $mail->Password = SMTP_PASSWORD;
        
        // from, recepient and message
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress($to, 'Joe User');     //Add a recipient
        $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
    
        // Send email ....
        $mail->send();
    
        return array('type' => 'success', 'message' => $okMessage);
    }
    catch (\Exception $e)
    {
        // var_dump($e);
        return array('type' => 'danger', 'message' => $errorMessage);
    }
}


function validate($fieldNames = [], $values = []){
    $errors = [];
    foreach ($fieldNames as $fieldName){
        global ${$fieldName};
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
    return $errors;
}