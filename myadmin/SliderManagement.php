<?php
ob_start();
include("header.php");
?>

<?php
$db = new Sliders();
$error = '';
$success = '';

// Start session if not already started (since header.php already starts it, this is a safeguard)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Handle slider deletion
if (!empty($_GET['del'])) {
    $id = base64_decode($_GET['del']);
    $db->deleteSlider($id);
    $_SESSION['success'] = "Slider deleted successfully!";
    header("Location: SliderManagement.php");
    exit();
}

// Handle slider edit mode
$edit_mode = false;
$slider = null;
if (!empty($_GET['edit'])) {
    $slider_id = base64_decode($_GET['edit']);
    $slider = $db->getSliderById($slider_id);
    if ($slider) {
        $edit_mode = true;
    }
}

// Handle form submission for adding/updating a slider
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add_slider']) || isset($_POST['update_slider']))) {
    $slider_id = isset($_POST['slider_id']) ? trim($_POST['slider_id']) : '';
    $slide_title = trim($_POST['slide_title']);
    $subtitle = trim($_POST['subtitle']);
    $description = trim($_POST['description']);
    $button_text = trim($_POST['button_text']);
    $button_url = trim($_POST['button_url']);

    // Handle background image upload (using same logic as CategoryManagement.php)
    $background_image = $edit_mode ? $slider['background_image'] : '';
    if (isset($_FILES['background_image']) && $_FILES['background_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Directory to store images (same as CategoryManagement.php)
        $image_file = basename($_FILES['background_image']['name']);
        $target_file = $target_dir . uniqid() . "_" . $image_file; // Unique filename using uniqid()
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a valid type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            $error = "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
        } else {
            // Upload file
            if (move_uploaded_file($_FILES['background_image']['tmp_name'], $target_file)) {
                $background_image = $target_file;
            } else {
                $error = "Error: Failed to upload image.";
            }
        }
    } elseif (!$edit_mode && (!isset($_FILES['background_image']) || $_FILES['background_image']['error'] === UPLOAD_ERR_NO_FILE)) {
        $error = "Error: No image uploaded or upload failed.";
    }

    // Basic validation
    if (empty($error)) {
        if (empty($slide_title) || empty($subtitle) || empty($description) || empty($button_text) || empty($button_url) || empty($background_image)) {
            $error = "All fields are required.";
        }
    }

    if (empty($error)) {
        if (!empty($slider_id)) {
            // Update existing slider
            $res = $db->updateSlider(
                $slider_id,
                $slide_title,
                $subtitle,
                $description,
                $button_text,
                $button_url,
                $background_image
            );
            if ($res) {
                $_SESSION['success'] = "Slider updated successfully!";
                header("Location: SliderManagement.php");
                exit();
            } else {
                $error = "Failed to update slider. Please try again.";
            }
        } else {
            // Add new slider
            $res = $db->addSlider(
                $slide_title,
                $subtitle,
                $description,
                $button_text,
                $button_url,
                $background_image
            );
            if ($res) {
                $_SESSION['success'] = "Slider added successfully!";
                header("Location: SliderManagement.php");
                exit();
            } else {
                $error = "Failed to add slider. Please try again.";
            }
        }
    }
}

// Fetch all sliders
$result = $db->getAllSliders();
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
.slider-image-preview {
    max-width: 100px;
    height: auto;
}
</style>

