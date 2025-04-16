<?php
require_once 'includes/connection.php';
require_once 'includes/session.php';
require_once 'includes/functions.php';
// image uploading in database is bad practise
if (isset($_POST['add'])) {

    $name = trim($_POST['name']);

    $fieldNames = ['name'];
    $errors = validate($fieldNames);
    if (empty($errors)) {
        $sql = 'insert into authors (name) values (?)';
        $stmt = $db->prepare($sql);
        if($stmt->execute([$name ])) {
            $_SESSION['success'] = 'new author created';
            // var_dump($_SESSION['success']);exit;
            header('location: ../resources/views/authors.php');
            exit();
        }
    } else {
        $_SESSION['error'] = $errors;
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }

}


if (isset($_POST['update'])) {
    $id= $_POST['id'];
    $name = $_POST['name'];

    $fieldNames = ['name'];
    $errors = validate($fieldNames);
    if (empty($errors)) {
        $sql = "UPDATE authors SET name=? WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$name, $id]);
        $_SESSION['success'] = "author updated sucessfully";
        header("location: ../resources/views/authors.php");
        exit();
    } else {
        $_SESSION['error'] = $errors;
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // $deleteContactWithItsRelatedFiles = "DELETE t1, t2 FROM contacts t1 INNER JOIN contact_documents t2 ON t1.id = t2.contact_id WHERE t1.id = $id;";

    $sql = "DELETE  FROM authors WHERE id=?;";
    $stmt = $db->prepare( $sql);

    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "aurthor deleted successfully";
        header("location: ../resources/views/authors.php");
        exit;
    } else {

        $errors =  ["Failed, Try again!!"];
        $_SESSION['error'] = $errors;
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
}