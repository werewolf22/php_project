<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';
require_once "../../src/includes/connection.php";
require_once "../../src/includes/functions.php";

$currentUser = getCurrentUser();
$sql = 'SELECT * FROM notifications where user_id = ? ORDER BY created_at desc;';
$stmt= $db->prepare($sql);
$stmt->execute([$_SESSION['userId']]);
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="ml-4 text-dark">
                        <?php
                            echo $currentUser['name'].' Notifications';
                        ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">title</th>
                        <th scope="col">Message</th>
                        <th scope="col">Is Read</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
    $i = 1;
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        

        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['message'] . "</td>";
        echo "<td>" . ($row['is_read']? 'Yes':'No') . "</td>";
        echo "<td>" . date('F j, Y', strtotime($row['created_at'])) . "</td>";
        echo "</tr>";
        $i++;
    }
    $sql = "UPDATE notifications SET is_read=1 WHERE user_id=? and is_read=0";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION['userId']]);
} else {

    echo "Currently there are no records!";
}
?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php
require_once 'partials/backendFooter.php'
?>