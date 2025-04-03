<?php
ob_start();
include("header.php");
?>

<?php
$db = new AboutUs();
$error = '';
$success = '';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Handle deletion
if (!empty($_GET['del'])) {
    $id = base64_decode($_GET['del']);
    $db->deleteAboutUs($id);
    $_SESSION['success'] = "About Us entry deleted successfully!";
    header("Location: AboutUsManagement.php");
    exit();
}

// Handle edit mode
$edit_mode = false;
$about = null;
if (!empty($_GET['edit'])) {
    $about_id = base64_decode($_GET['edit']);
    $about = $db->getAboutUsById($about_id);
    if ($about) {
        $edit_mode = true;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add_about']) || isset($_POST['update_about']))) {
    $about_id = isset($_POST['about_id']) ? trim($_POST['about_id']) : '';
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $photos = []; // Array to store photo paths

    // Basic validation
    if (empty($title) || empty($description)) {
        $error = "Title and description are required.";
    }

    // Handle multiple file uploads
    if (!empty($_FILES['photos']['name'][0])) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $total_files = count($_FILES['photos']['name']);

        for ($i = 0; $i < $total_files; $i++) {
            $target_file = $target_dir . uniqid() . '_' . basename($_FILES['photos']['name'][$i]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if (in_array($imageFileType, $allowed_types) && move_uploaded_file($_FILES['photos']['tmp_name'][$i], $target_file)) {
                $photos[] = $target_file;
            } else {
                $error = "Invalid or unsupported image file(s).";
                break;
            }
        }
    } elseif ($edit_mode && !empty($about['photo'])) {
        $photos = $about['photo']; // Retain existing photos if no new upload
    }

    if (empty($error) && !empty($photos)) {
        if (!empty($about_id)) {
            $res = $db->updateAboutUs($about_id, $title, $description, $photos);
            if ($res) {
                $_SESSION['success'] = "About Us entry updated successfully!";
                header("Location: AboutUsManagement.php");
                exit();
            } else {
                $error = "Failed to update About Us entry. Please try again.";
            }
        } else {
            $res = $db->addAboutUs($title, $description, $photos);
            if ($res) {
                $_SESSION['success'] = "About Us entry added successfully!";
                header("Location: AboutUsManagement.php");
                exit();
            } else {
                $error = "Failed to add About Us entry. Please try again.";
            }
        }
    } elseif (empty($photos)) {
        $error = "At least one photo is required.";
    }
}

// Fetch all About Us entries
$result = $db->getAllAboutUs();
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
.image-preview {
    max-width: 100px;
    margin: 5px;
}
</style>

<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1" style="font-size: 24px; margin-bottom: 20px; color: #333;">About Us Management</h3>

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
                <h4 style="margin-bottom: 15px; font-size: 18px; color: #333;"><?php echo $edit_mode ? 'Edit About Us' : 'Add New About Us'; ?></h4>
                <form id="add-about-form" action="" method="post" enctype="multipart/form-data" style="background: #f9f9f9; padding: 15px; border: 1px solid #e0e0e0; border-radius: 6px; width: 100%; box-sizing: border-box; display: flex; flex-wrap: wrap; gap: 10px;">
                    <input type="hidden" name="about_id" value="<?php echo $edit_mode ? htmlspecialchars($about['about_id']) : ''; ?>">

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="title" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Title</label>
                        <input type="text" id="title" name="title" placeholder="Enter title" value="<?php echo $edit_mode ? htmlspecialchars($about['title']) : ''; ?>" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>

                    <div id="editor" style="width: 100%; margin-bottom: 15px;">
                        <label for="description" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Description</label>
                        <textarea id="description" name="description" placeholder="Enter description" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff; resize: vertical; min-height: 100px;"><?php echo $edit_mode ? htmlspecialchars($about['description']) : ''; ?></textarea>
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="photos" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Photos</label>
                        <input type="file" id="photos" name="photos[]" multiple accept="image/*" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;" required>
                        <?php if ($edit_mode && !empty($about['photo']) && is_array($about['photo'])): ?>
                            <div style="margin-top: 10px;">
                                <?php foreach ($about['photo'] as $photo): ?>
                                    <img src="<?php echo htmlspecialchars($photo); ?>" alt="Current Photo" class="image-preview">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div style="width: 100%; margin-top: 10px;">
                        <button type="submit" name="<?php echo $edit_mode ? 'update_about' : 'add_about'; ?>" style="width: 100%; padding: 8px; background: #6f42c1; color: #fff; border: none; border-radius: 4px; font-size: 13px; cursor: pointer;">
                            <?php echo $edit_mode ? 'Update About Us' : 'Add About Us'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="table-responsive">
                    <table class="table table-bordered" id="about-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Photos</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            while ($row = $result->fetch_assoc()) {
                                $count++;
                                $photos = json_decode($row['photos'], true); // Decode JSON to array
                                echo "
                                    <tr>
                                        <th scope='row'>$count</th>
                                        <td>" . htmlspecialchars($row['title']) . "</td>
                                        <td>" .substr($row['description'], 0, 50) . (strlen($row['description']) > 50 ? '...' : '') . "</td>
                                        <td>";
                                if (is_array($photos)) {
                                    foreach ($photos as $photo) {
                                        echo "<img src='" . htmlspecialchars($photo) . "' alt='Photo' class='image-preview'>";
                                    }
                                }
                                echo "</td>
                                        <td>" . ($row['cdt'] !== '0000-00-00 00:00:00' ? date('Y-m-d H:i:s', strtotime($row['cdt'])) : 'N/A') . "</td>
                                        <td>
                                            <a href='javascript:void(0)' class='btn btn-warning btn-sm' onclick='fedit(\"" . base64_encode($row['about_id']) . "\")'>Edit</a>
                                            <a href='javascript:void(0)' class='btn btn-danger btn-sm' onclick='fdel(\"" . base64_encode($row['about_id']) . "\")'>Delete</a>
                                        </td>
                                    </tr>
                                ";
                            }
                            if ($count === 0) {
                                echo "<tr><td colspan='6' style='text-align: center;'>No About Us entries found.</td></tr>";
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
        var r = confirm("Are you sure you want to delete this About Us entry?");
        if (r == true) {
            window.location.href = "AboutUsManagement.php?del=" + id;
        }
    }

    function fedit(id) {
        window.location.href = "AboutUsManagement.php?edit=" + id;
    }
</script>   