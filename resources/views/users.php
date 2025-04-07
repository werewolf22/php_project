<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';
require_once "../../src/includes/connection.php";
require_once "../../src/includes/functions.php";

$currentUser = getCurrentUser();
if($currentUser['is_admin']) {
    $sql = 'SELECT * FROM users where is_admin != 1 ORDER BY id desc;';
} else {
    $sql = 'SELECT * FROM users where id = 1 ORDER BY id desc;';
}
$stmt = $db->prepare($sql);
if($currentUser['is_admin']) {
    $stmt->execute();
} else {
    $stmt->execute([$_SESSION['userId']]);
}

?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="ml-4 text-dark">
                        <?php if($currentUser['is_admin']) {
                            echo 'Students';
                        } else {
                            'Profile';
                        } ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <?php include_once 'partials/message.php' ?>
            <?php if($currentUser['is_admin']) { ?>
                <a href="userAdd.php">
                    <button class="btn btn-primary">Add</button>
                </a>
            <?php } ?>
            <form class="form-inline mt-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" name="search" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Registration No.</th>
                        <th scope="col">Phone No.</th>
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
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['registration_no']?: 'NA' . "</td>";
        echo "<td>" . $row['phone_no']?: 'NA' . "</td>";
        echo "<td><a class=\"btn btn-success btn-sm\" href=\"userEdit.php?id={$row['id']}\">Edit</a>";

        if ($_SESSION['userId'] != $row['id']) {
            echo " <a class=\"btn btn-danger btn-sm\" href=\"../../src/user.php?id={$row['id']}\" onClick=\"if(!confirm('Are you sure'))return false;\">Delete</a>";
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

    echo "<br>Currently there are no any records!";
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