<?php
require_once "../../src/includes/connection.php";
require_once "../../src/includes/functions.php";
if ($_SESSION['userId'])
$currentUser = getCurrentUser();

// Get the current URL
$url = $_SERVER['REQUEST_URI'];

// Remove query string if any
$url = strtok($url, '?');

// Break into parts
$parts = explode('/', rtrim($url, '/'));

// Get the last part
$lastSegment = end($parts);
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Library Management System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link <?php if($lastSegment=='dashboard.php') echo 'active' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class='nav-item has-treeview'>
                    <a href='#' class='nav-link'>
                        <i class='nav-icon far fa-address-book'></i>
                        <p>
                            Books
                            <i class='right fas fa-angle-left'></i>
                        </p>
                    </a>
                    <ul class='nav nav-treeview' <?php if($lastSegment=='books.php'|| $lastSegment=='authors.php') echo 'style="display:block;"' ?>>
                    <li class='nav-item'>
                            <a href='books.php' class='nav-link <?php if($lastSegment=='books.php') echo 'active' ?>'>
                                <i class='far fa-circle nav-icon'></i>
                                <p>Library Book List</p>
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a href='books.php' class='nav-link <?php if($lastSegment=='books.php') echo 'active' ?>'>
                                <i class='far fa-circle nav-icon'></i>
                                <p>Issued Book List</p>
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a href='books.php' class='nav-link <?php if($lastSegment=='books.php') echo 'active' ?>'>
                                <i class='far fa-circle nav-icon'></i>
                                <p>Unreturned Book List</p>
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a href='books.php' class='nav-link <?php if($lastSegment=='books.php') echo 'active' ?>'>
                                <i class='far fa-circle nav-icon'></i>
                                <p>Book On Hold List</p>
                            </a>
                        </li>

                        <li class='nav-item'>
                            <a href='authors.php' class='nav-link <?php if($lastSegment=='authors.php') echo 'active' ?>'>
                                <i class='far fa-circle nav-icon'></i>
                                <p>Author List</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <?php
                if ($_SESSION['userId']) {
                    if($currentUser['is_admin']){
                        ?>
                        <li class='nav-item has-treeview'>
                            <a href='#' class='nav-link'>
                                <i class='nav-icon fas fa-user-alt'></i>
                                <p>
                                    Students
                                    <i class='right fas fa-angle-left'></i>
                                </p>
                            </a>
                            <ul class='nav nav-treeview' <?php if($lastSegment=='users.php') echo 'style="display:block;"' ?>>
                                <li class='nav-item'>
                                    <a href='users.php' class='nav-link <?php if($lastSegment=='users.php') echo 'active' ?>'>
                                        <i class='far fa-circle nav-icon'></i>
                                        <p>Student List</p>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                        
                        
                    <?php
                    }else{
                        ?>
                        <li class="nav-item">
                            <a href="users.php" class="nav-link">
                                <i class="nav-icon fas fa-user-alt"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>