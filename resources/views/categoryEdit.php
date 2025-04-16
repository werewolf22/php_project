<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';
require_once '../../src/includes/functions.php';
if($_GET['id']){
    $sql = "SELECT * FROM categories WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="ml-4 text-dark">Edit Category</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <?php include_once 'partials/message.php' ?>
            <form action='../../src/category.php' method='POST'>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Please enter category name" value="<?php echo $result['name'] ?>" required>
                </div>


                <button class='btn btn-success' type='submit' name='update'>Save</button>
                <a href="categories.php"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
            </form>
        </div>
    </section>
</div>
<?php
require_once 'partials/backendFooter.php'
?>