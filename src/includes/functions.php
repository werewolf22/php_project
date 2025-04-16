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
        // $mail->SMTPSecure = SMTP_ENCRYPTION;
    
        //Whether to use SMTP authentication
        $mail->SMTPAuth = false;
    
        //Username to use for SMTP authentication - use full email address for gmail
        //We have configured this variable in the config section
        // $mail->Username = SMTP_USERNAME;
    
        //Password to use for SMTP authentication
        //We have configured this variable in the config section
        // $mail->Password = SMTP_PASSWORD;
        
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
        } else{
            
            // if multiple errors occur in same field errors are saved in array
            if($fieldName == 'password' && isset($confirmPassword)){
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


function unsetErrorSession(){
    unset($_SESSION['error']);
}

function unsetSuccessSession(){
    unset($_SESSION['success']);
}
// signup start

// function emptyInputSignup($username, $email, $password, $confirm_password)
// {

//     if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
//         $result = true;
//     } else {
//         $result = false;
//     }

//     return $result;
// }

// function emptyInputEditUser($username, $email, $old_password, $new_password, $new_confirm_password)
// {

//     if (empty($username) || empty($email) || empty($old_password) || empty($new_password) || empty($new_confirm_password)) {
//         $result = true;
//     } else {
//         $result = false;
//     }

//     return $result;
// }


function invalidEmail($email)
{

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

// function passwordNotMatch($password, $confirm_password)
// {

//     if ($password !== $confirm_password) {
//         $result = true;
//     } else {
//         $result = false;
//     }

//     return $result;
// }

// function emailExists($conn, $email)
// {
//     $sql = "SELECT * FROM users where usersEmail = ?;";

//     // this is prepare statement and is used to prevent sql injection
//     $stmt = mysqli_stmt_init($conn);

//     // this is for handling if error that might happen in sql or any error
//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../signup.php?error=stmtfailed");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, 's', $email);
//     mysqli_stmt_execute($stmt);

//     //mysqli_stmt_get_result() return data in object form
//     $resultData = mysqli_stmt_get_result($stmt);

//     // mysqli_fetch_assoc() return data in array form
//     if ($row = mysqli_fetch_assoc($resultData)) {
//         return $row;
//     } else {
//         $result = false;
//         return $result;
//     }

//     mysqli_stmt_close($stmt);
// }

// signup end

// login start

// function emptyInputLogin($email, $password)
// {

//     if (empty($email) || empty($password)) {
//         $result = true;
//     } else {
//         $result = false;
//     }

//     return $result;
// }

// function loginUser($conn, $email, $password)
// {
//     $emailExists = emailExists($conn, $email);

//     if ($emailExists === false) {
//         header("location: ../login.php?error=wronglogininput");
//         exit();
//     }

//     $hashedPassword = $emailExists["usersPassword"];
//     $checkPassword = password_verify($password, $hashedPassword);

//     if ($checkPassword === false) {
//         header("location: ../login.php?error=wrongpassword");
//     } else if ($checkPassword === true) {
//         session_start();
//         $_SESSION["userid"] = $emailExists["usersId"];
//         $_SESSION["usersName"] = $emailExists["usersName"];
//         header("location: ../account.php");
//         exit();
//     }
// }

// login end


function getCurrentUser(){
    global $db;
    $sql = "select * from users where id = ? limit 1";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION['userId']]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


//update user start

function updateUser($db, $name, $email, $id, $registrationNo = null, $phoneNo = null, $password = '')
{
    // $email = email that cames from user input
    // $password = new password type by user
    // $id = user id input

    if ($password ) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $update_sql = "UPDATE users SET  password=? WHERE id=? AND name=? AND email=?";
        $stmt = $db->prepare($update_sql);
        return $stmt->execute([$hashedPassword, $id, $name, $email]);
    } else {
        $update_sql = "UPDATE users SET name=?, email=?, registration_no=?, phone_no=? WHERE id=?";
        $stmt = $db->prepare($update_sql);
        return $stmt->execute([$name, $email, $registrationNo, $phoneNo, $id]);
    }

}

function createIndividualContact($db, $name, $address1, $address2, $email, $primary_phone, $secondary_phone, $website, $type)
{
    $insertSql = "INSERT INTO contacts(name, address1, address2, email, primary_phone, secondary_phone, type, website) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = $db->prepare( $insertSql);
    return $stmt->execute([$name, $address1, $address2, $email, $primary_phone, $secondary_phone, $type, $website]);
}

function createCompanyContact($db, $name, $address1, $address2, $email, $primary_phone, $secondary_phone, $website, $company_logo, $type)
{
    $insertSql = "INSERT INTO contacts(name, address1, address2, email, primary_phone, secondary_phone, type, website, company_logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = $db->prepare( $insertSql);
    return $stmt->execute([$name, $address1, $address2, $email, $primary_phone, $secondary_phone, $type, $website, $company_logo]);
}

function updateIndividualContact($db, $contactId, $name, $email, $address1, $address2, $primary_phone, $secondary_phone, $website, $type)
{
    $updateSql = "UPDATE contacts SET name=?, email=?, address1=?, address2=?, primary_phone=?, secondary_phone=?, type=?, website=? WHERE id=?;";
    $stmt = $db->prepare( $updateSql);
    return $stmt->execute([$name, $email, $address1, $address2, $primary_phone, $secondary_phone, $type, $website, $contactId]);
}

function updateCompanyContact($db, $contactId, $name, $email, $address1, $address2, $primary_phone, $secondary_phone, $website, $company_logo, $type)
{
    $updateSql = "UPDATE contacts SET name=?, email=?, address1=?, address2=?, primary_phone=?, secondary_phone=?, type=?, website=?, company_logo=? WHERE id=?;";
    $stmt = $db->prepare( $updateSql);
    // var_dump($company_logo);exit;

    return $stmt->execute([$name, $email, $address1, $address2, $primary_phone, $secondary_phone, $type, $website, $company_logo, $contactId]);
}
