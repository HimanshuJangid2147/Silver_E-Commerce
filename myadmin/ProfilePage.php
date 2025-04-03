<?php
include("header.php");
?>

<div id="page-wrapper">
    <div class="graphs">
        <h3>Admin Profile</h3>
        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <!-- Success/Error Messages (Static Examples) -->
                <div class="alert alert-success" style="display: none;">Profile updated successfully.</div>
                <div class="alert alert-danger" style="display: none;">Error: Invalid email format.</div>

                <!-- Profile Form -->
                <form class="form-horizontal" enctype="multipart/form-data">
                    <!-- Left Column: Personal Details -->
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Personal Details</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Full Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control1" id="name" name="name" value="Admin Name" placeholder="Enter your full name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control1" id="email" name="email" value="admin@example.com" placeholder="Enter your email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="col-sm-3 control-label">Phone</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control1" id="phone" name="phone" value="+1 (555) 123-4567" placeholder="Enter your phone number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="profile-pic" class="col-sm-3 control-label">Profile Picture</label>
                                    <div class="col-sm-9">
                                        <img src="images/1.png" alt="Profile Picture" height="50" class="img-rounded" style="margin-bottom: 10px;">
                                        <input type="file" id="profile-pic" name="profile_pic" class="form-control1">
                                        <p class="help-block">Upload a new profile picture (max 2MB).</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Security & Additional Info -->
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Security</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="current-password" class="col-sm-3 control-label">Current Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control1" id="current-password" name="current_password" placeholder="Enter current password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="new-password" class="col-sm-3 control-label">New Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control1" id="new-password" name="new_password" placeholder="Enter new password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm-password" class="col-sm-3 control-label">Confirm Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control1" id="confirm-password" name="confirm_password" placeholder="Confirm new password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">Additional Information</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Last Login</label>
                                    <div class="col-sm-9">
                                        <p class="form-control-static">March 07, 2025 10:30 AM</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bio" class="col-sm-3 control-label">Bio</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control1" id="bio" name="bio" rows="3">I manage the Jewelry Store Admin Panel.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>