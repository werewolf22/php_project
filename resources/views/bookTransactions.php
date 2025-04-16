<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';
require_once "../../src/includes/connection.php";
require_once "../../src/includes/functions.php";

$sql = 'SELECT ib.*, b.title as book_title, u.name as student_name, u.registration_no FROM issued_books ib left join books b on ib.book_id = b.id left join users u on u.id= ib.student_id where 1=1 ';
$values = [];
if(isset($_GET['student_id']) && $_GET['student_id']) {
    $sql .= ' and ib.student_id=? ';
    $values[] = trim($_GET['student_id']);
}
if(isset($_GET['book_id']) && $_GET['book_id']) {
    $sql .= ' and ib.book_id=? ';
    $values[] = trim($_GET['book_id']);
}

if(isset($_GET['issue_date']) && $_GET['issue_date']) {
    $sql .= ' and ib.issue_date=? ';
    $values[] = trim($_GET['issue_date']);
}

if(isset($_GET['return_date']) && $_GET['return_date']) {
    $sql .= ' and ib.return_date=? ';
    $values[] = trim($_GET['return_date']);
}
$today = date('Y-m-d');
if(isset($_GET['type']) && $_GET['type']) {
    if($_GET['type'] == 'Issued') {

        $sql .= ' and DATE_ADD(ib.issue_date, INTERVAL 15 DAY) >= ? and ib.extended=0 and return_date IS NULL ';
        $values[] = $today;
    } elseif($_GET['type'] == 'Unreturned') {
        $sql .= ' and ((DATE_ADD(ib.issue_date, INTERVAL 15 DAY) < ? and ib.extended=0) or (DATE_ADD(ib.issue_date, INTERVAL 18 DAY) < ? and ib.extended=1)) and return_date IS NULL ';
        $values[] = $today;
        $values[] = $today;
    } elseif($_GET['type'] == 'Hold') {
        $sql .= ' and DATE_ADD(ib.issue_date, INTERVAL 18 DAY) >= ? and ib.extended=1 and return_date IS NULL ';
        $values[] = $today;
    } elseif($_GET['type'] == 'Returned') {
        $sql .= ' and return_date IS NOT NULL ';
    }
}
$currentUser = getCurrentUser();
if(!$currentUser['is_admin']) {
    $sql .= ' and ib.student_id=? ';
    $values[] = $currentUser['id'];
}

$sql .= ' ORDER BY b.id desc;';

$stmt = $db->prepare($sql);
$stmt->execute($values);


?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="ml-4 text-dark">
                        <?php
                        if(isset($_GET['type']) && $_GET['type']) {
                            if($_GET['type'] == 'Issued') {
                                echo 'Issued Books';
                            } elseif($_GET['type'] == 'Unreturned') {
                                echo 'Unreturned Books';
                            } elseif($_GET['type'] == 'Hold') {
                                echo 'On Hold Books';
                            }elseif($_GET['type'] == 'Returned') {
                                echo 'Returned Books';
                            }
                        } else {
                            echo 'Book Transactions';
                        }

?>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <?php include_once 'partials/message.php' ?>
            <?php if($currentUser['is_admin']) { ?>
            <a href="bookTransactionAdd.php">
                <button class="btn btn-primary">Issue</button>
            </a>
            <?php } ?>
            <form class="form-inline mt-3">
                <input type="hidden" name="type" value="<?php if(isset($_GET['type']) && $_GET['type']) echo $_GET['type']; ?>">
                <div class="input-group input-group-sm">
                    <?php
                    if($currentUser['is_admin']) {
                        ?>
                    <select class="form-control form-control-navbar mx-1" name="student_id">
                        <option value="">Select Student</option>
                        <?php
                        $sql = "select * from users where is_admin=0";
                        $autstmt = $db->prepare($sql);
                        $autstmt->execute();
                        $students = $autstmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($students as $student) {
                            echo '<option value="'.$student['id'].'" '.((isset( $_GET['student_id']) && $student['id'] == $_GET['student_id']) ? 'selected' : '').'>'.$student['name'].'('.$student['registration_no'].')'.'</option>';
                        }
                        ?>
                    </select>
                    <?php } ?>
                    <select class="form-control form-control-navbar mx-1" name="book_id">
                        <option value="">Select Book</option>
                        <?php
                        $sql = "select * from books";
