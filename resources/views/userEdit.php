<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once "../../src/includes/connection.php";
require_once "../../src/includes/functions.php";
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';

if($_GET['id']){
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentUser = getCurrentUser();
}
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="ml-4 text-dark"><?php echo $currentUser['is_admin'] ? 'Edit Student': 'Edit Profile' ?></h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <?php include_once 'partials/message.php' ?>
            <form action='../../src/user.php' method='POST'>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <div class="container">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $result['name'] ?>" placeholder="Please enter your name" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $result['email'] ?>" placeholder="Please enter your email" required>
                    </div>

                    <div class="form-group">
                        <label>Registration No.</label>
                        <input type="text" class="form-control" name="registration_no" value="<?php echo $result['registration_no'] ?>" placeholder="Please enter your registration no">
                    </div>

                    <div class="form-group">
                        <label>Phone No.</label>
                        <input type="text" class="form-control" name="phone_no" value="<?php echo $result['phone_no'] ?>" placeholder="Please enter your phone no">
                    </div>

                    <div class="form-group">
                        <label>Old Password</label>
                        <input type="password" class="form-control" name="old_password" placeholder="Please enter your old password">
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" name="new_password" placeholder="Please enter your new password">
                    </div>

                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" class="form-control" name="confirm_new_password" placeholder="Please enter your retype new password">
                    </div>

                    <button class='btn btn-success' type='submit' name='update'>Update User</button>
                    <a href="users.php"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
                </div>
            </form>
        </div>
    </section>
</div>
<?php
require_once 'partials/backendFooter.php'
?>