<?php
ob_start();
include("header.php");
?>

<?php
$db = new Coupons();
$error = '';
$success = '';

// Start session if not already started (since header.php already starts it, this is a safeguard)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Handle coupon deletion
if (!empty($_GET['del'])) {
    $id = base64_decode($_GET['del']);
    $db->deleteCoupon($id);
    $_SESSION['success'] = "Coupon deleted successfully!";
    header("Location: CouponsManagement.php");
    exit();
}

// Handle coupon edit mode
$edit_mode = false;
$coupon = null;
if (!empty($_GET['edit'])) {
    $coupon_id = base64_decode($_GET['edit']);
    $coupon = $db->getCouponById($coupon_id);
    if ($coupon) {
        $edit_mode = true;
    }
}

// Handle form submission for adding/updating a coupon
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add_coupon']) || isset($_POST['update_coupon']))) {
    $coupon_id = isset($_POST['coupon_id']) ? trim($_POST['coupon_id']) : '';
    $coupon_code = trim($_POST['coupon_code']);
    $description = trim($_POST['description']);
    $discount = trim($_POST['coupon_discount_value']);
    $start_date = trim($_POST['start_date']);
    $exp_date = trim($_POST['exp_date']);
    $coupon_status = trim($_POST['coupon_status']);
    $coupon_type = trim($_POST['coupon_type']);
    $min_purchase_amount = trim($_POST['min_purchase_amount']);

    // Basic validation
    if (empty($coupon_code) || empty($coupon_type) || empty($discount) || empty($min_purchase_amount) || empty($start_date) || empty($exp_date) || empty($coupon_status)) {
        $error = "All fields are required.";
    } elseif (!is_numeric($discount) || $discount < 0) {
        $error = "Discount value must be a positive number.";
    } elseif (!is_numeric($min_purchase_amount) || $min_purchase_amount < 0) {
        $error = "Minimum purchase amount must be a positive number.";
    } elseif (!DateTime::createFromFormat('Y-m-d', $start_date)) {
        $error = "Invalid start date format. Use YYYY-MM-DD.";
    } elseif (!DateTime::createFromFormat('Y-m-d', $exp_date)) {
        $error = "Invalid expiration date format. Use YYYY-MM-DD.";
    } elseif (strtotime($start_date) > strtotime($exp_date)) {
        $error = "Start date cannot be later than expiration date.";
    }

    if (empty($error)) {
        if (!empty($coupon_id)) {
            // Update existing coupon with correct parameter order
            $res = $db->updateCoupon(
                $coupon_id,
                $coupon_code,
                $description,
                $coupon_type,
                $discount,
                $min_purchase_amount,
                $start_date,
                $exp_date,
                $coupon_status
            );
            if ($res) {
                $_SESSION['success'] = "Coupon updated successfully!";
                header("Location: CouponsManagement.php");
                exit();
            } else {
                $error = "Failed to update coupon. Please try again.";
            }
        } else {
            // Add new coupon using the correct method
            $res = $db->addCoupon(
                $coupon_code,
                $description,
                $coupon_type,
                $discount,
                $min_purchase_amount,
                $start_date,
                $exp_date,
                $coupon_status
            );
            if ($res) {
                $_SESSION['success'] = "Coupon added successfully!";
                header("Location: CouponsManagement.php");
                exit();
            } else {
                $error = "Failed to add coupon. Please try again.";
            }
        }
    }
}

// Fetch all coupons
$result = $db->getAllCoupons();
?>

