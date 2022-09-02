<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // $deleteContactWithItsRelatedFiles = "DELETE t1, t2 FROM contacts t1 INNER JOIN contact_documents t2 ON t1.id = t2.contact_id WHERE t1.id = $id;";

    $deleteContactWithItsRelatedFiles = "DELETE t1, t2 FROM contacts t1 LEFT JOIN contact_documents t2 ON t1.id = t2.contact_id WHERE t1.id=$id;";
    $runDelete = mysqli_query($conn, $deleteContactWithItsRelatedFiles);

    if ($runDelete) {
        header("location: contacts.php?error=none-contact-deleted");
    } else {
        echo "<p>Failed, Try again!!</p>";
    }
}
