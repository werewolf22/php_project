<?php
session_start();
$user_session_id = $_SESSION['userid'];
if (!isset($user_session_id)) {
    // echo "<p class='text-center'>You are not authorized to view this page. Go back <a href= '/php_login_system/index.php'>home</a></p>";
    header("location: index.php");
    exit();
}