$catstmt = $db->prepare($sql);
$catstmt->execute();
$books = $catstmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($books as $book) {
    echo '<option value="'.$book['id'].'" '.((isset($_GET['book_id']) && $book['id'] == $_GET['book_id']) ? 'selected' : '').'>'.$book['title'].'</option>';
}
?>
                    </select>
                        <input name="issue_date" type="text" class="form-control form-control-navbar datepicker mx-1" id="datepicker" data-target="#datepicker" data-toggle="datetimepicker" placeholder="Issue Date" />
                        
                        <input name="return_date" type="text" class="form-control form-control-navbar datepicker mx-1" id="return-datepicker" data-target="#return-datepicker" data-toggle="datetimepicker"  placeholder="Returned Date"
                            vlaue="<?php if(isset($_GET['return_date']) && $_GET['return_date']) {
                                echo trim($_GET['return_date']);
                            } ?>" />
                        
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form><br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Book</th>
                        <th scope="col">Student</th>
                        <th scope="col">Issue Date</th>
                        <th scope="col">Expected Return Date</th>
                        <th scope="col">Returned Date</th>

                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
    $i = 1;
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['book_title'] . "</td>";
        echo "<td>" . $row['student_name']."({$row['registration_no']})" . "</td>";
        echo "<td>" . date('F j, Y', strtotime($row['issue_date'])) . "</td>";
        echo "<td>" . date('F j, Y', strtotime($row['issue_date'].($row['extended']?'+18 days':'+15 days'))) . "</td>";
        echo "<td>" . ($row['return_date']?date('F j, Y', strtotime($row['return_date'])):'NA') . "</td>";
        echo '<td>';
        if($currentUser['is_admin']) {
            if(isset($_GET['type']) && $_GET['type']) {
                if($_GET['type'] != 'Returned') {
                    echo " <a class=\"btn btn-primary btn-sm\" href=\"../../src/bookTransaction.php?id={$row['id']}&type=Returned\"  onClick=\"if(!confirm('Are you sure'))return false;\">Returned</a>";
                    echo " <a class=\"btn btn-success btn-sm\" href=\"bookTransactionEdit.php?id={$row['id']}\">Edit</a>";
                    echo " <a class=\"btn btn-danger btn-sm\" href=\"../../src/bookTransaction.php?id={$row['id']}&type=Delete\" onClick=\"if(!confirm('Are you sure'))return false;\">Delete</a>";
                }
            }
        } else {
            if(isset($_GET['type']) && $_GET['type']) {
                if($_GET['type'] != 'Returned') {
                    if($_GET['type'] == 'Issued' && date('Y-m-d', strtotime($row['issue_date'] . ' +15 days')) == date('Y-m-d')) {
                        echo "<a class=\"btn btn-primary btn-sm\" href=\"../../src/bookTransaction.php?id={$row['id']}&type=Hold\"  onClick=\"if(!confirm('Are you sure'))return false;\">Hold</a>";
                    }
                }
            }
        }
        echo "</td></tr>";

        // echo "<tr>
        //         <td> " . $row["usersId"]. " </td>
        //         <td> " . $row["usersName"]. "</td>
        //         <td>" . $row["usersEmail"]. "</td>
        //         <td>
        //             <div class='btn-group' role='group'>
        //                 <a href='user_edit.php?id=". $row['usersId'] ."'> <button class='btn btn-success btn-sm'>Edit</button> </a>
        //                 <a href='users.php?id=". $row['usersId'] ."'> <button class='btn btn-danger btn-sm'>Delete</button> </a>
        //             </div>
        //         </td>
        //     </tr>";
        $i++;
    }
} else {

    echo "Currently there are no records!";
}
?>
                </tbody>
            </table>
        </div>
    </section>
    <?php
    $windowLoadedJs = <<<STR
            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD', // Correct format for v5
                // defaultDate: moment(), // Sets current date as default
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

if(isset($_GET['issue_date']) && $_GET['issue_date']){
    $windowLoadedJs .= <<<STR
    document.querySelector('#datepicker').value = '{$_GET['issue_date']}';
STR;
}

if(isset($_GET['return_date']) && $_GET['return_date']){
    $windowLoadedJs .= <<<STR
    document.querySelector('#return-datepicker').value = '{$_GET['return_date']}';
STR;
}
?>
</div>
<?php
require_once 'partials/backendFooter.php'
?>