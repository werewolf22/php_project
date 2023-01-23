<?php
require_once 'includes/db.inc.php';
require_once 'partials/head.php';
require_once 'includes/session.inc.php';
require_once 'partials/navbar.php';
require_once 'partials/aside.php';

if (isset($_GET['id'])) {
    $contactId = $_GET['id'];
}

// $getContactData = "SELECT contact_documents.id, contacts.name FROM contact_documents INNER JOIN contacts ON contact_documents.contact_id = contacts.id;";
// $result = mysqli_query($conn, $getContactData);

$selectSql = "SELECT * FROM contact_documents WHERE contact_id = $contactId;";

$result = mysqli_query($conn, $selectSql);

if (!$result) {
    die("Could not get data: " . mysqli_error($conn));
}

?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="ml-4 text-dark">Contact Documents</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="text-center" style="color:green">
                <?php
                // require_once 'includes/contact_documents_delete.inc.php';
                ?>
            </div>
        </div>

        <div class="container">
            <a href="contact_documents_add.php?id=<?php echo $contactId ?>">
                <button class="btn btn-primary">Add</button>
            </a><br><br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">File Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['file_name'] . "</td>";
                            // echo "<td><a class=\"btn btn-success btn-sm\" href=\"user_edit.php?document_id=$row[id]\">Edit</a>";
                            echo "<td>";
                            echo " <a class=\"btn btn-danger btn-sm\" href=\"../includes/contact_documents_delete.inc.php?id={$contactId}&document_id=$row[id]\">Delete</a>";
                            echo "</td></tr>";
                        }
                    } else {
                        // it accept a result object as parameter and frees the memory associated with it.
                        mysqli_free_result($result);
                        echo "<br>Currently thers are no any records!";
                    }
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php require_once 'partials/footer.php' ?>