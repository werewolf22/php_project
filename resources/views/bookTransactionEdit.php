<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';
require_once '../../src/includes/functions.php';

if($_GET['id']){
    $sql = "SELECT * from issued_books WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="ml-4 text-dark">Edit Book Issue</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <?php include_once 'partials/message.php' ?>
            <form action='../../src/bookTransaction.php' method='POST'>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <div class="form-group">
                    <label>Student</label>
                    <select class="form-control" name="student_id" required>
                        <option value="">Select Student</option>
                        <?php
                        $sql = "select * from users where is_admin=0";
$autstmt = $db->prepare($sql);
$autstmt->execute();
$students = $autstmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($students as $student) {
    echo '<option value="'.$student['id'].'" '.($student['id']==$result['student_id']?'selected':'').'>'.$student['name'].'('.$student['registration_no'].')'.'</option>';
}
?>
                    </select>
                </div>
                <div class="form-group">
                    <label>ISBN No.</label>
                    <select class="form-control" name="book_id" required>
                        <option value="">Select Book</option>
                        <?php
$sql = "select * from books";
$catstmt = $db->prepare($sql);
$catstmt->execute();
$books = $catstmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($books as $book) {
    echo '<option value="'.$book['id'].'"  '.($book['id']==$result['book_id']?'selected':'').'>'.$book['title'].'</option>';
}
?>
                    </select>
                </div>
                
                
                <div class="form-group">
                    <label>Issue Date</label>
                    <input name="issue_date" type="text" class="form-control form-control-navbar datepicker" id="datepicker" data-target="#datepicker" data-toggle="datetimepicker" placeholder="Issue Date" />
                </div>

                <button class='btn btn-success' type='submit' name='update'>Save</button>
                <a href="books.php"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
            </form>
        </div>
    </section>
</div>
<?php
$windowLoadedJs = <<<STR
$('.datepicker').datetimepicker({
    format: 'YYYY-MM-DD', // Correct format for v5
    defaultDate: moment(), // Sets current date as default
    icons: {
        time: 'fa fa-clock',
        date: 'fa fa-calendar',
        up: 'fa fa-arrow-up',
        down: 'fa fa-arrow-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-calendar-check',
        clear: 'fa fa-trash',
        close: 'fa fa-times'
    }
});

STR;

$windowLoadedJs .= <<<STR
    document.querySelector('#datepicker').value = '{$result['issue_date']}';
STR;
require_once 'partials/backendFooter.php'
?>