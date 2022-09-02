<?php
require_once 'header.php';
require_once 'includes/session.inc.php';
require_once 'includes/db.inc.php';
require_once 'includes/user_edit.inc.php';
?>

<body>
    <div class='container'>

        <div>
            <div>
                <h3>Edit User</h3>
            </div>
            <div class="text-center" style="color:lightcoral">
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == "emailtakenbyother") {
                        echo "Email already exists!";
                    } else if ($_GET['error'] == "wrongoldpassword") {
                        echo "Old password did not match!!";
                    } else if ($_GET['error'] == "passwordsdonotmatch") {
                        echo "New password and confirm new password do not match";
                    }
                }
                ?>
            </div>
        </div>
        <form action='' method='POST'>
            <div class="container">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" value="<?php echo $user_name ?>" placeholder="Please enter your username" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $user_email ?>" placeholder="Please enter your email" required>
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

                <button class='btn btn-success' type='submit' name='update'>Update</button>
                <a href="users.php"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
            </div>
        </form>
    </div>

</body>

</html>