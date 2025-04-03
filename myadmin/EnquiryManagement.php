<?php 
    ob_start(); 
    include("header.php"); 
?>

<?php
$db = new Enquiry();

// Handle delete request
if (isset($_GET['delete'])) {
    $id = base64_decode($_GET['delete']);
    if ($db->deleteEnquiry($id)) {
        header("Location: EnquiryManagement.php?success=Enquiry deleted successfully");
        exit();
    } else {
        header("Location: EnquiryManagement.php?error=Failed to delete enquiry");
        exit();
    }
}

// Fetch all enquiries
$enquiries = $db->getAllEnquiries();
?>

<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1">Enquiry Management</h3>

        <!-- Enquiry Table -->
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="table-responsive">
                    <table class="table table-bordered" id="enquiry-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            while ($row = $enquiries->fetch_assoc()) {
                                $count++;
                                echo "
                                    <tr>
                                        <td>{$count}</td>
                                        <td>" . htmlspecialchars($row['name']) . "</td>
                                        <td>" . htmlspecialchars($row['email']) . "</td>
                                        <td>" . htmlspecialchars($row['phone']) . "</td>
                                        <td>" . htmlspecialchars($row['subject']) . "</td>
                                        <td>" . htmlspecialchars(substr($row['message'] ?? '', 0, 50)) . (strlen($row['message'] ?? '') > 50 ? '...' : '') . "</td>
                                        <td>" . htmlspecialchars($row['created_at']) . "</td>
                                        <td>
                                            <a href='javascript:void(0)' class='btn btn-danger btn-sm' onclick='deleteEnquiry(\"" . base64_encode($row['id']) . "\")'>Delete</a>
                                        </td>
                                    </tr>
                                ";
                            }
                            if ($count === 0) {
                                echo "<tr><td colspan='9' style='text-align: center;'>No enquiries found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

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
    .unread {
        background-color: #fff3cd;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function deleteEnquiry(id) {
            var r = confirm("Are you sure you want to delete this enquiry?");
            if (r == true) {
                window.location.href = "EnquiryManagement.php?delete=" + id;
            }
        }
        window.deleteEnquiry = deleteEnquiry;
    });
</script>