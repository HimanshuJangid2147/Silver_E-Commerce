<?php
ob_start();
include("header.php");
?>

<?php
$db = new TermsConditions();
$error = '';
$success = '';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Handle deletion
if (!empty($_GET['del'])) {
    $id = base64_decode($_GET['del']);
    $db->deleteTerms($id);
    $_SESSION['success'] = "Terms and Conditions entry deleted successfully!";
    header("Location: TermsConditionsManagement.php");
    exit();
}

// Handle edit mode
$edit_mode = false;
$terms = null;
if (!empty($_GET['edit'])) {
    $terms_id = base64_decode($_GET['edit']);
    $terms = $db->getTermsById($terms_id);
    if ($terms) {
        $edit_mode = true;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add_terms']) || isset($_POST['update_terms']))) {
    $terms_id = isset($_POST['terms_id']) ? trim($_POST['terms_id']) : '';
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Basic validation
    if (empty($title) || empty($content)) {
        $error = "All fields are required.";
    }

    if (empty($error)) {
        if (!empty($terms_id)) {
            $res = $db->updateTerms($terms_id, $title, $content);
            if ($res) {
                $_SESSION['success'] = "Terms and Conditions updated successfully!";
                header("Location: TermsConditionsManagement.php");
                exit();
            } else {
                $error = "Failed to update Terms and Conditions. Please try again.";
            }
        } else {
            $res = $db->addTerms($title, $content);
            if ($res) {
                $_SESSION['success'] = "Terms and Conditions added successfully!";
                header("Location: TermsConditionsManagement.php");
                exit();
            } else {
                $error = "Failed to add Terms and Conditions. Please try again.";
            }
        }
    }
}

// Fetch all Terms and Conditions
$result = $db->getAllTerms();
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
        <h3 class="blank1" style="font-size: 24px; margin-bottom: 20px; color: #333;">Terms and Conditions Management</h3>

        <!-- Display success or error message -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="message success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Add/Edit Form -->
        <div class="xs" style="margin-bottom: 20px;">
            <div class="bs-example4" data-example-id="form-example">
                <h4 style="margin-bottom: 15px; font-size: 18px; color: #333;"><?php echo $edit_mode ? 'Edit Terms and Conditions' : 'Add New Terms and Conditions'; ?></h4>
                <form id="add-terms-form" action="" method="post" style="background: #f9f9f9; padding: 15px; border: 1px solid #e0e0e0; border-radius: 6px; width: 100%; box-sizing: border-box; display: flex; flex-wrap: wrap; gap: 10px;">
                    <input type="hidden" name="terms_id" value="<?php echo $edit_mode ? htmlspecialchars($terms['terms_id']) : ''; ?>">

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="title" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Title</label>
                        <input type="text" id="title" name="title" placeholder="Enter title" value="<?php echo $edit_mode ? htmlspecialchars($terms['title']) : ''; ?>" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div id="editor" style="width: 100%; margin-bottom: 15px;">
                        <label for="content" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Content</label>
                        <textarea id="content" name="content" placeholder="Enter content" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff; resize: vertical; min-height: 100px;"><?php echo $edit_mode ? htmlspecialchars($terms['content']) : ''; ?></textarea>
                    </div>

                    <div style="width: 100%; margin-top: 10px;">
                        <button type="submit" name="<?php echo $edit_mode ? 'update_terms' : 'add_terms'; ?>" style="width: 100%; padding: 8px; background: #6f42c1; color: #fff; border: none; border-radius: 4px; font-size: 13px; cursor: pointer;">
                            <?php echo $edit_mode ? 'Update Terms and Conditions' : 'Add Terms and Conditions'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="table-responsive">
                    <table class="table table-bordered" id="terms-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Content</th>
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
                                        <td>" . htmlspecialchars($row['title']) . "</td>
                                        <td>" . substr($row['content'], 0, 50) . (strlen($row['content']) > 50 ? '...' : '') . "</td>
                                        <td>" . ($row['cdt'] !== '0000-00-00 00:00:00' ? date('Y-m-d H:i:s', strtotime($row['cdt'])) : 'N/A') . "</td>
                                        <td>
                                            <a href='javascript:void(0)' class='btn btn-warning btn-sm' onclick='fedit(\"" . base64_encode($row['terms_id']) . "\")'>Edit</a>
                                            <a href='javascript:void(0)' class='btn btn-danger btn-sm' onclick='fdel(\"" . base64_encode($row['terms_id']) . "\")'>Delete</a>
                                        </td>
                                    </tr>
                                ";
                            }
                            if ($count === 0) {
                                echo "<tr><td colspan='5' style='text-align: center;'>No Terms and Conditions found.</td></tr>";
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
    function fdel(id) {
        var r = confirm("Are you sure you want to delete this Terms and Conditions entry?");
        if (r == true) {
            window.location.href = "TermsConditionsManagement.php?del=" + id;
        }
    }

    function fedit(id) {
        window.location.href = "TermsConditionsManagement.php?edit=" + id;
    }
</script>