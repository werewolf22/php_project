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
                    <h1 class="ml-4 text-dark">Return Book Issued</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <?php include_once 'partials/message.php' ?>
            <form action='../../src/bookTransaction.php?id=<?php echo $_GET['id'] ?>&type=Returned' method='POST'>
                <div class="form-group">
                    <label>Return Date</label>
                    <input name="return_date" type="text" class="form-control form-control-navbar datepicker" id="datepicker" data-target="#datepicker" data-toggle="datetimepicker" placeholder="Return Date" />
                </div>
                <div class="form-group">
                    <label>Is Damaged</label>
                    <input type="checkbox" name="is_damaged" onClick="changeFineInput(this);" style="width: calc(2.25rem + 2px);" class="form-control">
                </div>
                <div class="form-group">
                    <label>Fine Amount</label>
                    <input name="fine_amount" type="number" id="fine-amount" class="form-control form-control-navbar" min="0" step="0.01" placeholder="Fine Amount" />
                </div>
                
                
                

                <button class='btn btn-success' type='submit'>Save</button>
                <a href="bookTransactions.php?type=Issued"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
            </form>
        </div>
    </section>
</div>
<script>
    function changeFineInput(checkBox) {
        let fineInput = document.querySelector('#fine-amount');
        if(checkBox.checked){
            fineInput.required = true;
        }else fineInput.required = false;
    }
</script>
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