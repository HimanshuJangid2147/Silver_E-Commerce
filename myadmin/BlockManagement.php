<?php
ob_start();
include("header.php");
?>

<?php
$db = new BlockManagement();

// Fetch all existing blocks to check count
$existing_blocks = $db->getAllBlocks();
$block_count = $existing_blocks->num_rows;

// Handle form submission for adding a block
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['block_heading'])) {
    // Check if maximum block limit is reached
    if ($block_count >= 3) {
        $error = "Maximum limit of 3 blocks has been reached. Cannot add more blocks.";
    } else {
        // Initialize variables
        $block_heading = trim($_POST['block_heading']);
        $block_id = trim($_POST['block_id']);
        $image_name = "";
        $error = "";
        $success = "";

        // Handle image upload
        $image_name = null; // Default to null
        if (isset($_FILES['block_image']) && $_FILES['block_image']['error'] == 0) {
            $target_dir = "uploads/"; // Directory to store images
            $image_file = basename($_FILES['block_image']['name']);
            $target_file = $target_dir . uniqid() . "_" . $image_file; // Unique filename
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a valid type
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($imageFileType, $allowed_types)) {
                // Upload file
                if (move_uploaded_file($_FILES['block_image']['tmp_name'], $target_file)) {
                    $image_name = $target_file;
                } else {
                    $error = "Error: Failed to upload image.";
                }
            } else {
                $error = "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
            }
        }

        // Proceed with database insertion
        if (empty($error)) {
            $cdt = date('Y-m-d H:i:s'); // Current timestamp
            
            if ($block_id != "") {
                // Update existing block
                $result = $db->updateBlock($block_id, $block_heading, $image_name);
                if ($result) {
                    $success = "Block updated successfully!";
                } else {
                    $error = "Failed to update block. Please try again.";
                }
            } else {
                // Add new block
                $result = $db->addBlock($block_heading, $image_name, $cdt);
                if ($result) {
                    $success = "Block added successfully!";
                    header("Location: BlockManagement.php");
                    exit();
                } else {
                    $error = "Failed to add block. Please try again.";
                }
            }
        }
    }
}

// Button Change to Edit
if (!empty($_GET['edit'])) {
    $edit_mode = true;
} else {
    $edit_mode = false;
}

// Fetch all blocks after processing the form
$blocks = $db->getAllBlocks();
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

    #add-block-section {
        transition: all 0.3s ease;
    }

    .limit-reached-message {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
        text-align: center;
    }
</style>

<?php
if (!empty($_GET['del'])) {
    $id = base64_decode($_GET['del']);
    $db->deleteBlock($id);
    header("Location: BlockManagement.php");
    exit();
}

if (!empty($_GET['edit'])) {
    $id = base64_decode($_GET['edit']);
    $block = $db->getBlockById($id);
    $block_heading = $block['block_heading'];
    $block_image = $block['block_image'];
    $edit_mode = true;
    $success = "";
    $error = "";
}
?>

<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1">Block Management (Max 3 Blocks)</h3>

        <!-- Display success or error message -->
        <?php if (!empty($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Add Block Section -->
        <div id="add-block-section" 
             style="<?php echo ($block_count >= 3) ? 'display: none;' : ''; ?>">
            <div class="xs" style="margin-bottom: 20px;">
                <div class="bs-example4" data-example-id="form-example">
                    <h4 style="margin-bottom: 15px; font-size: 18px; color: #333;">Add New Block</h4>
                    <form id="add-block-form" action="" method="post" enctype="multipart/form-data" style="background: #f9f9f9; padding: 15px; border: 1px solid #e0e0e0; border-radius: 6px; width: 100%; box-sizing: border-box; display: flex; flex-wrap: wrap; gap: 10px;">
                        <input type="hidden" name="block_id" value="<?php if (!empty($_GET['edit'])) {
                                                                        echo base64_decode($_GET['edit']);
                                                                    } ?>">

                        <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                            <label for="block_image" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Block Image</label>
                            <input type="file" id="block_image" name="block_image" accept="image/*" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                        </div>
                        <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                            <label for="block_heading" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Block Heading</label>
                            <input type="text" id="block_heading" value="<?php if (!empty($_GET['edit'])) {
                                                                                echo $block_heading;
                                                                            } ?>" name="block_heading" placeholder="Enter block heading" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                        </div>
                        <div style="width: 100%; margin-top: 10px;">
                            <button type="submit" style="width: 100%; padding: 8px; background: #6f42c1; color: #fff; border: none; border-radius: 4px; font-size: 14px; cursor: pointer;"
                                <?php if (!empty($_GET['edit'])) {
                                    echo "name='update_block'";
                                } else {
                                    echo "name='add_block'";
                                } ?>>
                                <?php if (!empty($_GET['edit'])) {
                                    echo "Update Block";
                                } else {
                                    echo "Add Block";
                                } ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Limit Reached Message -->
        <?php if ($block_count >= 3): ?>
            <div class="limit-reached-message">
                Maximum limit of 3 blocks has been reached. You can only edit existing blocks.
            </div>
        <?php endif; ?>

        <!-- Block Table -->
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="table-responsive">
                    <table class="table table-bordered" id="block-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Block Heading</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            while ($row = $blocks->fetch_assoc()) {
                                $count++;
                                echo "
                                    <tr>
                                        <td>{$count}</td>
                                        <td><img src='" . htmlspecialchars($row['block_image'] ?? '') . "' alt='Block Image' style='max-width: 100px; height: auto;'></td>
                                        <td>" . htmlspecialchars($row['block_heading'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['cdt'] ?? '') . "</td>
                                        <td>
                                            <a href='javascript:void(0)' class='btn btn-warning btn-sm' onclick='fedit(\"" . base64_encode($row['id']) . "\")'>Edit</a>
                                            <a href='javascript:void(0)' class='btn btn-danger btn-sm' onclick='fdel(\"" . base64_encode($row['id']) . "\")'>Delete</a>
                                        </td>
                                    </tr>
                                ";
                            }
                            if ($count === 0) {
                                echo "<tr><td colspan='5' style='text-align: center;'>No blocks found.</td></tr>";
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
    document.addEventListener('DOMContentLoaded', function() {
        const blockCount = <?php echo $block_count; ?>;
        const addBlockSection = document.getElementById('add-block-section');

        function fdel(id) {
            var r = confirm("Are you sure you want to delete this block?");
            if (r == true) {
                window.location.href = "BlockManagement.php?del=" + id;
            }
        }

        function fedit(id) {
            window.location.href = "BlockManagement.php?edit=" + id;
        }

        // Attach global functions to window
        window.fdel = fdel;
        window.fedit = fedit;
    });
</script>