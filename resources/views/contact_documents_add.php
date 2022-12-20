<?php
require_once 'partials/head.php';
require_once 'includes/session.inc.php';
require_once 'partials/navbar.php';
require_once 'partials/aside.php';

$contactId = $_GET['id'];
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="ml-4 text-dark">Add documents</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container">
                    <form action='includes/contact_documents_add.inc.php' method='POST' enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Files</label>
                            <input type="file" class="form-control" name="file_names[]" multiple>
                            <input type="hidden" class="form-control" name="contact_id" value="<?php echo $contactId; ?>">
                        </div>

                        <button class='btn btn-success' type='submit' name='addContactDocuments'>Save</button>
                        <a href="contact_documents.php"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <?php
    require_once 'partials/footer.php'
    ?>