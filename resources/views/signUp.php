<?php include_once "../../src/includes/session.php"; ?>
<?php redirectSignedInUser(); ?>
<?php include_once "partials/header.php"; ?>
    <div class= "container">
        <div class='col-md-4 offset-4 mt-4'>
            <h3>Sign In Your Account</h3>
            <form name="signUp" action="../../src/signUp.php" method="post">
            <div class="mb-3">
                <label for="signUpName" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" id= "signUpName" >
            </div>
            <div class="mb-3">
                <label for="signUpEmail" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="signUpEmail" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="signUpPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="signUpPassword">
            </div>
            <div class="mb-3">
                <label for="signUpConfirmPassword" class="form-label">Retype Password</div>
                <input type="password" name="confirmPassword" class="form-control" id="signUpConfirmPassword">
            </div>
            <!-- <div class="mb-3 form-check">
                <input type="checkbox" name="rememberMe" class="form-check-input" id="signInRememberMe">
                <label class="form-check-label" for="signInRememberMe">Remember me</label>
            </div> -->
            <button type="submit" name="submit" class="btn btn-primary" style="margin:20px 366px">Sign Up</button>
            </form>
        </div>
        
    </div>
<?php require_once "partials/footer.php"; ?>