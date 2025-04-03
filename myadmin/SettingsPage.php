<?php
include("header.php");
?>

<?php
$updateMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new GeneralSettings();
    $row = $db->getSettings();
    $rowdetails = $row->fetch_assoc();
    $id = $rowdetails['id'];

    $updateSettings = new UpdateSettings();

    $updateSettings->updateSettings('StoreName', $_POST['StoreName'], $id);
    $updateSettings->updateSettings('StoreEmail', $_POST['StoreEmail'], $id);
    $updateSettings->updateSettings('StorePhone', $_POST['store_phone'], $id);
    $updateSettings->updateSettings('StoreAddress', $_POST['store_address'], $id);
    $updateSettings->updateSettings('PaypalEmail', $_POST['paypal_email'], $id);
    $updateSettings->updateSettings('Key1', $_POST['stripe_secret_key'], $id);
    $updateSettings->updateSettings('Key2', $_POST['stripe_publishable_key'], $id);
    $updateSettings->updateSettings('Key3', $_POST['stripe_webhook_signing_secret'], $id);
    $updateSettings->updateSettings('TaxSettings', $_POST['tax_rate'], $id);
    $updateSettings->updateSettings('notifications', $_POST['notifications'], $id);
    $updateSettings->updateSettings('alert', $_POST['alert'], $id);
    $updateSettings->updateSettings('facebook', $_POST['facebook'], $id);
    $updateSettings->updateSettings('twitter', $_POST['twitter'], $id);
    $updateSettings->updateSettings('instagram', $_POST['instagram'], $id);
    $updateSettings->updateSettings('pinterest', $_POST['pinterest'], $id);
    $updateSettings->updateSettings('about_heading', $_POST['about_heading'], $id);
    $updateSettings->updateSettings('about_description', $_POST['about_description'], $id);


    if (!empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        if ($_POST['password'] === $_POST['confirm_password']) {
            $hashed_password = md5(sha1($_POST['password']));
            $updateSettings->updateSettings('password', $hashed_password, 1);
        } else {
            $updateMessage = "Passwords do not match!";
        }
    }

    $websiteStatus = isset($_POST['analytics_enabled']) ? 1 : 0;
    $updateSettings->updateSettings('WebsiteStatus', $websiteStatus, $id);

    if (isset($_FILES['store_logo']) && $_FILES['store_logo']['size'] > 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["store_logo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["store_logo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $updateMessage = "File is not an image.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $updateMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $updateMessage = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["store_logo"]["tmp_name"], $target_file)) {
                $updateSettings->updateSettings('StoreLogo', $target_file, $id);
            } else {
                $updateMessage = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Handel About_Image upload
    if (isset($_FILES['about_image']) && $_FILES['about_image']['size'] > 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["about_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["about_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $updateMessage = "File is not an image.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $updateMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $updateMessage = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["about_image"]["tmp_name"], $target_file)) {
                $updateSettings->updateSettings('about_image', $target_file, $id);
            } else {
                $updateMessage = "Sorry, there was an error uploading your file.";
            }
        }
    }

    if (empty($updateMessage)) {
        $updateMessage = '<div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong> Settings have been updated successfully.
                          </div>';
    } else {
        $updateMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Error!</strong> ' . $updateMessage . '
                          </div>';
    }

    $row = $db->getSettings();
    $rowdetails = $row->fetch_assoc();
} else {
    $db = new GeneralSettings();
    $row = $db->getSettings();
    $rowdetails = $row->fetch_assoc();
}
?>

