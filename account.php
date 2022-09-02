<?php
require_once 'partials/head.php';
require_once 'includes/session.inc.php';
require_once 'partials/navbar.php';
require_once 'partials/aside.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="content-wrapper">
            <!-- <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="ml-4 text-dark">Log In your Account</h1>
                        </div>
                    </div>
                </div>
            </div> -->

            <section class="content">
                <div class="container text-center">
                    <h1 style="padding-top: 20px;">Welcome <?php echo $_SESSION['usersName'] ?></h1>
                </div>
        </div>
        </section>
    </div>
    <?php
    require_once 'partials/footer.php'
    ?>