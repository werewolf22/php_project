<?php include_once "../../src/includes/session.php"; ?>
<?php redirectSignedInUser(); ?>
<?php include_once "partials/header.php"; ?>
<div class='col-md-4 offset-4 mt-4'>
    <h3>Enter verified email to get the link to reset your password</h3>
    <form name="forgotPassword" action="../../src/forgotPassword.php" method="post">
    <div class="mb-3">
        <label for="forgotPasswordEmail" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="forgotPasswordEmail" >
    </div>
    <button type="submit" name="forgotPasswordSubmit" class="btn btn-primary">Send password reset link</button>
    </form>
</div>
<?php require_once "partials/footer.php"; ?>