<?php include_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';

$today = date('Y-m-d');
$sql = 'SELECT count(id) as count FROM issued_books where DATE_ADD(issue_date, INTERVAL 15 DAY) >= ? and extended=0 and return_date IS NULL ';
$values = [];
$values[]=$today;
$currentUser = getCurrentUser();
if(!$currentUser['is_admin']) {
    $sql .= ' and student_id=? ';
    $values[] = $currentUser['id'];
}
$stmt = $db->prepare($sql);
$stmt->execute($values);
$issued = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = 'SELECT count(id) as count FROM issued_books where ((DATE_ADD(issue_date, INTERVAL 15 DAY) < ? and extended=0) or (DATE_ADD(issue_date, INTERVAL 18 DAY) < ? and extended=1)) and return_date IS NULL ';
$values = [];
$values[]=$today;
$values[]=$today;
if(!$currentUser['is_admin']) {
    $sql .= ' and student_id=? ';
    $values[] = $currentUser['id'];
}
$stmt = $db->prepare($sql);
$stmt->execute($values);
$unreturned = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = 'SELECT count(id) as count FROM issued_books where DATE_ADD(issue_date, INTERVAL 18 DAY) >= ? and extended=1 and return_date IS NULL ';
$values = [];
$values[]=$today;
if(!$currentUser['is_admin']) {
    $sql .= ' and student_id=? ';
    $values[] = $currentUser['id'];
}
$stmt = $db->prepare($sql);
$stmt->execute($values);
$hold = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = 'SELECT count(id) as count FROM issued_books where return_date IS NOT NULL ';
$values = [];
if(!$currentUser['is_admin']) {
    $sql .= ' and student_id=? ';
    $values[] = $currentUser['id'];
}
$stmt = $db->prepare($sql);
$stmt->execute($values);
$returned = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <h3>Welcome to Lary Management System,
                <?php echo $_SESSION['userName'] ?>
            </h3>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $hold['count'] ?></h3>

                            <p>Book On Hold</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="bookTransactions.php?type=Hold" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $issued['count'] ?></h3>

                            <p>Book Issued</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="bookTransactions.php?type=Issued" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $returned['count'] ?></h3>

                            <p>Book Returned</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-university"></i>
                        </div>
                        <a href="bookTransactions.php?type=Returned" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $unreturned['count'] ?></h3>

                            <p>Book Unreturned</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-wrench"></i>
                        </div>
                        <a href="bookTransactions.php?type=Unreturned" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

        </div>
    </section>
</div>
<?php
require_once 'partials/backendFooter.php'
?>