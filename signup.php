<?php
require_once 'header.php';
?>

<body>
    <div class='container'>


        <div>
            <h1>Register your Account</h1>
        </div>
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

            <button class='btn btn-primary' type='submit' name='signup'>Sign Up</button>
        </form>
    </div>

</body>

</html>