<?php
require_once "../../src/includes/connection.php";
require_once "../../src/includes/functions.php";
$currentUser = getCurrentUser();

if($currentUser['is_admin']) {
    $interval = 15;
    $holdInterval = 18;
}else{
    $interval = 10;
    $holdInterval = 13;
}
$sql = "SELECT ib.id, b.title, u.name FROM issued_books ib left join books b on ib.book_id = b.id left join users u on u.id = ib.student_id where ((DATE_ADD(ib.issue_date, INTERVAL $interval DAY) < ? and ib.extended=0) or (DATE_ADD(ib.issue_date, INTERVAL $holdInterval DAY) < ? and ib.extended=1)) and ib.return_date IS NULL ";
$values = [];
$today=date('Y-m-d');
$values[]=$today;
$values[]=$today;
if(!$currentUser['is_admin']) {
    $sql .= ' and ib.student_id=? ';
    $values[] = $currentUser['id'];
}
$stmt = $db->prepare($sql);
$stmt->execute($values);
$unreturnedBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($unreturnedBooks as $unreturnedBook ) {
    $sql = 'INSERT INTO notifications (issued_book_id, user_id, title, message) SELECT * FROM (SELECT ?, ?, ?, ?) AS tmp WHERE NOT EXISTS ( SELECT 1 FROM notifications WHERE issued_book_id = ? AND user_id = ?) LIMIT 1;';
    $stmt = $db->prepare($sql);
    if($currentUser['is_admin']) {
        $title = "Book Not Returned Alert by {$unreturnedBook['name']}";
        $message = "{$unreturnedBook['name']} has not returned '{$unreturnedBook['title']}' book with issue code {$unreturnedBook['id']}";
    }else{
        $title = "Book Return Reminder for issue code {$unreturnedBook['id']}";
        $message = "Your issued book '{$unreturnedBook['title']}' with issue code {$unreturnedBook['id']} is due soon.";
    }
    $stmt->execute([$unreturnedBook['id'], $currentUser['id'], $title, $message, $unreturnedBook['id'], $currentUser['id']]);
}

$sql = "SELECT * FROM notifications where user_id=? and is_read=0 ORDER BY created_at desc ";
$stmt = $db->prepare($sql);
$stmt->execute([$currentUser['id']]);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?><!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <?php if($notifications){ ?>
                <span
                    class="badge badge-warning navbar-badge"><?= count($notifications) ?></span>
                <?php } ?>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="max-width: 600px;">
                <span
                    class="dropdown-header"><?= count($notifications) ?>
                    Notifications</span>
                <?php

                foreach ($notifications as $index => $notification) {
                    if($index == 5) {
                        break;
                    }
                    ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo $notification['issued_book_id']?'bookTransactions.php?type='.($currentUser['is_admin']?'Unreturned':'Issued'): 'books.php' ?>" class="dropdown-item">
                    <i class="fas <?php echo $notification['issued_book_id']? 'fa-users':'fa-envelope' ?> mr-2"></i> <?= $notification['title'] ?>
                    <span class="float-right text-muted text-sm"><?php echo timeAgo($notification['created_at']) ?></span>
                </a>
                <?php } ?>

                <div class="dropdown-divider"></div>
                <a href="notifications.php" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <?php
                if (!$_SESSION['userId']) {
                    echo "<a href='login.php' class='nav-link'>Login</a>";
                } else {
                    echo "<a href='../../src/signOut.php' class='nav-link'>Logout</a>";
                }
?>
        </li>
    </ul>
</nav>
<!-- /.navbar -->