<?php
ob_start();
include("header.php");
?>

<?php
$db = new customerreviews();

// Handle delete review
if (!empty($_GET['del'])) {
    $id = base64_decode($_GET['del']);
    $result = $db->deleteReview($id);
    if ($result) {
        $success = "Review deleted successfully!";
    } else {
        $error = "Failed to delete review.";
    }
}

// Fetch all reviews
$reviews = $db->getAllReviews();
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

    .review-table {
        background: #f9f9f9;
        border: 1px solid #e0e0e0;
    }

    .review-table th {
        background-color: #f1f1f1;
        font-weight: bold;
    }

    .review-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }
</style>

<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1">Customer Reviews Management</h3>

        <!-- Display success or error message -->
        <?php if (!empty($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Reviews Table -->
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="table-responsive">
                    <table class="table table-bordered review-table" id="reviews-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Review</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            while ($row = $reviews->fetch_assoc()) {
                                $count++;
                                echo "
                                    <tr>
                                        <td>{$count}</td>
                                        <td>" . htmlspecialchars($row['customer_name'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['customer_review'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['customer_ratings'] ?? '') . " / 5</td>
                                        <td>" . htmlspecialchars($row['created_at'] ?? '') . "</td> <!-- Changed from cdt to created_at -->
                                        <td class='review-actions'>
                                            <a href='javascript:void(0)' class='btn btn-danger btn-sm' onclick='fdel(\"" . base64_encode($row['id']) . "\")'>Delete</a>
                                        </td>
                                    </tr>
                                ";
                            }
                            if ($count === 0) {
                                echo "<tr><td colspan='6' style='text-align: center;'>No reviews found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function fdel(id) {
            var r = confirm("Are you sure you want to delete this review?");
            if (r == true) {
                window.location.href = "customerreviews.php?del=" + id;
            }
        }

        // Attach global function to window
        window.fdel = fdel;
    });
</script>