   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-white navbar-light">
       <!-- Left navbar links -->
       <ul class="navbar-nav">
           <li class="nav-item">
               <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
           </li>
       </ul>

       <!-- Right navbar links -->
       <ul class="navbar-nav ml-auto">
           <li class="nav-item d-none d-sm-inline-block">
               <?php
                if (!$_SESSION['userId']) {
                    echo "<a href='login.php' class='nav-link'>Login</a>";
                } else {
                    echo "<a href='../../src/signOut.php' class='nav-link'>Logout</a>";
                }
                ?>
           </li>
       </ul>
   </nav>
   <!-- /.navbar -->