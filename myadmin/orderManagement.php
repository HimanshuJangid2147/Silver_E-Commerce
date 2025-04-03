<?php
ob_start();
include("header.php");

// Instantiate the OrderManagement class
require_once("class.php"); // Adjust the path to your class file
$orderManagement = new OrderManagement();

// Fetch all orders
$orders = $orderManagement->getAllOrders();
$error = "";
$success = "";
?>

<style>
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
        <h3 class="blank1">Orders</h3>

        <!-- Display success or error message -->
        <?php if (!empty($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Orders Table -->
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="table-responsive">
                    <table class="table table-bordered" id="orders-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Number</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            if ($orders && $orders->num_rows > 0) {
                                while ($order = $orders->fetch_assoc()) {
                                    $count++;
                                    $rowClass = '';
                                    if ($order['order_status'] == 'cancelled') {
                                        $rowClass = 'danger';
                                    } elseif ($order['order_status'] == 'delivered') {
                                        $rowClass = 'success';
                                    }
                                    echo "
                                        <tr class='" . htmlspecialchars($rowClass) . "'>
                                            <td>{$count}</td>
                                            <td>#" . htmlspecialchars($order['order_number']) . "</td>
                                            <td>" . htmlspecialchars($order['customer_name'] ?: $order['first_name'] . ' ' . $order['last_name']) . "</td>
                                            <td>" . htmlspecialchars(date('Y-m-d', strtotime($order['created_at']))) . "</td>
                                            <td>₹" . number_format($order['total'], 2) . "</td>
                                            <td>" . htmlspecialchars($order['payment_status']) . "</td>
                                            <td>" . htmlspecialchars($order['order_status']) . "</td>
                                            <td>
                                                <a href='view_order.php?id=" . base64_encode($order['id']) . "' class='btn btn-info btn-sm'>View</a>
                                            </td>
                                        </tr>
                                    ";
                                }
                            }
                            if ($count === 0) {
                                echo "<tr><td colspan='8' style='text-align: center;'>No orders found.</td></tr>";
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