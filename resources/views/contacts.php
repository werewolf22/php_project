<?php
require_once 'includes/db.inc.php';
require_once 'includes/contact_delete.inc.php';
require_once 'partials/head.php';
require_once 'includes/session.inc.php';
require_once 'partials/navbar.php';
require_once 'partials/aside.php';

$sql = 'SELECT * FROM contacts ORDER BY id desc;';
$result = mysqli_query($conn, $sql);


if (!$result) {
    die("Could not get users data: " . mysqli_error($conn));
}

?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="ml-4 text-dark">Contacts</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="text-center" style="color:green">
                        <?php

                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == "none-contact-created") {
                                echo "<p>Contact added successfully.</p>";
                            } elseif ($_GET['error'] == "none-contact-updated") {
                                echo "<p>Contact updated successfully.</p>";
                            } elseif ($_GET['error'] == 'none-contact-deleted') {
                                echo "<p>Contact deleted successfully.</p>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="container">
                    <a href="contact_add.php">
                        <button class="btn btn-primary">Add</button>
                    </a><br><br>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Address1</th>
                                <th scope="col">Address2</th>
                                <th scope="col">Primary Phone</th>
                                <th scope="col">Secondary Phone</th>
                                <th scope="col">Type</th>
                                <th scope="col">Company Name</th>
                                <th scope="col">Company Address</th>
                                <th scope="col">Company Website</th>
                                <th scope="col">Company Logo</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    // var_dump($row);
                                    // die();

                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['address1'] . "</td>";
                                    echo "<td>" . $row['address1'] . "</td>";
                                    echo "<td>" . $row['primary_phone'] . "</td>";
                                    echo "<td>" . $row['secondary_phone'] . "</td>";
                                    echo "<td>" . $row['type'] . "</td>";
                                    echo "<td>" . $row['company_name'] . "</td>";
                                    echo "<td>" . $row['company_address'] . "</td>";
                                    echo "<td>" . $row['company_website'] . "</td>";
                                    echo "<td>";
                                    ?><img width="70" height="70" src="data:charset=utf8;base64,<?php echo base64_encode($row['company_logo']); ?>" /> <?php
                                    echo "</td>";


                                    echo "<td><a class=\"btn btn-success btn-sm\" href=\"contact_edit.php?id=$row[id]\">Edit</a>";
                                    echo " <a class=\"btn btn-danger btn-sm\" href=\"contacts.php?id=$row[id]\" 
                                        onClick=\"return confirm('Are you sure want to delete contact & its documents too?'); \">Delete</a>";
                                    echo " <a class=\"btn btn-warning btn-sm\" href=\"contact_documents.php?id=$row[id]\">Documents</a>";

                                    echo "</td></tr>";
                                }
                            } else {
                                mysqli_free_result($result);
                                echo "<br>Currently thers are no any records!";
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
                </form>
        </div>
        </section>
    </div>
    <?php
    require_once 'partials/footer.php'
    ?>