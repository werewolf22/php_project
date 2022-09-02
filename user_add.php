<?php
require_once 'partials/head.php';
require_once 'includes/session.inc.php';
require_once 'partials/navbar.php';
require_once 'partials/aside.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="ml-4 text-dark">Add new user</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="text-center" style="color:lightcoral">
                        <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == "emptyinput") {
                                echo "<p>Fill in all fields.</p>";
                            } else if ($_GET['error'] == "invalidemail") {
                                echo "<p>Choose a proper email.</p>";
                            } else if ($_GET['error'] == "passwordsdontmatch") {
                                echo "<p>Passwords do not match!</p>";
                            } else if ($_GET['error'] == "emailtaken") {
                                echo "<p>Email already taken!</p>";
                            } else if ($_GET['error'] == "none") {
                                echo "<p>You have signed up.</p>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="container">
                    <form action='includes/signup.inc.php' method='POST'>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Please enter your username" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Please enter your email" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Please enter your password" required>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" placeholder="Please enter your confirm password" required>
                        </div>

                        <button class='btn btn-success' type='submit' name='signup'>Add User</button>
                        <a href="users.php"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <?php
    require_once 'partials/footer.php'
    ?>