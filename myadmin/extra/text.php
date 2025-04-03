<?php
include("header.php");
?>

<div id="page-wrapper">
    <div class="graphs">
        <div class="xs">
            <h3>Jewelry Store Admin Settings</h3>
            <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
                    <!-- Success/Error Messages -->
                    <div class="alert alert-success" id="success-msg" style="display: none;">Settings updated successfully.</div>
                    <div class="alert alert-danger" id="error-msg" style="display: none;">Error: Please fill all required fields.</div>

                    <!-- Form -->
                    <form class="form-horizontal" method="POST" action="save_jewelry_settings.php">
                        <!-- Store Contact Details -->
                        <div class="form-group">
                            <label for="store-email" class="col-sm-2 control-label">Store Email *</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                    <input type="email" class="form-control1" id="store-email" name="store_email" placeholder="e.g., support@jewelryparadise.com" value="support@jewelryparadise.com" required>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">Customer support email</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="store-phone" class="col-sm-2 control-label">Store Phone *</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="tel" class="form-control1" id="store-phone" name="store_phone" placeholder="e.g., +1 (555) 123-4567" value="+1 (555) 123-4567" pattern="^\+?[1-9]\d{1,14}$" required>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">Contact for inquiries</p>
                            </div>
                        </div>

                        <!-- Jewelry-Specific Notification Preferences -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Order Notifications</label>
                            <div class="col-sm-8">
                                <div class="checkbox-inline"><label><input type="checkbox" name="email_alerts" checked> Email Alerts</label></div>
                                <div class="checkbox-inline"><label><input type="checkbox" name="sms_alerts"> SMS Alerts</label></div>
                                <p class="help-block">For new jewelry orders & custom requests</p>
                            </div>
                        </div>

                        <!-- Jewelry-Specific Shipping Options -->
                        <div class="form-group">
                            <label for="shipping-method" class="col-sm-2 control-label">Default Shipping</label>
                            <div class="col-sm-8">
                                <select name="shipping_method" id="shipping-method" class="form-control1">
                                    <option value="standard" selected>Standard Shipping ($10)</option>
                                    <option value="express">Express Shipping ($25)</option>
                                    <option value="overnight">Overnight Shipping ($50)</option>
                                    <option value="insured">Insured Premium Shipping ($75)</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">For jewelry deliveries</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="free-shipping" class="col-sm-2 control-label">Free Shipping Threshold</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="number" class="form-control1" id="free-shipping" name="free_shipping" placeholder="e.g., 150" value="150" min="0" step="1">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">Min. order for free shipping</p>
                            </div>
                        </div>

                        <!-- Jewelry Categories -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Featured Categories</label>
                            <div class="col-sm-8">
                                <select multiple class="form-control1" name="featured_categories[]">
                                    <option value="rings" selected>Rings</option>
                                    <option value="necklaces" selected>Necklaces</option>
                                    <option value="earrings">Earrings</option>
                                    <option value="bracelets">Bracelets</option>
                                    <option value="pendants">Pendants</option>
                                    <option value="watches">Watches</option>
                                    <option value="custom">Custom Jewelry</option>
                                </select>
                                <p class="help-block">Highlight on jewelry storefront</p>
                            </div>
                        </div>

                        <!-- Store Description -->
                        <div class="form-group">
                            <label for="store-desc" class="col-sm-2 control-label">Store Description</label>
                            <div class="col-sm-8">
                                <textarea name="store_desc" id="store-desc" cols="50" rows="4" class="form-control1" maxlength="200">Discover Jewelry Paradise, offering timeless rings, necklaces, and custom pieces.</textarea>
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">Shown on homepage</p>
                            </div>
                        </div>

                        <!-- Currency Preference -->
                        <div class="form-group">
                            <label for="currency" class="col-sm-2 control-label">Store Currency</label>
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
                            <div class="col-sm-2">
                                <p class="help-block">For pricing display</p>
                            </div>
                        </div>

                        <!-- Jewelry-Specific Tax Rate -->
                        <div class="form-group">
                            <label for="tax-rate" class="col-sm-2 control-label">Tax Rate (%)</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control1" id="tax-rate" name="tax_rate" value="8" placeholder="Enter tax rate" min="0" max="100" step="0.1" required>
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">For jewelry sales</p>
                            </div>
                        </div>

                        <!-- Store Logo -->
                        <div class="form-group">
                            <label for="store-logo" class="col-sm-2 control-label">Store Logo</label>
                            <div class="col-sm-8">
                                <input type="file" id="store-logo" name="store_logo" class="form-control1" accept="image/*">
                                <p class="help-block">Current logo: <img src="images/jewelry_logo.png" height="30" alt="Jewelry Store Logo"> (Max 2MB)</p>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button type="submit" class="btn btn-success">Save Settings</button>
                                    <button type="button" class="btn btn-default" onclick="window.location.reload();">Cancel</button>
                                    <button type="reset" class="btn btn-inverse">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>