<style>
.ck-editor__editable_inline {
    min-height: 300px;
    resize: vertical;
    overflow: auto;
    border: 1px solid #ccc;
}
.message {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
    text-align: center;
}
.success { background-color: #d4edda; color: #155724; }
.error { background-color: #f8d7da; color: #721c24; }
</style>

<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1" style="font-size: 24px; margin-bottom: 20px; color: #333;">Coupon Management</h3>

        <!-- Display success or error message -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="message success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Add/Edit Coupon Form -->
        <div class="xs" style="margin-bottom: 20px;">
            <div class="bs-example4" data-example-id="form-example">
                <h4 style="margin-bottom: 15px; font-size: 18px; color: #333;"><?php echo $edit_mode ? 'Edit Coupon' : 'Add New Coupon'; ?></h4>
                <form id="add-coupon-form" action="" method="post" style="background: #f9f9f9; padding: 15px; border: 1px solid #e0e0e0; border-radius: 6px; width: 100%; box-sizing: border-box; display: flex; flex-wrap: wrap; gap: 10px;">
                    <input type="hidden" name="coupon_id" value="<?php echo $edit_mode ? htmlspecialchars($coupon['coupon_id']) : ''; ?>">

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="coupon_code" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Coupon Code</label>
                        <input type="text" id="coupon_code" name="coupon_code" placeholder="Enter coupon code" value="<?php echo $edit_mode ? htmlspecialchars($coupon['coupon_code']) : ''; ?>" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div id="editor" style="width: 100%; margin-bottom: 15px;">
                        <label for="description" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Coupon Description</label>
                        <textarea id="description" name="description" placeholder="Enter description" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff; resize: vertical; min-height: 100px;"><?php echo $edit_mode ? htmlspecialchars($coupon['coupon_description']) : ''; ?></textarea>
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="coupon_type" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Coupon Type</label>
                        <select id="coupon_type" name="coupon_type" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                            <option value="" disabled <?php echo !$edit_mode ? 'selected' : ''; ?>>Select type</option>
                            <option value="Percentage" <?php echo $edit_mode && $coupon['coupon_type'] == 'Percentage' ? 'selected' : ''; ?>>Percentage</option>
                            <option value="Fixed Ammount" <?php echo $edit_mode && $coupon['coupon_type'] == 'Fixed Ammount' ? 'selected' : ''; ?>>Fixed Amount</option>
                            <option value="Free Shipping" <?php echo $edit_mode && $coupon['coupon_type'] == 'Free Shipping' ? 'selected' : ''; ?>>Free Shipping</option>
                        </select>
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="coupon_discount_value" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Discount Value</label>
                        <input type="text" id="coupon_discount_value" name="coupon_discount_value" placeholder="Enter discount value" value="<?php echo $edit_mode ? htmlspecialchars($coupon['coupon_discount_value']) : ''; ?>" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="min_purchase_amount" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Minimum Purchase Amount</label>
                        <input type="text" id="min_purchase_amount" name="min_purchase_amount" placeholder="Enter min purchase amount" value="<?php echo $edit_mode ? htmlspecialchars($coupon['min_purchase_ammount']) : ''; ?>" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="coupon_status" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Status</label>
                        <select id="coupon_status" name="coupon_status" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                            <option value="" disabled <?php echo !$edit_mode ? 'selected' : ''; ?>>Select status</option>
                            <option value="Active" <?php echo $edit_mode && $coupon['coupon_status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                            <option value="Expired" <?php echo $edit_mode && $coupon['coupon_status'] == 'Expired' ? 'selected' : ''; ?>>Expired</option>
                            <option value="Disabled" <?php echo $edit_mode && $coupon['coupon_status'] == 'Disabled' ? 'selected' : ''; ?>>Disabled</option>
                        </select>
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="start_date" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Start Date</label>
                        <input type="date" id="start_date" name="start_date" value="<?php echo $edit_mode ? htmlspecialchars($coupon['start_date']) : ''; ?>" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="exp_date" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Expiration Date</label>
                        <input type="date" id="exp_date" name="exp_date" value="<?php echo $edit_mode ? htmlspecialchars($coupon['exp_date']) : ''; ?>" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div style="width: 100%; margin-top: 10px;">
                        <button type="submit" name="<?php echo $edit_mode ? 'update_coupon' : 'add_coupon'; ?>" style="width: 100%; padding: 8px; background: #6f42c1; color: #fff; border: none; border-radius: 4px; font-size: 13px; cursor: pointer;">
                            <?php echo $edit_mode ? 'Update Coupon' : 'Add Coupon'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Coupon Table -->
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="table-responsive">
                    <table class="table table-bordered" id="coupon-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Coupon Code</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Discount Value</th>
                                <th>Min Purchase</th>
                                <th>Valid From</th>
                                <th>Valid To</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            while ($row = $result->fetch_assoc()) {
                                $count++;
                                echo "
                                    <tr>
                                        <th scope='row'>$count</th>
                                        <td>" . htmlspecialchars($row['coupon_code']) . "</td>
                                        <td>" . $row['coupon_description'] . "</td>
                                        <td>" . htmlspecialchars($row['coupon_type']) . "</td>
                                        <td>" . number_format($row['coupon_discount_value'], 2) . "</td>
                                        <td>" . number_format($row['min_purchase_ammount'], 2) . "</td>
                                        <td>" . ($row['start_date'] !== '0000-00-00' ? date('Y-m-d', strtotime($row['start_date'])) : 'N/A') . "</td>
                                        <td>" . ($row['exp_date'] !== '0000-00-00' ? date('Y-m-d', strtotime($row['exp_date'])) : 'N/A') . "</td>
                                        <td>" . htmlspecialchars($row['coupon_status']) . "</td>
                                        <td>" . ($row['cdt'] !== '0000-00-00 00:00:00' ? date('Y-m-d H:i:s', strtotime($row['cdt'])) : 'N/A') . "</td>
                                        <td>
                                            <a href='javascript:void(0)' class='btn btn-warning btn-sm' onclick='fedit(\"" . base64_encode($row['coupon_id']) . "\")'>Edit</a>
                                            <a href='javascript:void(0)' class='btn btn-danger btn-sm' onclick='fdel(\"" . base64_encode($row['coupon_id']) . "\")'>Delete</a>
                                        </td>
                                    </tr>
                                ";
                            }
                            if ($count === 0) {
                                echo "<tr><td colspan='11' style='text-align: center;'>No coupons found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include("copyright.php"); ?>
</div>

<?php
include("footer.php");
?>

<script>
    function fdel(id) {
        var r = confirm("Are you sure you want to delete this coupon?");
        if (r == true) {
            window.location.href = "CouponsManagement.php?del=" + id;
        }
    }

    function fedit(id) {
        window.location.href = "CouponsManagement.php?edit=" + id;
    }
</script>