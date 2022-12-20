<?php
require_once "includes/functions.php";
require_once "includes/connection.php";
require_once "includes/session.php";

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
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

                    $executed = updateUser($db, $name, $email, $id, $password);
                    if ($executed) {
                        $_SESSION['success'] = "User updated sucessfully";
                        header("location: ../backend/users.php");
                        exit();
                    } else {
                        echo "<p class='test-center'>Failed to update password, Try again!!</p>";
                        exit();
                    }
                }else {
                    echo "<p class='test-center'>Failed to verify password, Try again!!</p>";
                    exit();
                }
            }
        }else{
            $executed = updateUser($db, $name, $email, $id);
            // var_dump($executed);exit;
            if ($executed) {
                $_SESSION['success'] = "User updated sucessfully";
                header("location: ../backend/users.php");
                exit();
            } else {
                echo "<p class='test-center'>Failed, Try again!!</p>";
                exit();
            }
        }
    }


}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $db->prepare( $delete_sql);
    

    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "User deleted sucessfully";
        header("location: ../backend/users.php");
        exit();
    } else {
        echo "<p>Failed, Try again!!</p>";
    }
}
