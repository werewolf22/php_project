<?php require_once "../../src/includes/session.php" ?>
<?php redirectGuestUser(); ?>
<?php
require_once '../../src/includes/connection.php';
require_once 'partials/backendHead.php';
require_once 'partials/backendNavbar.php';
require_once 'partials/backendAside.php';

$show = "display: show";
$hide = "display: none";


if (isset($_GET['id'])) {
    $contactId = $_GET['id'];

    $selectSql = "SELECT * FROM contacts WHERE id = ?";
    $stmt = $db->prepare( $selectSql);
    $stmt->execute([$contactId]);

    $contactData = $stmt->fetch(PDO::FETCH_ASSOC);

    $contactName = $contactData['name'];
    $contactEmail = $contactData['email'];
    $contactAddress1 = $contactData['address1'];
    $contactAddress2 = $contactData['address2'];
    $contactPrimaryPhone = $contactData['primary_phone'];
    $contactSecondaryPhone = $contactData['secondary_phone'];

    $contactType = $contactData['type'];

    $contactCompanyWebsite = $contactData['website'];
    $contactCompanyLogo = $contactData['company_logo'];
}

?>


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
            <form action='../src/contact.php' method='POST' enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <div class="form-group">
                    <label>Type</label>
                    <select id="typeDropdown" class="form-control" name="type">
                        <option value="" selected disabled>Please select type</option>
                        <option value="Individual" <?php if ($contactType == 'Individual') { ?> selected="selected" <?php } ?>>Individual</option>
                        <option value="Company" <?php if ($contactType == 'Company') { ?> selected="selected" <?php } ?>>Company</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><span id="company-name-label" style="<?php echo $contactType == 'company' ? $show : $hide ?>">Company </span> Name</label>
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
                    <label>Website</label>
                    <input type="text" class="form-control" name="website" value="<?php echo $contactCompanyWebsite; ?>" placeholder="Please enter your website">
                </div>

                <div id="companyDetail" style=" <?php echo $contactType == 'company' ? $show : $hide ?>">
                    <div class="form-group">
                        <label>Company Logo</label>
                        <input type="file" class="form-control" name="company_logo" value="" placeholder="Please choose company logo">
                    </div>
                </div>
                <button class='btn btn-success' type='submit' name='updateContact'>Update Contact</button>
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
<?php require_once 'partials/backendFooter.php' ?>