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
            <h3>Welcome to Library Management System,
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
            <div class="row">
                <div class="col-md-12">
                    <canvas id="myChart" width="400" height="130"></canvas>
                </div>
            </div>

        </div>
    </section>
</div>
<?php 
$sql = 'SELECT * FROM categories ORDER BY id desc;';

$stmt = $db->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$barData = [];
$barcolors = [
    'rgba(255, 99, 132, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)'
];
$barborders = [
    'rgba(255, 99, 132, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
];
$totalBooks = 0;
foreach ($rows as $row ) {
    $sql = 'SELECT count(id) as count FROM books where category_id=?;';
    $bookcountstmt = $db->prepare($sql);
    $bookcountstmt->execute([$row['id']]);
    $bookcount = $bookcountstmt->fetch(PDO::FETCH_ASSOC);
    $barData['label'][] = $row['name'];
    $barData['count'][] = $bookcount['count'];
    $randkey = array_rand($barcolors);
    $barData['bar_color'][] = $barcolors[$randkey];
    $barData['bar_border'][] = $barborders[$randkey];
    $totalBooks += $bookcount['count'];
}

$barData['label'] = json_encode($barData['label']);
$barData['count'] = json_encode($barData['count']);
$barData['bar_color'] = json_encode($barData['bar_color']);
$barData['bar_border'] = json_encode($barData['bar_border']);


$windowLoadedJs = <<<STR
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {$barData['label']},
        datasets: [{
            label: 'Books per Category ( total $totalBooks books )',
            data: {$barData['count']},
            backgroundColor: {$barData['bar_color']},
            borderColor: {$barData['bar_border']},
            borderWidth: 1,
            barThickness: 90
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
STR;
require_once 'partials/backendFooter.php'
?>