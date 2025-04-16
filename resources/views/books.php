<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';
require_once "../../src/includes/connection.php";
require_once "../../src/includes/functions.php";

$sql = 'SELECT b.*, c.name as book_category, a.name as author FROM books b left join authors a on a.id = b.author_id left join categories c on c.id= b.category_id where 1=1 ';
$values = [];
if(isset($_GET['category_id']) && $_GET['category_id']) {
    $sql .=' and b.category_id=? ';
    $values[] = trim($_GET['category_id']); 
}
if(isset($_GET['author_id']) && $_GET['author_id']) {
    $sql .=' and b.author_id=? ';
    $values[] = trim($_GET['author_id']); 
}
if(isset($_GET['search']) && $_GET['search']) {
    $sql .=' and (lower(b.title) like ? or lower(b.isbn_no) like ?) ';
    $searchParam = "%".strtolower(trim($_GET['search']))."%";
    $values[] = $searchParam; 
    $values[] = $searchParam; 
}
$sql.= ' ORDER BY b.id desc;';

$stmt = $db->prepare($sql);
$stmt->execute($values);

$currentUser = getCurrentUser();

?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="ml-4 text-dark">
                        Library Books
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <?php include_once 'partials/message.php' ?>
            <?php if($currentUser['is_admin']) { ?>
            <a href="bookAdd.php">
                <button class="btn btn-primary">Add</button>
            </a>
            <?php } ?>
            <form class="form-inline mt-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" name="search" type="search" value="<?php if(isset($_GET['search']) && $_GET['search']) echo trim($_GET['search']) ?>" placeholder="Search"
                        aria-label="Search">
                    <select class="form-control form-control-navbar mx-1" name="author_id">
                        <option value="">Select Author</option>
                        <?php
                        $sql = "select * from authors";
                        $autstmt = $db->prepare($sql);
                        $autstmt->execute();
                        $authors = $autstmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($authors as $author ) {
                            echo '<option value="'.$author['id'].'" '.($author['id']==$_GET['author_id']?'selected':'').'>'.$author['name'].'</option>';
                        }
                        ?>
                    </select>
                    <select class="form-control form-control-navbar mx-1" name="category_id">
                        <option value="">Select Category</option>
                        <?php
                        $sql = "select * from categories";
                        $catstmt = $db->prepare($sql);
                        $catstmt->execute();
                        $categories = $catstmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($categories as $category ) {
                            echo '<option value="'.$category['id'].'" '.($category['id']==$_GET['category_id']?'selected':'').'>'.$category['name'].'</option>';
                        }
                        ?>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form><br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">ISBN No.</th>
                        <th scope="col">Author</th>
                        <th scope="col">category</th>
                        <th scope="col">Available Copies</th>
                        <th scope="col">Total Copies</th>

                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
    $i = 1;
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['isbn_no'] . "</td>";
        echo "<td>" . $row['author'] . "</td>";
        echo "<td>" . $row['book_category'] . "</td>";
        echo "<td>" . $row['available_copies'] . "</td>";
        echo "<td>" . $row['total_copies'] . "</td>";

        echo '<td>';
        if($currentUser['is_admin']) {
            echo " <a class=\"btn btn-success btn-sm\" href=\"bookEdit.php?id={$row['id']}\">Edit</a>";
            echo " <a class=\"btn btn-danger btn-sm\" href=\"../../src/book.php?id={$row['id']}\" onClick=\"if(!confirm('Are you sure'))return false;\">Delete</a>";
        }
        echo "</td></tr>";

        // echo "<tr>
        //         <td> " . $row["usersId"]. " </td>
        //         <td> " . $row["usersName"]. "</td>
        //         <td>" . $row["usersEmail"]. "</td>
        //         <td>
        //             <div class='btn-group' role='group'>
        //                 <a href='user_edit.php?id=". $row['usersId'] ."'> <button class='btn btn-success btn-sm'>Edit</button> </a>
        //                 <a href='users.php?id=". $row['usersId'] ."'> <button class='btn btn-danger btn-sm'>Delete</button> </a>
        //             </div>
        //         </td>
        //     </tr>";
        $i++;
    }
} else {

    echo "Currently there are no records!";
}
?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php
require_once 'partials/backendFooter.php'
?>