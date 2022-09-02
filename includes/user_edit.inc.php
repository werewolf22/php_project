<?php

    require_once 'db.inc.php';
    require_once 'functions.inc.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $edit_sql = "SELECT * FROM users where usersId = '$id'";
        $run_edit = mysqli_query($conn, $edit_sql);

        $user_data = mysqli_fetch_array($run_edit);

        // these are the data to put in form's value field fetch from database
        $user_name = $user_data['usersName'];
        $user_email = $user_data['usersEmail'];
        $user_password = $user_data['usersPassword'];
    }

    if (isset($_POST['update'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $old_password = $_POST['old_password']; 
        $new_password = $_POST['new_password']; 
        $confirm_new_password = $_POST['confirm_new_password']; 
    
        // you need to hash password
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

        if($email != $user_email){
            if (emailExists($conn, $email) !== false){
                    header("location: user_edit.php?id=$id&error=emailtakenbyother");
                    exit();
            }
        }

        $checkPassword = password_verify($old_password, $user_password);

        // if user want to change only username or email
        if (empty($old_password == false)){
            if($checkPassword === false){
                header("location: user_edit.php?error=wrongoldpassword");
                exit();
            }
        }

        if(passwordNotMatch($new_password, $confirm_new_password) === true){
            header("location: user_edit.php?error=passwordsdonotmatch");
            exit();
        }


        updateUser($conn, $username, $email, $new_password, $hashedPassword, $user_password, $id);

    }
