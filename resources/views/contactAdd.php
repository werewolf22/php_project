<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';
?>


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
            <form action='../src/contact.php' method='POST' enctype="multipart/form-data">
                <div class="form-group">
                    <label>Type</label>
                    <select id="typeDropdown" class="form-control" name="type" required>
                        <option value="" disabled>Please select type</option>
                        <option value="Individual" selected>Individual</option>
                        <option value="Company">Company</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><span id ="company-name-label" style="display: none;">Company</span> Name</label>
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
                    <label>Website</label>
                    <input type="text" class="form-control" name="website" placeholder="Please enter your website">
                </div>

                <div id="companyDetail" style="display: none;">

                    <div class="form-group">
                        <label>Comapany Logo</label>
                        <input type="file" class="form-control" name="company_logo" placeholder="Please choose company logo">
                    </div>
                </div>


                <button class='btn btn-success' type='submit' name='addContact'>Add Contact</button>
                <a href="contacts.php"><button style="float: right;" class='btn btn-primary' type='button'>Back</button></a>
            </form>
        </div>
    </section>
</div>
<?php
$jsToBeLoaded = <<<STR
$('#typeDropdown').change(function() {
    if ($('#typeDropdown').val() == 'Company') {
        $('#companyDetail').show();
        $('#company-name-label').show();
    } else if ($('#typeDropdown').val() == 'Individual') {
        $('#companyDetail').hide();
        $('#company-name-label').hide();
    }
});
STR;
if (isset($windowLoadedJs)) {
    $windowLoadedJs .= $jsToBeLoaded;
}else{
    $windowLoadedJs = $jsToBeLoaded;
}
?>
<?php
require_once 'partials/backendFooter.php';
?>