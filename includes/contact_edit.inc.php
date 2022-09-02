<?php
require_once 'functions.inc.php';

if (isset($_GET['id'])) {
    $contactId = $_GET['id'];

    $selectSql = "SELECT * FROM contacts where id = '$contactId'";
    $runSelectSql = mysqli_query($conn, $selectSql);

    $contactData = mysqli_fetch_array($runSelectSql);

    $contactName = $contactData['name'];
    $contactEmail = $contactData['email'];
    $contactAddress1 = $contactData['address1'];
    $contactAddress2 = $contactData['address2'];
    $contactPrimaryPhone = $contactData['primary_phone'];
    $contactSecondaryPhone = $contactData['secondary_phone'];

    $contactType = $contactData['type'];

    $contactCompanyName = $contactData['company_name'];
    $contactCompanyAddress = $contactData['company_address'];
    $contactCompanyWebsite = $contactData['company_website'];
    $contactCompanyLogo = $contactData['company_logo'];
}

if (isset($_POST['updateContact'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $primary_phone = $_POST['primary_phone'];
    $secondary_phone = $_POST['secondary_phone'];
    $type = $_POST['type'];

    if ($type == "individual") {
        updateContact($conn, $contactId, $name, $email, $address1, $address2, $primary_phone, $secondary_phone, $type);
    } else if ($type == "company") {

        $company_name = $_POST['company_name'];
        $company_address = $_POST['company_address'];
        $company_website = $_POST['company_website'];

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
                echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
            }
        }

        updateContact($conn, $contactId, $name, $email, $address1, $address2, $primary_phone, $secondary_phone, $type, $company_name, $company_address, $company_website, $company_logoContent);
    }
}
