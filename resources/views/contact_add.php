<?php
require_once 'partials/head.php';
require_once 'includes/session.inc.php';
require_once 'partials/navbar.php';
require_once 'partials/aside.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="ml-4 text-dark">Add new contact</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container">
                    <form action='includes/contact_add.inc.php' method='POST' enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Please enter your name" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Please enter your email" required>
                        </div>

                        <div class="form-group">
                            <label>Address 1</label>
                            <input type="text" class="form-control" name="address1" placeholder="Please enter your address1">
                        </div>

                        <div class="form-group">
                            <label>Address 2</label>
                            <input type="text" class="form-control" name="address2" placeholder="Please enter your address2">
                        </div>

                        <div class="form-group">
                            <label>Primary Phone</label>
                            <input type="text" class="form-control" name="primary_phone" placeholder="Please enter your primary phone number">
                        </div>

                        <div class="form-group">
                            <label>Secondary Phone</label>
                            <input type="text" class="form-control" name="secondary_phone" placeholder="Please enter your secondary phone number">
                        </div>

                        <div class="form-group">
                            <label>Type</label>
                            <select id="typeDropdown" class="form-control" name="type" required>
                                <option value="" selected disabled>Please select type</option>
                                <option value="individual">Individual</option>
                                <option value="company">Company</option>
                            </select>
                        </div>

                        <div id="companyDetail" style="display: none;">
                            <div class="form-group">
                                <label>Company Name</label>
                                <input type="text" class="form-control" name="company_name" placeholder="Please enter your company name">
                            </div>

                            <div class="form-group">
                                <label>Comapany Address</label>
                                <input type="text" class="form-control" name="company_address" placeholder="Please enter your company address">
                            </div>

                            <div class="form-group">
                                <label>Comapany Website</label>
                                <input type="text" class="form-control" name="company_website" placeholder="Please enter your company website">
                            </div>

                            <div class="form-group">
                                <label>Comapany Logo</label>
                                <input type="file" class="form-control" name="company_logo" placeholder="Please choose company loge">
                            </div>
                        </div>


                        <button class='btn btn-success' type='submit' name='addContact'>Add Contact</button>
                        <a href="contacts.php"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <?php
    require_once 'partials/footer.php'
    ?>