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
                    <h1 class="ml-4 text-dark">Add new Book</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <?php include_once 'partials/message.php' ?>
            <form action='../../src/book.php' method='POST'>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Please enter book title" required>
                </div>
                <div class="form-group">
                    <label>ISBN No.</label>
                    <input type="text" class="form-control" name="isbn_no" placeholder="Please enter ISBN No." required>
                </div>
                <div class="form-group">
                    <label>Author</label>
                    <select class="form-control" name="author_id" required>
                        <option value="">Select Author</option>
                        <?php
                        $sql = "select * from authors";
                        $stmt = $db->prepare($sql);
                        $stmt->execute();
                        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($authors as $author ) {
                            echo '<option value="'.$author['id'].'">'.$author['name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php
                        $sql = "select * from categories";
                        $stmt = $db->prepare($sql);
                        $stmt->execute();
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($categories as $category ) {
                            echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Total Copies</label>
                    <input type="number" class="form-control" name="total_copies" placeholder="Please enter total copies" required>
                </div>

                <button class='btn btn-success' type='submit' name='add'>Save</button>
                <a href="books.php"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
            </form>
        </div>
    </section>
</div>
<?php
require_once 'partials/backendFooter.php'
?>