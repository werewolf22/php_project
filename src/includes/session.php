<?php
    session_start();
    function redirectGuestUser(){
        if (!isset($_SESSION['userId'])){
            header('location: ../../resources/views/signIn.php');
            exit();
        }
    }
    function redirectSignedInUser(){
        // var_dump($_SESSION['userId']);die();
        if (isset($_SESSION['userId'])){
            header("location: ../../resources/views/dashboard.php");
            exit();
        }
    }