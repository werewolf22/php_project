<?php
    session_start();
    function redirectGuestUser(){
        if (!isset($_SESSION['userId'])){
            header('location: ../../resources/views/signIn.php');
            exit();
        }
    }
    function redirectSignedInUser(){
        if (isset($_SESSION['userId'])){
            heared("location: ../../resources/views/dashboard.php");
            exit();
        }
    }