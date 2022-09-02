<?php

// signup start

function emptyInputSignup($username, $email, $password, $confirm_password)
{
    $result;

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function emptyInputEditUser($username, $email, $old_password, $new_password, $new_confirm_password)
{
    $result;

    if (empty($username) || empty($email) || empty($old_password) || empty($new_password) || empty($new_confirm_password)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}


function invalidEmail($email)
{
    $result;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function passwordNotMatch($password, $confirm_password)
{
    $result;

    if ($password !== $confirm_password) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function emailExists($conn, $email)
{
    $sql = "SELECT * FROM users where usersEmail = ?;";

    // this is prepare statement and is used to prevent sql injection
    $stmt = mysqli_stmt_init($conn);

    // this is for handling if error that might happen in sql or any error
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    //mysqli_stmt_get_result() return data in object form
    $resultData = mysqli_stmt_get_result($stmt);

    // mysqli_fetch_assoc() return data in array form
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $username, $email, $password)
{
    $existing_user_session_id = $_SESSION['userid'];

    $sql = "INSERT INTO users (usersName, usersEmail, usersPassword) VALUES (?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $emailExists = emailExists($conn, $email);

    if ($existing_user_session_id == true) {
        header("location: ../users.php?error=none-created-user");
        exit();
    }
    session_start();
    $_SESSION['userid'] = $emailExists['usersId'];
    $_SESSION["usersName"] = $emailExists["usersName"];
    header("location: ../account.php");
    exit();
}

// signup end

// login start

function emptyInputLogin($email, $password)
{
    $result;

    if (empty($email) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function loginUser($conn, $email, $password)
{
    $emailExists = emailExists($conn, $email);

    if ($emailExists === false) {
        header("location: ../login.php?error=wronglogininput");
        exit();
    }

    $hashedPassword = $emailExists["usersPassword"];
    $checkPassword = password_verify($password, $hashedPassword);

    if ($checkPassword === false) {
        header("location: ../login.php?error=wrongpassword");
    } else if ($checkPassword === true) {
        session_start();
        $_SESSION["userid"] = $emailExists["usersId"];
        $_SESSION["usersName"] = $emailExists["usersName"];
        header("location: ../account.php");
        exit();
    }
}

// login end


//update user start

function updateUser($conn, $username, $email, $new_password, $hashedPassword, $user_password, $id)
{
    // $email = email that cames from user input
    // $new_password = new password type by user
    // $hashedPassword = hashed password of $new_password
    // $user_password = password from database
    // $id = user session id

    if (empty($new_password != false)) {
        $update_sql = "UPDATE users SET usersName='$username', usersEmail='$email', usersPassword='$user_password' WHERE usersId='$id'";
        $run_update = mysqli_query($conn, $update_sql);
    } else {
        $update_sql = "UPDATE users SET usersName='$username', usersEmail='$email', usersPassword='$hashedPassword' WHERE usersId='$id'";
        $run_update = mysqli_query($conn, $update_sql);
    }

    if ($run_update === true) {
        header("location: users.php?error=none-user-updated");
        exit();
    } else {
        echo "<p class='test-center'>Failed, Try again!!</p>";
        exit();
    }
}

function createContact($conn, $name, $address1, $address2, $email, $primary_phone, $secondary_phone, $type, $company_name = null, $company_address = null, $company_website = null, $company_logo = null)
{
    $insertSql = "INSERT INTO contacts(name, address1, address2, email, primary_phone, secondary_phone, type, company_name, company_address, company_website, company_logo) VALUES ('$name', '$address1', '$address2', '$email', '$primary_phone', '$secondary_phone', '$type', '$company_name', '$company_address', '$company_website', '$company_logo');";

    $runInsert = mysqli_query($conn, $insertSql);

    if ($runInsert) {
        header("location: ../contacts.php?error=none-contact-created");
        exit();
    } else {
        // echo "<p class='text-center'>Failed, Try again!!</p>";
        echo "Error: " . $runInsert . "<br>" . $conn->error;
    }
}

function updateContact($conn, $contactId, $name, $email, $address1, $address2, $primary_phone, $secondary_phone, $type, $company_name = null, $company_address = null, $company_website = null, $company_logo = null)
{
    $updateSql = "UPDATE contacts SET name='$name', email='$email', address1='$address1', address2='$address2', primary_phone='$primary_phone', secondary_phone='$secondary_phone', type='$type', company_name='$company_name', company_address='$company_address', company_website='$company_website', company_logo='$company_logo' WHERE id='$contactId';";
    $runUpdate = mysqli_query($conn, $updateSql);

    if ($runUpdate) {
        header("location: contacts.php?error=none-contact-updated");
        exit();
    } else {
        echo "Error: " . $updateSql . "<br>" . $conn->error;
    }
}
