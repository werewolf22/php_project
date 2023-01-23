<?php
require_once 'includes/connection.php';
require_once 'includes/session.php';
require_once 'includes/functions.php';
// image uploading in database is bad practise
if (isset($_POST['addContact'])) {

    $name = $_POST['name'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $email = $_POST['email'];
    $primary_phone = $_POST['primary_phone'];
    $secondary_phone = $_POST['secondary_phone'];
    $website = $_POST['website'];

    $selectedType = $_POST['type'];

    if ($selectedType == 'Individual') {
        $returnValue = createIndividualContact($db, $name, $address1, $address2, $email, $primary_phone, $secondary_phone, $website, $selectedType);
        // var_dump($returnValue);exit;
        if($returnValue){
            $_SESSION['success'] = "Individual Contact Created successfully.";
            header("location: ../backend/contacts.php");
            exit;
        }
    } else if ($selectedType == 'Company') {

        $company_logoContent;
        var_dump($company_logo);exit;
        if (!empty($_FILES["company_logo"]["name"])) {
            // get file info
            $fileName = basename($_FILES["company_logo"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            // allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                $company_logo = $_FILES["company_logo"]["tmp_name"];
                $company_logoContent = addslashes(file_get_contents($company_logo));
            } else {
                $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
                header("location: ../backend/contacts.php");
                exit;
            }
        }

        $returnValue = createCompanyContact($db, $name, $address1, $address2, $email, $primary_phone, $secondary_phone, $website, $company_logoContent, $selectedType);
        if($returnValue){
            $_SESSION['success'] = "Company Contact Created successfully.";
            header("location: ../backend/contacts.php");
            exit;
        }
    }
}


if (isset($_POST['updateContact'])) {
    $contactId= $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $primary_phone = $_POST['primary_phone'];
    $secondary_phone = $_POST['secondary_phone'];
    $website = $_POST['website'];
    $type = $_POST['type'];

    if ($type == "Individual") {
        $returnValue = updateIndividualContact($db, $contactId, $name, $email, $address1, $address2, $primary_phone, $secondary_phone, $website, $type);
        if ($returnValue) {
            $_SESSION['success'] = "Individual Contact Updated Successfully";
            header("location: ../backend/contacts.php");
            exit;
        }
    } else if ($type == "Company") {

        // if user update with blank logo, it will erase existing img, it need to fix later
        $company_logoContent;
        // $company_logoContent = $contactCompanyLogo;

        if (!empty($_FILES["company_logo"]["name"])) {
            // get file info
            $fileName = basename($_FILES["company_logo"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            // allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                $company_logo = $_FILES["company_logo"]["tmp_name"];
                $company_logoContent = addslashes(file_get_contents($company_logo));
            } else {
                $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
                header("location: ../backend/contacts.php");
                exit;
            }
        }

        $returnValue = updateCompanyContact($db, $contactId, $name, $email, $address1, $address2, $primary_phone, $secondary_phone, $website, $company_logoContent, $type);
        // var_dump($company_logoContent);exit;
        if ($returnValue) {
            $_SESSION['success'] = "Company Contact Updated Successfully";
            header("location: ../backend/contacts.php");
            exit;
        }
    }
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // $deleteContactWithItsRelatedFiles = "DELETE t1, t2 FROM contacts t1 INNER JOIN contact_documents t2 ON t1.id = t2.contact_id WHERE t1.id = $id;";

    $deleteContactRelatedFiles = "DELETE  FROM contact_documents WHERE contact_id=?;";
    $stmt = $db->prepare( $deleteContactRelatedFiles);

    $deleteContact = "DELETE  FROM contacts WHERE id=?;";
    $contactDelSmt = $db->prepare( $deleteContact);

    if ($stmt->execute([$id]) && $contactDelSmt->execute([$id])) {
        $_SESSION['success'] = "Contact deleted successfully";
        header("location: ../backend/contacts.php");
        exit;
    } else {
        echo "<p>Failed, Try again!!</p>";
    }
}




if (isset($_POST['addContactDocuments'])) {
    $contactId = $_POST["contact_id"];

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


if (isset($_GET['document_id'])) {
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