<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1">Store Settings</h3>
        <?php echo $updateMessage; ?>

        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                    <div class="panel panel-default">
                        <div class="panel-heading">General Settings</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="store-name" class="col-sm-2 control-label">Store Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="store-name" name="StoreName" value="<?php echo $rowdetails['StoreName']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="store-email" class="col-sm-2 control-label">Store Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control1" id="store-email" name="StoreEmail" value="<?php echo $rowdetails['StoreEmail']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="store-phone" class="col-sm-2 control-label">Store Phone</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="store-phone" name="store_phone" value="<?php echo $rowdetails['StorePhone']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="store-address" class="col-sm-2 control-label">Store Address</label>
                                <div class="col-sm-10">
                                    <textarea id="store-address" name="store_address" class="form-control1" rows="3"><?php echo $rowdetails['StoreAddress']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="store-logo" class="col-sm-2 control-label">Store Logo</label>
                                <div class="col-sm-10">
                                    <input type="file" id="store-logo" name="store_logo" class="form-control1">
                                    <p class="help-block">Current logo: <img src="<?php echo $rowdetails['StoreLogo']; ?>" height="30"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Payment Settings</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="paypal-email" class="col-sm-2 control-label">PayPal Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control1" id="paypal-email" name="paypal_email" value="<?php echo $rowdetails['PaypalEmail']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="stripe-secret-key" class="col-sm-2 control-label">Stripe Secret Key</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="stripe-secret-key" name="stripe_secret_key" value="<?php echo $rowdetails['Key1']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="stripe-publishable-key" class="col-sm-2 control-label">Stripe Publishable Key</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="stripe-publishable-key" name="stripe_publishable_key" value="<?php echo $rowdetails['Key2']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="stripe-webhook-signing-secret" class="col-sm-2 control-label">Stripe Webhook Secret</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="stripe-webhook-signing-secret" name="stripe_webhook_signing_secret" value="<?php echo $rowdetails['Key3']; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Website Status</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="analytics-enabled" class="col-sm-2 control-label">Enable Website</label>
                                <div class="col-sm-10">
                                    <div class="switch-container">
                                        <label class="switch">
                                            <input type="checkbox" id="analytics-enabled" name="analytics_enabled" <?php echo $rowdetails['WebsiteStatus'] ? 'checked' : ''; ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <span class="switch-label">Website is <span id="analytics-status"><?php echo $rowdetails['WebsiteStatus'] ? 'ON' : 'OFF'; ?></span></span>
                                    </div>
                                    <style>
                                        .switch-container { display: flex; align-items: center; }
                                        .switch { position: relative; display: inline-block; width: 60px; height: 34px; margin-right: 10px; }
                                        .switch input { opacity: 0; width: 0; height: 0; }
                                        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; }
                                        .slider:before { position: absolute; content: ""; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; transition: .4s; }
                                        input:checked+.slider { background-color: #2196F3; }
                                        input:focus+.slider { box-shadow: 0 0 1px #2196F3; }
                                        input:checked+.slider:before { transform: translateX(26px); }
                                        .slider.round { border-radius: 34px; }
                                        .slider.round:before { border-radius: 50%; }
                                        .switch-label { font-weight: normal; }
                                    </style>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var checkbox = document.getElementById('analytics-enabled');
                                            var status = document.getElementById('analytics-status');
                                            checkbox.addEventListener('change', function() {
                                                status.textContent = this.checked ? 'ON' : 'OFF';
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Tax Settings</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="tax-rate" class="col-sm-2 control-label">Tax Rate (%)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="tax-rate" name="tax_rate" value="<?php echo $rowdetails['TaxSettings']; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Change Password</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">New Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control1" id="password" name="password">
                                    <p class="help-block">Leave blank to keep current password</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="col-sm-2 control-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control1" id="confirm_password" name="confirm_password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Notifications Panel</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="notifications" class="col-sm-2 control-label">Notification Message</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="notifications" name="notifications" value="<?php echo $rowdetails['notifications']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alert" class="col-sm-2 control-label">Alert Message</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="alert" name="alert" value="<?php echo $rowdetails['alert']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="facebook" class="col-sm-2 control-label">Facebook</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="facebook" name="facebook" value="<?php echo $rowdetails['facebook']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="twitter" class="col-sm-2 control-label">Twitter</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="twitter" name="twitter" value="<?php echo $rowdetails['twitter']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="instagram" class="col-sm-2 control-label">Instagram</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="instagram" name="instagram" value="<?php echo $rowdetails['instagram']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pinterest" class="col-sm-2 control-label">Pinterest</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="pinterest" name="pinterest" value="<?php echo $rowdetails['pinterest']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Home Page About Area</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="about_heading" class="col-sm-2 control-label">About Headline</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control1" id="about_heading" name="about_heading" value="<?php echo $rowdetails['about_heading']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="about_description" class="col-sm-2 control-label">About Description</label>
                                <div class="col-sm-10">
                                    <textarea id="about_description" name="about_description" class="form-control1" rows="3"><?php echo $rowdetails['about_description']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="about_image" class="col-sm-2 control-label">About Image</label>
                                <div class="col-sm-10">
                                    <input type="file" id="about_image" name="about_image" class="form-control1">
                                    <p class="help-block">Current Image: <img src="<?php echo $rowdetails['about_image']; ?>" height="30"></p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include("copyright.php"); ?>
</div>

<?php
include("footer.php");
?>