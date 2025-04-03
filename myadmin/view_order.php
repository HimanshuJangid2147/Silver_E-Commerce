<?php
ob_start();
include("header.php");

// Instantiate the OrderManagement class
require_once("class.php"); // Adjust the path to your class file
$orderManagement = new OrderManagement();

// Handle order status update
$success = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_status'])) {
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $newStatus = trim($_POST['order_status']);
    if ($orderManagement->updateOrderStatus($order_id, $newStatus)) {
        $success = "Order status updated successfully!";
    } else {
        $error = "Failed to update order status. Please try again.";
    }
}

// Handle adding order notes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_note'])) {
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $note = trim($_POST['order_note']);
    if ($orderManagement->addOrderNote($order_id, $note)) {
        $success = "Note added successfully!";
    } else {
        $error = "Failed to add note. Please try again.";
    }
}

// Fetch order details
$order_id = !empty($_GET['id']) ? intval(base64_decode($_GET['id'])) : 0;
if (!$order_id) {
    die("Invalid order ID.");
}

$order = $orderManagement->getOrderById($order_id);
if (!$order) {
    die("Order not found.");
}

$orderItems = $orderManagement->getOrderItemsByOrderId($order_id);
$notes = $orderManagement->getOrderNotes($order_id);
?>

<style>
    .message {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
        text-align: center;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 13px;
        background: #fff;
    }
</style>

