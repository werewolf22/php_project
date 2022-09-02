<?php

require_once "db.inc.php";
require_once "functions.inc.php";

$contactId = $_POST["contact_id"];


if (isset($_POST['addContactDocuments'])) {

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $targetDir = "/var/www/html/php_login_system/uploads/";
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'doc', 'docx', 'pdf');

    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    $fileNames = array_filter($_FILES['file_names']['name']);
    if (!empty($fileNames)) {
        foreach ($_FILES['file_names']['name'] as $key => $val) {
            // File upload path 
            $fileName = basename($_FILES['file_names']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;

            // Check whether file type is valid 
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server 
                if (move_uploaded_file($_FILES["file_names"]["tmp_name"][$key], $targetFilePath)) {
                    // Image db insert sql 
                    $insertValuesSQL .= "('" . $fileName . "', '" . $contactId . "'),";
                } else {
                    $errorUpload .= $_FILES['file_names']['name'][$key] . ' | ';
                }
            } else {
                $errorUploadType .= $_FILES['file_names']['name'][$key] . ' | ';
            }
        }

        if (!empty($insertValuesSQL)) {

            $insertValuesSQL = trim($insertValuesSQL, ',');

            // Insert image file name into database 
            $insert = "INSERT INTO contact_documents (file_names, contact_id) VALUES $insertValuesSQL";

            $runInsert = mysqli_query($conn, $insert);

            if ($runInsert) {
                $errorUpload = !empty($errorUpload) ? 'Upload Error: ' . trim($errorUpload, ' | ') : '';
                $errorUploadType = !empty($errorUploadType) ? 'File Type Error: ' . trim($errorUploadType, ' | ') : '';
                $errorMsg = !empty($errorUpload) ? '<br/>' . $errorUpload . '<br/>' . $errorUploadType : '<br/>' . $errorUploadType;

                header("location: ../contact_documents.php?id=" . $contactId);
                exit();
            } else {
                die("failed");

                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $statusMsg = 'Please select a file to upload.';
    }

    // Display status message 
    echo $statusMsg;
}
