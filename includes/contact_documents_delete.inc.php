<?php
$serverName = 'localhost';
$dbUsername = 'admin';
$dbPassword = 'admin';
$dbName = 'php_login_system';

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (isset($_GET)) {
    $documentId = $_GET['document_id'];
    $contactId = $_GET['id'];

    $deleteSql = "DELETE FROM contact_documents WHERE id = '$documentId'";
    $runDelete = mysqli_query($conn, $deleteSql);

    if ($runDelete) {
        echo "<p class='text-center' style='color: green;'>Document deleted successfully.</p>";
        header("location: ../contact_documents.php?id=" . $contactId);
    } else {
        echo "<p>Failed, Try again!!</p>";
    }
}
