<?php
require_once 'partials/head.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php
        // var_dump('hello world');die();
        require_once 'partials/navbar.php';
        require_once 'partials/aside.php';
        ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <h3>Welcome to PHP Login System</h3>
                </div>
            </section>
        </div>
        <?php
        require_once 'partials/footer.php'
        ?>