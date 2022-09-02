<?php

$serverName = 'localhost';
$dbUsername = 'admin';
$dbPassword = 'admin';
$dbName = 'php_login_system';

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
