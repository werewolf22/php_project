<?php
require_once 'includes/connection.php';
require_once 'includes/session.php';
require_once 'includes/functions.php';
// image uploading in database is bad practise
if (isset($_POST['add'])) {

    $title = trim($_POST['title']);
    $ISBN_No = trim($_POST['isbn_no']);
    $authorId = trim($_POST['author_id']);
    $categoryId = trim($_POST['category_id']);
    $totalCopies = trim($_POST['total_copies']);

    $fieldNames = ['title', 'ISBN_No', 'authorId', 'categoryId', 'totalCopies'];
    $errors = validate($fieldNames);
    if (empty($errors)) {
        $sql = 'insert into books (title, isbn_no, author_id, category_id,  available_copies, total_copies) values (?, ?, ?, ?, ?, ?)';
        $stmt = $db->prepare($sql);
        if($stmt->execute([$title, $ISBN_No, $authorId, $categoryId, $totalCopies, $totalCopies])) {
            $sql = 'SELECT * FROM users where is_admin != 1 ';
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($users as $user ) {
                $sql = 'insert into notifications (user_id, title, message) values (?, ?, ?)';
                $stmt = $db->prepare($sql);
                $stmt->execute([$user['id'], "New Book In Library Alert named '$title'", "$totalCopies copies of new '$title' book is available in library"]);
            }

            $_SESSION['success'] = 'new book created';
            // var_dump($_SESSION['success']);exit;
            header('location: ../resources/views/books.php');
            exit();
        }
    } else {
        $_SESSION['error'] = $errors;
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }

}


if (isset($_POST['update'])) {
    $id= trim($_POST['id']);
    $title = trim($_POST['title']);
    $ISBN_No = trim($_POST['isbn_no']);
    $authorId = trim($_POST['author_id']);
    $categoryId = trim($_POST['category_id']);
    $totalCopies = trim($_POST['total_copies']);

    $fieldNames = ['title', 'ISBN_No', 'authorId', 'categoryId', 'totalCopies'];
    $errors = validate($fieldNames);
    if (empty($errors)) {
        $sql = 'SELECT available_copies, total_copies FROM books where id=?;';
        $bookstmt = $db->prepare($sql);
        $bookstmt->execute([$id]);
        $book = $bookstmt->fetch(PDO::FETCH_ASSOC);
        if($book['total_copies']<= $totalCopies) $avialableCopies = $book['available_copies'] + $totalCopies - $book['total_copies'];
        elseif(($book['total_copies']-$book['available_copies']) < $totalCopies) $avialableCopies = $totalCopies - $book['total_copies']+$book['available_copies'];
        else $avialableCopies = 0;
        $sql = "UPDATE books SET title=?, isbn_no=?, author_id=?, category_id=?, available_copies=?, total_copies=? WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$title, $ISBN_No, $authorId, $categoryId, $avialableCopies, $totalCopies, $id]);
        $_SESSION['success'] = "book updated sucessfully";
        header("location: ../resources/views/books.php");
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

    $sql = "DELETE  FROM books WHERE id=?;";
    $stmt = $db->prepare( $sql);

    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "book deleted successfully";
        header("location: ../resources/views/books.php");
        exit;
    } else {

        $errors =  ["Failed, Try again!!"];
        $_SESSION['error'] = $errors;
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
}