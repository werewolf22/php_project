<?php

require_once 'db.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['addContact'])) {

    $name = $_POST['name'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $email = $_POST['email'];
    $primary_phone = $_POST['primary_phone'];
    $secondary_phone = $_POST['secondary_phone'];

    $selectedType = $_POST['type'];

    if ($selectedType == 'individual') {
        createContact($conn, $name, $address1, $address2, $email, $primary_phone, $secondary_phone, $selectedType);
    } else if ($selectedType == 'company') {
        $company_name = $_POST['company_name'];
        $company_address = $_POST['company_address'];
        $company_website = $_POST['company_website'];

        $company_logoContent;

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
                echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
            }
        }

        createContact($conn, $name, $address1, $address2, $email, $primary_phone, $secondary_phone, $selectedType, $company_name, $company_address, $company_website, $company_logoContent);
    }
} else {
    header("location: ../add_contact.php");
    exit();
}
