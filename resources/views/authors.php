<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';
require_once "../../src/includes/connection.php";
require_once "../../src/includes/functions.php";

$sql = 'SELECT * FROM authors where 1=1 ';
$values = [];
if(isset($_GET['search']) && $_GET['search']){
    $sql .= 'and lower(name) like ? ';
    $values[] = '%'.strtolower(trim($_GET['search'])).'%';
}

$sql .= 'ORDER BY id desc;';
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
                        Authors
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <?php include_once 'partials/message.php' ?>
            <?php if($currentUser['is_admin']) { ?>
            <a href="authorAdd.php">
                <button class="btn btn-primary">Add</button>
            </a>
            <?php } ?>
            <form class="form-inline mt-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" name="search" type="search" placeholder="Search"
                        aria-label="Search" value="<?php echo isset($_GET['search']) && $_GET['search']? $_GET['search']:'' ?>">
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
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
    $i = 1;
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sql = 'SELECT count(id) as count FROM books where author_id=?;';
        $bookcountstmt = $db->prepare($sql);
        $bookcountstmt->execute([$row['id']]);
        $bookcount = $bookcountstmt->fetch(PDO::FETCH_ASSOC);

        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['name'] . "</td>";

        echo "<td><a class=\"btn btn-info btn-sm\" href=\"books.php?author_id={$row['id']}\">{$bookcount['count']} Books</a>";
        if($currentUser['is_admin']) {
            echo " <a class=\"btn btn-success btn-sm\" href=\"authorEdit.php?id={$row['id']}\">Edit</a>";
            echo " <a class=\"btn btn-danger btn-sm\" href=\"../../src/author.php?id={$row['id']}\" onClick=\"if(!confirm('Are you sure'))return false;\">Delete</a>";
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