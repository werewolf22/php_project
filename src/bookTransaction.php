<?php
require_once 'includes/connection.php';
require_once 'includes/session.php';
require_once 'includes/functions.php';
// image uploading in database is bad practise
if (isset($_POST['add'])) {

    $studentId = trim($_POST['student_id']);
    $bookId = trim($_POST['book_id']);
    $issueDate = trim($_POST['issue_date']);
    
    $fieldNames = ['studentId', 'bookId', 'issueDate'];
    $errors = validate($fieldNames);
    if (empty($errors)) {
        $sql = 'select * from books where id=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$bookId]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        if($book['available_copies'] <= 0) $errors[] = 'There is no copies '.$book['title'].' book available';
        if (empty($errors)) {
            $avialableCopies = $book['available_copies']-1;
            $sql = "UPDATE books SET available_copies=? WHERE id=?";
            $stmt = $db->prepare($sql);
            if($stmt->execute([$avialableCopies, $bookId])) {
                $sql = 'insert into issued_books (book_id, student_id, issue_date) values (?, ?, ?)';
                $stmt = $db->prepare($sql);
                if($stmt->execute([$bookId, $studentId, $issueDate])) {
                    $_SESSION['success'] = 'book issued';
                    // var_dump($_SESSION['success']);exit;
                    header('location: ../resources/views/bookTransactions.php?type=Issued');
                    exit();
                }
            }
        } else {
            $_SESSION['error'] = $errors;
            header('location: '. $_SERVER['HTTP_REFERER']);
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
    $studentId = trim($_POST['student_id']);
    $bookId = trim($_POST['book_id']);
    $issueDate = trim($_POST['issue_date']);
    
    $fieldNames = ['studentId', 'bookId', 'issueDate'];
    $errors = validate($fieldNames);
    if (empty($errors)) {
        $sql = 'select * from books where id=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$bookId]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if($book['available_copies'] <= 0) $errors[] = 'There is no copies '.$book['title'].' book available';
        if (empty($errors)) {
            $sql = 'select * from issued_books where id=?';
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $issuedbook = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql = 'select * from books where id=?';
            $stmt = $db->prepare($sql);
            $stmt->execute([$issuedbook['book_id']]);
            $prevBook = $stmt->fetch(PDO::FETCH_ASSOC);

            $prevAvialableCopies = $prevBook['available_copies']+1;

            $sql = "UPDATE books SET available_copies=? WHERE id=?";
            $stmt = $db->prepare($sql);
            if($stmt->execute([$prevAvialableCopies, $issuedbook['book_id']])) {
                $sql = 'select * from books where id=?';
                $stmt = $db->prepare($sql);
                $stmt->execute([$bookId]);
                $book = $stmt->fetch(PDO::FETCH_ASSOC);

                $avialableCopies = $book['available_copies']-1;
                $sql = "UPDATE books SET available_copies=? WHERE id=?";
                $stmt = $db->prepare($sql);
                if($stmt->execute([$avialableCopies, $bookId])) {
                    $sql = 'update issued_books set book_id=?, student_id=?, issue_date=? where  id=?';
                    $stmt = $db->prepare($sql);
                    if($stmt->execute([$bookId, $studentId, $issueDate, $id])) {
                        $_SESSION['success'] = 'book issue updated';
                        // var_dump($_SESSION['success']);exit;
                        header('location: ../resources/views/bookTransactions.php?type=Issued');
                        exit();
                    }
                }
            }
        } else {
            $_SESSION['error'] = $errors;
            header('location: '. $_SERVER['HTTP_REFERER']);
            exit();
        }
    } else {
        $_SESSION['error'] = $errors;
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
}


if (isset($_GET['type']) && $_GET['type']=='Delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    // $deleteContactWithItsRelatedFiles = "DELETE t1, t2 FROM contacts t1 INNER JOIN contact_documents t2 ON t1.id = t2.contact_id WHERE t1.id = $id;";
    $sql = 'select * from issued_books where id=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $issuedbook = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = 'select * from books where id=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$issuedbook['book_id']]);
    $prevBook = $stmt->fetch(PDO::FETCH_ASSOC);

    $prevAvialableCopies = $prevBook['available_copies']+1;

    $sql = "UPDATE books SET available_copies=? WHERE id=?";
    $stmt = $db->prepare($sql);
    if($stmt->execute([$prevAvialableCopies, $issuedbook['book_id']])) {
        $sql = "DELETE  FROM books WHERE id=?;";
        $stmt = $db->prepare( $sql);

        if ($stmt->execute([$id])) {
            $_SESSION['success'] = "book issue deleted successfully";
            header("location: ". $_SERVER['HTTP_REFERER']);
            exit;
        } else {

            $errors =  ["Failed, Try again!!"];
            $_SESSION['error'] = $errors;
            header('location: '. $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}

if (isset($_GET['type']) && $_GET['type']=='Returned' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if(isset($_POST['is_damaged'])) $isDamaged = 1;
    else $isDamaged = 0;
    $fineAmount = trim($_POST['fine_amount']);
    $returnDate = trim($_POST['return_date']);
    // $deleteContactWithItsRelatedFiles = "DELETE t1, t2 FROM contacts t1 INNER JOIN contact_documents t2 ON t1.id = t2.contact_id WHERE t1.id = $id;";
    $fieldNames = ['returnDate'];
    $errors = validate($fieldNames);
    if (empty($errors)) {
        $sql = 'select * from issued_books where id=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $issuedbook = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = 'select * from books where id=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$issuedbook['book_id']]);
        $prevBook = $stmt->fetch(PDO::FETCH_ASSOC);

        $prevAvialableCopies = $prevBook['available_copies']+1;

        $sql = "UPDATE books SET available_copies=? WHERE id=?";
        $stmt = $db->prepare($sql);
        if($stmt->execute([$prevAvialableCopies, $issuedbook['book_id']])) {
            $sql = "UPDATE issued_books SET return_date=?, is_damaged=?, fine_amount=? WHERE id=?";
            $stmt = $db->prepare( $sql);

            if ($stmt->execute([$returnDate, $isDamaged, $fineAmount, $id])) {
                $_SESSION['success'] = "book returned successfully";
                header('location: ../resources/views/bookTransactions.php?type=Returned');
                exit();
            } else {

                $errors =  ["Failed, Try again!!"];
                $_SESSION['error'] = $errors;
                header('location: '. $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }else{
        $_SESSION['error'] = $errors;
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
}

if (isset($_GET['type']) && $_GET['type']=='Hold' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE issued_books SET extended=1 WHERE id=?";
    $stmt = $db->prepare( $sql);

    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "book held successfully";
        header("location: ". $_SERVER['HTTP_REFERER']);
        exit;
    } else {

        $errors =  ["Failed, Try again!!"];
        $_SESSION['error'] = $errors;
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
}