<?php 
    $signedIn = isset($_SESSION['userId']);
    // if(!isset($indexPage)) $indexPage = false;
    
    // if($indexPage){
    //     $relativePathToViewsFromPublic = '../resources/views/';
    //     $relativePathToPublicFromResources = '';
    // } else {
    //     $relativePathToPublicFromResources = '../../public/';
    //     $relativePathToViewsFromPublic = '';
    // }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="../../public/css/bootstrap.min.css" rel="stylesheet">

        <title>Library Management System php project</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Library Management System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end d-flex" id="navbarSupportedContent">
                <!-- <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                </ul> -->
                <?php 
                    if ($signedIn){
                        echo '<li class="nav-item dropdown d-flex">
                            <span class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="./src/signOut.php">Sign Out</a></li>
                            </ul>
                        </li>';
                    }else{
                        echo '<ul class="nav">
                            <li class="nav-item">
                            <a class="nav-link " href="./signIn.php">Sign In</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link " href="./signUp.php">Sign Up</a>
                            </li>
                        </ul>';
                    }
                ?>
                
                </div>
            </div>
        </nav>
        
    <div class='container'>