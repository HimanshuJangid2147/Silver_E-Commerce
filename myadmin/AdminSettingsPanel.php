<?php
include("header.php");
?>
<div id="page-wrapper">
    <div class="graphs">
        <div class="xs">
            <h3>Jewelry Store Admin Settings</h3>
            <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
                    <!-- Success/Error Messages (Static Examples) -->
                    <div class="alert alert-success" style="display: none;">Settings updated successfully.</div>
                    <div class="alert alert-danger" style="display: none;">Error: Please fill all required fields.</div>

                    <!-- Form -->
                    <form class="form-horizontal">
                        <!-- Store Contact Details -->
                        <div class="form-group">
                            <label for="store-email" class="col-sm-2 control-label">Store Email</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                    <input type="email" class="form-control1" id="store-email" placeholder="e.g., info@jewelryparadise.com" value="info@jewelryparadise.com">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">For customer inquiries</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="store-phone" class="col-sm-2 control-label">Store Phone</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="text" class="form-control1" id="store-phone" placeholder="e.g., +1 (555) 123-4567" value="+1 (555) 123-4567">
                                </div>
                            </div>
                        </div>

                        <!-- Notification Preferences -->
                        <div class="form-group">
                            <label for="notifications" class="col-sm-2 control-label">Order Notifications</label>
                            <div class="col-sm-8">
                                <div class="checkbox-inline"><label><input type="checkbox" checked> Email Alerts</label></div>
                                <div class="checkbox-inline"><label><input type="checkbox"> SMS Alerts</label></div>
                                <p class="help-block">Receive alerts for new orders</p>
                            </div>
                        </div>

                        <!-- Default Shipping Options -->
                        <div class="form-group">
                            <label for="shipping-method" class="col-sm-2 control-label">Default Shipping</label>
                            <div class="col-sm-8">
                                <select name="shipping-method" id="shipping-method" class="form-control1">
                                    <option value="standard" selected>Standard Shipping ($10)</option>
                                    <option value="express">Express Shipping ($25)</option>
                                    <option value="overnight">Overnight Shipping ($50)</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">Applied to new orders</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="free-shipping" class="col-sm-2 control-label">Free Shipping Threshold</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" class="form-control1" id="free-shipping" placeholder="e.g., 100" value="100">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">Minimum order amount</p>
                            </div>
                        </div>

                        <!-- Jewelry Categories -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Featured Categories</label>
                            <div class="col-sm-8">
                                <select multiple class="form-control1">
                                    <option selected>Rings</option>
                                    <option selected>Necklaces</option>
                                    <option>Earrings</option>
                                    <option>Bracelets</option>
                                    <option>Pendants</option>
                                </select>
                                <p class="help-block">Select categories to highlight</p>
                            </div>
                        </div>

                        <!-- Store Description -->
                        <div class="form-group">
                            <label for="store-desc" class="col-sm-2 control-label">Store Description</label>
                            <div class="col-sm-8">
                                <textarea name="store-desc" id="store-desc" cols="50" rows="4" class="form-control1">Welcome to Jewelry Paradise, your one-stop shop for exquisite rings, necklaces, and more.</textarea>
                            </div>
                        </div>

                        <!-- Admin Access Level -->
                        <div class="form-group">
                            <label for="access-level" class="col-sm-2 control-label">Access Level</label>
                            <div class="col-sm-8">
                                <div class="radio-inline"><label><input type="radio" name="access" checked> Full Admin</label></div>
                                <div class="radio-inline"><label><input type="radio" name="access"> Limited Admin</label></div>
                                <p class="help-block">Full: All features; Limited: View only</p>
                            </div>
                        </div>

                        <!-- Currency Preference -->
                        <div class="form-group">
                            <label for="currency" class="col-sm-2 control-label">Currency</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                    <select name="currency" id="currency" class="form-control1">
                                        <option value="USD" selected>USD ($)</option>
                                        <option value="EUR">EUR (€)</option>
                                        <option value="GBP">GBP (£)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Validation Example -->
                        <div class="form-group has-success has-feedback">
                            <label for="tax-rate" class="col-sm-2 control-label">Tax Rate (%)</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" id="tax-rate" value="8" placeholder="Enter tax rate">
                                <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                                <span class="sr-only">(success)</span>
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">Valid rate!</p>
                            </div>
                        </div>

                        <!-- File Upload for Store Logo -->
                        <div class="form-group">
                            <label for="store-logo" class="col-sm-2 control-label">Store Logo</label>
                            <div class="col-sm-8">
                                <input type="file" id="store-logo" name="store_logo" class="form-control1">
                                <p class="help-block">Current logo: <img src="images/logo.png" height="30" alt="Store Logo"></p>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button type="submit" class="btn btn-success">Save Settings</button>
                                    <button type="button" class="btn btn-default">Cancel</button>
                                    <button type="reset" class="btn btn-inverse">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include("copyright.php"); ?>
</div>
<?php
include("footer.php");
?>