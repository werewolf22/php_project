<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">PHP project</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <?php
                if ($_SESSION['userId']) {
                    echo
                    "<li class='nav-item has-treeview'>
                        <a href='#' class='nav-link'>
                            <i class='nav-icon fas fa-user-alt'></i>
                            <p>
                                Users
                                <i class='right fas fa-angle-left'></i>
                            </p>
                        </a>
                        <ul class='nav nav-treeview'>
                            <li class='nav-item'>
                                <a href='users.php' class='nav-link'>
                                    <i class='far fa-circle nav-icon'></i>
                                    <p>User Lists</p>
                                </a>
                            </li>
                            
                        </ul>
                    </li>";
                    echo
                    "<li class='nav-item has-treeview'>
                        <a href='#' class='nav-link'>
                            <i class='nav-icon far fa-address-book'></i>
                            <p>
                                Contacts
                                <i class='right fas fa-angle-left'></i>
                            </p>
                        </a>
                        <ul class='nav nav-treeview'>
                            <li class='nav-item'>
                                <a href='contacts.php' class='nav-link'>
                                    <i class='far fa-circle nav-icon'></i>
                                    <p>Contact Lists</p>
                                </a>
                            </li>
                            
                        </ul>
                    </li>";
                }
                ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>