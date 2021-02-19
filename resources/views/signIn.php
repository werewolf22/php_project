<?php include_once "../../src/includes/session.php"; ?>
<?php redirectSignedInUser(); ?>
<?php include_once "partials/header.php" ?>
    
    <div class= "container">
        <div class='col-md-4 offset-4 mt-4'>
            <h3>Sign In Your Account</h3>
            <form name="signIn" action="../../src/signIn.php" method="post">
            <div class="mb-3">
                <label for="signInEmail" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="signInEmail" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="signInPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="signInPassword">
            </div>
            <!-- <div class="mb-3 form-check">
                <input type="checkbox" name="rememberMe" class="form-check-input" id="signInRememberMe">
                <label class="form-check-label" for="signInRememberMe">Remember me</label>
            </div> -->
            <button type="submit" name="submit" class="btn btn-primary">Sign In</button>
            </form>
            <a href="forgotPassword.php" class="btn btn-secondary" style="margin:10px 0;">Forgot Password</a>
        </div>
        
    </div>
<?php require_once "partials/footer.php" ?>