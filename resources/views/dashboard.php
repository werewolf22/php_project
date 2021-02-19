<?php include_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php include_once "partials/header.php"; ?>
<div class="container">
    <div class="row">
    <div class= "col-md">
        <p>Welcome! <?php echo $_SESSION['userName']; ?> </p>
    </div>
    </div>
</div>
<?php require_once "partials/footer.php"; ?>