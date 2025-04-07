<?php
require_once "includes/functions.php";
require_once "includes/connection.php";
require_once "includes/session.php";

if (isset($_POST['update'])) {
    $currentUser = getCurrentUser();
    if($currentUser['is_admin'])
    $message = 'Student';
    else {
        $message = 'Profile';
    }
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $registrationNo = trim($_POST['registration_no'])?:null;
    $phoneNo = trim($_POST['phone_no'])?:null;
    $oldPassword = $_POST['old_password']; 
    $password = $_POST['new_password']; 
    $confirmPassword = $_POST['confirm_new_password'];

    $fieldNames = ['name', 'email'];
    $passwordFieldNames = ['oldPassword', 'confirmPassword', 'password'];
    $errors = validate($fieldNames);

    if(!$errors){
        // you need to hash password
        if($oldPassword){

            $passwordErrors = validate($passwordFieldNames);
            if(!$passwordErrors){
                $sql = "SELECT * FROM users WHERE id=?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);        
            
                $checkPassword = password_verify($oldPassword, $result['password']);
            
                if($checkPassword){

                    $executed = updateUser($db, $name, $email, $id, password: $password);
                    if ($executed) {
                        $_SESSION['success'] = "$message updated sucessfully";
                        header("location: ../resources/views/users.php");
                        exit();
                    } else {
                        $_SESSION['error'][] = "Database error, Try again!!";
                        exit();
                    }
                }else {
                    $_SESSION['error'][] = "Failed to verify password, Try again!!";
                    header('location: '. $_SERVER['HTTP_REFERER']);
                    exit();
                }
            }else{
                $_SESSION['error'] = $passwordErrors;
                header('location: '. $_SERVER['HTTP_REFERER']);
                exit();
            }
        }else{
            $executed = updateUser($db, $name, $email, $id, $registrationNo, $phoneNo);
            // var_dump($executed);exit;
            if ($executed) {
                $_SESSION['success'] = "$message updated sucessfully";
                header("location: ../resources/views/users.php");
                exit();
            } else {
                $_SESSION['error'][] = "Database error, Try again!!";
                header('location: '. $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }else{
        $_SESSION['error'] = $errors;
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }


}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $db->prepare( $delete_sql);
    

    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "Student deleted sucessfully";
        header("location: ../resources/views/users.php");
        exit();
    } else {
        $_SESSION['error'][] = "Failed, Try again!!";
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
}