<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1">Order #<?php echo htmlspecialchars($order['order_number']); ?> Details</h3>

        <!-- Display success or error message -->
        <?php if (!empty($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Order Information Card -->
        <div class="xs" style="margin-bottom: 20px;">
            <div class="bs-example4">
                <div class="order-card">
                    <div class="order-header">
                        <h4>Order Information</h4>
                        <span class="order-number">Order #<?php echo htmlspecialchars($order['order_number']); ?></span>
                    </div>

                    <div class="order-body">
                        <div class="order-details">
                            <div class="detail-group">
                                <div class="detail-col">
                                    <div class="detail-item">
                                        <span class="detail-label">Order Date:</span>
                                        <span class="detail-value"><?php echo date('F j, Y', strtotime($order['created_at'])); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Payment Method:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($order['payment_method']); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Payment Status:</span>
                                        <span class="detail-value status-badge <?php echo strtolower($order['payment_status']); ?>"><?php echo htmlspecialchars($order['payment_status']); ?></span>
                                    </div>
                                </div>
                                <div class="detail-col">
                                    <div class="detail-item">
                                        <span class="detail-label">Customer:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($order['customer_name'] ?: $order['first_name'] . ' ' . $order['last_name']); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Email:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($order['email']); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Phone:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($order['phone']); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="shipping-address">
                                <span class="detail-label">Shipping Address:</span>
                                <div class="address-box">
                                    <?php echo nl2br(htmlspecialchars($order['address'] . "\n" . $order['city'] . ", " . $order['zip'])); ?>
                                </div>
                            </div>
                        </div>

                        <form action="" method="post" class="status-update-form">
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                            <div class="status-control">
                                <span class="detail-label">Order Status:</span>
                                <div class="status-selector">
                                    <select name="order_status" required class="status-dropdown">
                                        <option value="pending" <?php echo $order['order_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="processing" <?php echo $order['order_status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                        <option value="shipped" <?php echo $order['order_status'] == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                        <option value="delivered" <?php echo $order['order_status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                        <option value="cancelled" <?php echo $order['order_status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" class="status-update-btn">Update Status</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="xs tabls">
            <div class="bs-example4">
                <h4 style="margin-bottom: 15px; font-size: 18px; color: #333;">Order Items</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subtotal = 0;
                            if ($orderItems && $orderItems->num_rows > 0) {
                                while ($item = $orderItems->fetch_assoc()) {
                                    $productQuery = "SELECT product_sku FROM product WHERE product_id = " . $item['product_id'];
                                    $productResult = $orderManagement->getConnection()->query($productQuery);
                                    $product = $productResult->fetch_assoc();
                                    $sku = $product ? $product['product_sku'] : 'N/A';
                                    $itemTotal = $item['total'];
                                    $subtotal += $itemTotal;
                                    echo "
                                        <tr>
                                            <td>" . htmlspecialchars($item['product_name']) . "</td>
                                            <td>" . htmlspecialchars($sku) . "</td>
                                            <td>₹" . number_format($item['price'], 2) . "</td>
                                            <td>" . $item['quantity'] . "</td>
                                            <td>₹" . number_format($itemTotal, 2) . "</td>
                                        </tr>
                                    ";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No items found for this order.</td></tr>";
                            }
                            $shipping = floatval($order['shipping']);
                            $grandTotal = $subtotal + $shipping;
                            ?>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Subtotal</strong></td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Shipping</strong></td>
                                <td>₹<?php echo number_format($shipping, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Total</strong></td>
                                <td><strong>₹<?php echo number_format($grandTotal, 2); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Notes Form -->
        <div class="xs" style="margin-bottom: 20px;">
            <div class="bs-example4">
                <h4 style="margin-bottom: 15px; font-size: 18px; color: #333;">Order Notes</h4>
                <form action="" method="post" style="background: #f9f9f9; padding: 15px; border: 1px solid #e0e0e0; border-radius: 6px;">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <div class="form-group">
                        <label>Add Note:</label>
                        <textarea name="order_note" placeholder="Add note about this order" style="min-height: 100px;"></textarea>
                        <button type="submit" style="margin-top: 10px; padding: 8px; background: #6f42c1; color: #fff; border: none; border-radius: 4px;">Add Note</button>
                    </div>
                </form>
                <div class="notes-list" style="margin-top: 15px;">
                    <?php
                    if ($notes && $notes->num_rows > 0) {
                        while ($note = $notes->fetch_assoc()) {
                            echo "
                                <div style='padding: 10px; border: 1px solid #e0e0e0; border-radius: 4px; margin-bottom: 10px;'>
                                    <p><strong>" . date('F j, Y', strtotime($note['created_at'])) . " - Admin:</strong> " . htmlspecialchars($note['note']) . "</p>
                                </div>
                            ";
                        }
                    } else {
                        echo "<p>No notes available.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php include("copyright.php"); ?>
</div>

<style>
    .order-card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .order-header {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .order-header h4 {
        margin: 0;
        color: #495057;
        font-size: 18px;
        font-weight: 600;
    }
    
    .order-number {
        background: #6f42c1;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }
    
    .order-body {
        padding: 20px;
    }
    
    .order-details {
        margin-bottom: 20px;
    }
    
    .detail-group {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    
    .detail-col {
        flex: 1;
        min-width: 250px;
        padding-right: 15px;
    }
    
    .detail-item {
        margin-bottom: 12px;
    }
    
    .detail-label {
        display: block;
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .detail-value {
        font-size: 15px;
        color: #212529;
        font-weight: 500;
    }
    
    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 4px;
        color: white;
        font-size: 13px;
        text-transform: capitalize;
    }
    
    .status-badge.paid {
        background-color: #28a745;
    }
    
    .status-badge.pending {
        background-color: #ffc107;
        color: #212529;
    }
    
    .status-badge.failed {
        background-color: #dc3545;
    }
    
    .shipping-address {
        margin-bottom: 20px;
    }
    
    .address-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 12px;
        font-size: 14px;
        line-height: 1.5;
    }
    
    .status-update-form {
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
    }
    
    .status-control {
        display: flex;
        flex-direction: column;
    }
    
    .status-selector {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .status-dropdown {
        flex: 1;
        max-width: 200px;
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background-color: white;
        font-size: 14px;
    }
    
    .status-update-btn {
        padding: 8px 16px;
        background: #6f42c1;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .status-update-btn:hover {
        background-color: #5a32a3;
    }
    
    @media (max-width: 768px) {
        .detail-group {
            flex-direction: column;
        }
        
        .detail-col {
            padding-right: 0;
            margin-bottom: 15px;
        }
        
        .status-selector {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .status-dropdown {
            max-width: 100%;
            width: 100%;
        }
    }
</style>

<?php
include("footer.php");
?>