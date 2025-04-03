<?php
include("header.php");
?>
<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1">Customers</h3>
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Sample data - replace with database query
                            for($i=1; $i<=10; $i++) {
                                $orderCount = rand(0, 15);
                                $totalSpent = $orderCount * rand(100, 500);
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td>Customer <?php echo $i; ?></td>
                                <td>customer<?php echo $i; ?>@example.com</td>
                                <td><?php echo date('Y-m-d', strtotime("-".rand(1, 365)." days")); ?></td>
                                <td><?php echo $orderCount; ?></td>
                                <td>$<?php echo number_format($totalSpent, 2); ?></td>
                                <td>
                                    <a href="view_customer.php?id=<?php echo $i; ?>" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="edit_customer.php?id=<?php echo $i; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
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