<?php if (isset($_SESSION['error']) || isset($_SESSION['success'])) { ?>
<div class="row">
    <div class="col-md-6">

        <div
            class="card bg-gradient-<?php echo isset($_SESSION['success']) ? "success" : "danger" ?>">
            <div class="card-header">
                <h3 class="card-title">
                    <?php echo isset($_SESSION['success']) ? "Success" : "Error" ?>
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?php

                    if (isset($_SESSION['error'])) {
                        ?>
                        <ul>
                            <?php foreach ($_SESSION['error'] as $key => $error) {
                                if(is_array($error)) $error = $error[0];
                                if($error == 'required')
                                echo "<li>{$key} is {$error}</li>";
                                else
                                echo "<li>{$error}</li>";
                            } ?>
                            
                        </ul>

                        <?php
                        unsetErrorSession();
                    } elseif (isset($_SESSION['success'])) {
                        echo $_SESSION['success'];
                        unsetSuccessSession();
                    }
                ?>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<?php } ?>