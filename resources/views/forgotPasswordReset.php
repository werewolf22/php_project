<?php include_once "../../src/includes/session.php"; ?>
<?php redirectSignedInUser(); ?>
<?php require_once "../../src/includes/connection.php";?>
<?php
$sql = "SELECT * FROM password_resets WHERE email = ? and token = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$_GET['email'],$_GET['token']]);
if(!$stmt->rowCount()){
    die("Something went wrong.");
}
?>
<?php include_once "partials/header.php"; ?>
<div class='col-md-4 offset-4 mt-4'>
    <h3>Use below form to reset your password</h3>
    <form name="forgotPasswordReset" action="src/forgotPassword.php" method="post">
    <div class="mb-3">
        <label for="password" class="form-label"> Password</label>
        <input type="password" name="password" class="form-control" id="password" >
    </div>
    <!-- <div class="mb-3"> -->
        <input type="hidden" name="email" class="form-control" id="email" value="<?php echo $_GET['email'] ?>">
    <!-- </div> -->
    <div class="mb-3">
        <label for="confirmPassword" class="form-label">Retype Password</label>
        <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" >
    </div>
    <button type="submit" name="forgotPasswordResetSubmit" class="btn btn-primary">change password</button>
    </form>
</div>
<?php require_once "partials/footer.php"; ?>