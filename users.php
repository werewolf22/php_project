<?php
require_once 'includes/db.inc.php';
require_once 'partials/head.php';
require_once 'includes/session.inc.php';
require_once 'partials/navbar.php';
require_once 'partials/aside.php';

$sql = 'SELECT * FROM users ORDER BY usersId desc;';
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Could not get users data: " . mysqli_error($conn));
}

?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="ml-4 text-dark">Users</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="text-center" style="color:green">
                        <?php
                        require_once 'includes/user_delete.inc.php';

                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == "none-created-user") {
                                echo "<p>User added successfully.</p>";
                            } else if ($_GET['error'] == "none-user-updated") {
                                echo "<p>User updated successfully.</p>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="container">
                    <a href="add_users.php">
                        <button class="btn btn-primary">Add</button>
                    </a><br><br>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) {

                                    echo "<tr>";
                                    echo "<td>" . $row['usersId'] . "</td>";
                                    echo "<td>" . $row['usersName'] . "</td>";
                                    echo "<td>" . $row['usersEmail'] . "</td>";
                                    echo "<td><a class=\"btn btn-success btn-sm\" href=\"user_edit.php?id=$row[usersId]\">Edit</a>";

                                    if ($user_session_id != $row['usersId']) {
                                        echo " <a class=\"btn btn-danger btn-sm\" href=\"users.php?id=$row[usersId]\">Delete</a>";
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
                                }
                            } else {
                                // it accept a result object as parameter and frees the memory associated with it.
                                mysqli_free_result($result);
                                echo "<br>Currently thers are no any records!";
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
                </form>
        </div>
        </section>
    </div>
    <?php
    require_once 'partials/footer.php'
    ?>