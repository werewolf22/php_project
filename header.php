<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>PHP Login System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">

      <ul class="nav navbar-nav">
        <?php

        if (isset($_SESSION['userid'])) {
          echo '<li class="active"><a href="account.php">Home</a></li>';
          echo '<li class="active"><a href="users.php">Users</a></li>';
        } else {
          echo '<li class="active"><a href="index.php">Home</a></li>';
        }
        ?>

      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
        if (isset($_SESSION["userid"])) {
          echo "<li><a href='includes/logout.inc.php'>Log Out</a></li>";
        } else {
          echo "<li><a href='signup.php'><span class='glyphicon glyphicon-user'></span> Sign Up</a></li>";
          echo "<li><a href='login.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
        }
        ?>

      </ul>
    </div>
  </nav>