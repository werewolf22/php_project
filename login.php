<?php
require_once 'partials/head.php';
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
                            <h1 class="ml-4 text-dark">Log In your Account</h1>
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
                            } else if ($_GET['error'] == "wronglogininput") {
                                echo "<p>Incorrect login information.</p>";
                            } else if ($_GET['error'] == 'wrongpassword') {
                                echo "<p>Enter your correct password!!</p>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <form action='includes/login.inc.php' method='POST'>
                    <div class="container">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <button class='btn btn-primary' type='submit' name='login'>Log In</button>
                    </div>
                </form>
        </div>
        </section>
    </div>
    <?php
    require_once 'partials/footer.php'
    ?>