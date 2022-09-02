<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_sql = "DELETE FROM users WHERE usersId = '$id'";
    $run_delete = mysqli_query($conn, $delete_sql);

    if ($run_delete) {
        echo "<p class='text-center' style='color: green;'>User deleted successfully.</p>";
    } else {
        echo "<p>Failed, Try again!!</p>";
    }
}