<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1" style="font-size: 24px; margin-bottom: 20px; color: #333;">Slider Management</h3>

        <!-- Display success or error message -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="message success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Add/Edit Slider Form -->
        <div class="xs" style="margin-bottom: 20px;">
            <div class="bs-example4" data-example-id="form-example">
                <h4 style="margin-bottom: 15px; font-size: 18px; color: #333;"><?php echo $edit_mode ? 'Edit Slider' : 'Add New Slider'; ?></h4>
                <form id="add-slider-form" action="" method="post" enctype="multipart/form-data" style="background: #f9f9f9; padding: 15px; border: 1px solid #e0e0e0; border-radius: 6px; width: 100%; box-sizing: border-box; display: flex; flex-wrap: wrap; gap: 10px;">
                    <input type="hidden" name="slider_id" value="<?php echo $edit_mode ? htmlspecialchars($slider['slider_id']) : ''; ?>">

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="slide_title" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Slide Title</label>
                        <input type="text" id="slide_title" name="slide_title" placeholder="Enter slide title (e.g., Spring Sale)" value="<?php echo $edit_mode ? htmlspecialchars($slider['slide_title']) : ''; ?>" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="subtitle" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle" placeholder="Enter subtitle (e.g., Up to 15% Off)" value="<?php echo $edit_mode ? htmlspecialchars($slider['subtitle']) : ''; ?>" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div style="width: 100%; margin-bottom: 15px;">
                        <label for="description" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Description</label>
                        <textarea id="description" name="description" placeholder="Enter description" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff; resize: vertical; min-height: 100px;"><?php echo $edit_mode ? htmlspecialchars($slider['description']) : ''; ?></textarea>
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="button_text" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Button Text</label>
                        <input type="text" id="button_text" name="button_text" placeholder="Enter button text (e.g., Explore Deals)" value="<?php echo $edit_mode ? htmlspecialchars($slider['button_text']) : ''; ?>" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="button_url" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Button URL</label>
                        <input type="url" id="button_url" name="button_url" placeholder="Enter button URL (e.g., https://example.com)" value="<?php echo $edit_mode ? htmlspecialchars($slider['button_url']) : ''; ?>" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="background_image" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Background Image <?php echo $edit_mode ? '(Leave blank to keep current image)' : ''; ?></label>
                        <?php if ($edit_mode && !empty($slider['background_image'])): ?>
                            <p>Current Image: <img src="<?php echo htmlspecialchars($slider['background_image']); ?>" alt="Current Image" style="max-width: 100px; height: auto; margin-top: 5px;"></p>
                        <?php endif; ?>
                        <input type="file" id="background_image" name="background_image" accept="image/*" <?php echo !$edit_mode ? 'required' : ''; ?> style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div style="width: 100%; margin-top: 10px;">
                        <button type="submit" name="<?php echo $edit_mode ? 'update_slider' : 'add_slider'; ?>" style="width: 100%; padding: 8px; background: #6f42c1; color: #fff; border: none; border-radius: 4px; font-size: 13px; cursor: pointer;">
                            <?php echo $edit_mode ? 'Update Slider' : 'Add Slider'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Slider Table -->
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="table-responsive">
                    <table class="table table-bordered" id="slider-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Slide Title</th>
                                <th>Subtitle</th>
                                <th>Description</th>
                                <th>Button Text</th>
                                <th>Button URL</th>
                                <th>Background Image</th>
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
                                        <td>" . htmlspecialchars($row['slide_title']) . "</td>
                                        <td>" . htmlspecialchars($row['subtitle']) . "</td>
                                        <td>" . $row['description'] . "</td>
                                        <td>" . htmlspecialchars($row['button_text']) . "</td>
                                        <td>" . htmlspecialchars($row['button_url']) . "</td>
                                        <td><img src='" . htmlspecialchars($row['background_image']) . "' alt='Slider Image' class='slider-image-preview'></td>
                                        <td>" . ($row['created_at'] !== '0000-00-00 00:00:00' ? date('Y-m-d H:i:s', strtotime($row['created_at'])) : 'N/A') . "</td>
                                        <td>
                                            <a href='javascript:void(0)' class='btn btn-warning btn-sm' onclick='fedit(\"" . base64_encode($row['slider_id']) . "\")'>Edit</a>
                                            <a href='javascript:void(0)' class='btn btn-danger btn-sm' onclick='fdel(\"" . base64_encode($row['slider_id']) . "\")'>Delete</a>
                                        </td>
                                    </tr>
                                ";
                            }
                            if ($count === 0) {
                                echo "<tr><td colspan='9' style='text-align: center;'>No sliders found.</td></tr>";
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
        var r = confirm("Are you sure you want to delete this slider?");
        if (r == true) {
            window.location.href = "SliderManagement.php?del=" + id;
        }
    }

    function fedit(id) {
        window.location.href = "SliderManagement.php?edit=" + id;
    }
</script>