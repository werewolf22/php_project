<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';
require_once '../../src/includes/functions.php';
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="ml-4 text-dark">Add new Student</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <?php include_once 'partials/message.php' ?>
            <form action='../../src/signUp.php' method='POST'>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Please enter your name" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Please enter your email" required>
                </div>

                <div class="form-group">
                    <label>Registration No.</label>
                    <input type="text" class="form-control" name="registration_no" placeholder="Please enter your registration no">
                </div>

                <div class="form-group">
                    <label>Phone No.</label>
                    <input type="text" class="form-control" name="phone_no" placeholder="Please enter your phone no">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Please enter your password" required>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Please enter your confirm password" required>
                </div>

                <button class='btn btn-success' type='submit' name='add_user'>Add User</button>
                <a href="users.php"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
            </form>
        </div>
    </section>
</div>
<?php
require_once 'partials/backendFooter.php'
?>