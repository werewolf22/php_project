<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';
require_once "../../src/includes/connection.php";
require_once "../../src/includes/functions.php";

$sql = 'SELECT * FROM contacts ORDER BY id desc;';
$stmt = $db->prepare($sql);
$stmt->execute();


?>


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
            <div class="text-center" style="color:<?php echo isset($_SESSION['success'])? "green": "red" ?>">
            <?php

            if (isset($_SESSION['error'])) {
                echo $_SESSION['error'];
                unsetErrorSession();
            }elseif (isset($_SESSION['success'])) {
                echo $_SESSION['success'];
                unsetSuccessSession();
            }

            ?>
            </div>
        </div>
        <div class="container">
            <a href="contactAdd.php">
                <button class="btn btn-primary">Add</button>
            </a><br><br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Address 1</th>
                        <th scope="col">Address 2</th>
                        <th scope="col">Primary Phone</th>
                        <th scope="col">Secondary Phone</th>
                        <th scope="col">Company Website</th>
                        <th scope="col">Company Logo</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($stmt->rowCount() > 0) {
                        $i = 1;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // var_dump($row);
                            // die();

                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['address1'] . "</td>";
                            echo "<td>" . $row['address2'] . "</td>";
                            echo "<td>" . $row['primary_phone'] . "</td>";
                            echo "<td>" . $row['secondary_phone'] . "</td>";
                            echo "<td>" . $row['website'] . "</td>";
                            echo "<td>";
                            ?><img width="70" height="70" src="data:charset=utf8;base64,<?php echo base64_encode($row['company_logo']); ?>" /> <?php
                            echo "</td>";
                            echo "<td>" . $row['type'] . "</td>";


                            echo "<td><a class=\"btn btn-success btn-sm\" href=\"contactEdit.php?id=$row[id]\">Edit</a>";
                            echo " <a class=\"btn btn-danger btn-sm\" href=\"../src/contact.php?id=$row[id]\" 
                                onClick=\"return confirm('Are you sure want to delete contact & its documents too?'); \">Delete</a>";
                            echo " <a class=\"btn btn-warning btn-sm\" href=\"contactDocuments.php?id=$row[id]\">Documents</a>";

                            echo "</td></tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan=\"11\">Currently there are no any records!</td></tr>";
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