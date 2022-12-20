<?php
require_once 'includes/db.inc.php';
require_once 'includes/contact_edit.inc.php';
require_once 'partials/head.php';
require_once 'includes/session.inc.php';
require_once 'partials/navbar.php';
require_once 'partials/aside.php';

$show = "display: show";
$hide = "display: none";

?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="ml-4 text-dark">Edit Contact</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container">
                    <form action='' method='POST' enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $contactName ?>" placeholder="Please enter your name">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $contactEmail ?>" placeholder="Please enter your email">
                        </div>

                        <div class="form-group">
                            <label>Address 1</label>
                            <input type="text" class="form-control" name="address1" value="<?php echo $contactAddress1 ?>" placeholder="Please enter your address1">
                        </div>

                        <div class="form-group">
                            <label>Address 2</label>
                            <input type="text" class="form-control" name="address2" value="<?php echo $contactAddress2 ?>" placeholder="Please enter your address2">
                        </div>

                        <div class="form-group">
                            <label>Primary Phone</label>
                            <input type="text" class="form-control" name="primary_phone" value="<?php echo $contactPrimaryPhone ?>" placeholder="Please enter your primary phone number">
                        </div>

                        <div class="form-group">
                            <label>Secondary Phone</label>
                            <input type="text" class="form-control" name="secondary_phone" value="<?php echo $contactSecondaryPhone ?>" placeholder="Please enter your secondary phone number">
                        </div>

                        <div class="form-group">
                            <label>Type</label>
                            <select id="typeDropdown" class="form-control" name="type">
                                <option value="" selected disabled>Please select type</option>
                                <option value="individual" <?php if ($contactType == 'individual') { ?> selected="selected" <?php } ?>>Individual</option>
                                <option value="company" <?php if ($contactType == 'company') { ?> selected="selected" <?php } ?>>Company</option>
                            </select>
                        </div>


                        <div id="companyDetail" style=" <?php echo $contactType == 'company' ? $show : $hide ?>">
                            <div class="form-group">
                                <label>Company Name</label>
                                <input type="text" class="form-control" name="company_name" value="<?php echo $contactCompanyName; ?>" placeholder="Please enter your company name">
                            </div>

                            <div class="form-group">
                                <label>Company Address</label>
                                <input type="text" class="form-control" name="company_address" value="<?php echo $contactCompanyAddress; ?>" placeholder="Please enter your company address">
                            </div>

                            <div class="form-group">
                                <label>Company Website</label>
                                <input type="text" class="form-control" name="company_website" value="<?php echo $contactCompanyWebsite; ?>" placeholder="Please enter your company website">
                            </div>

                            <div class="form-group">
                                <label>Company Logo</label>
                                <input type="file" class="form-control" name="company_logo" value="" placeholder="Please choose company loge">
                            </div>
                        </div>
                        <button class='btn btn-success' type='submit' name='updateContact'>Update Contact</button>
                        <a href="contacts.php"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <?php
    require_once 'partials/footer.php'
    ?>