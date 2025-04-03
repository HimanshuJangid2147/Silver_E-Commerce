<?php
ob_start();
include("header.php");
?>

<?php
$db = new productcategory();

// Handle form submission for adding a category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_name'])) {
    // Initialize variables
    $category_name = trim($_POST['category_name']);
    $category_disc = trim($_POST['description']);
    $category_id = trim($_POST['category_id']);
    $image_name = "";
    $error = "";
    $success = "";

    // Handle image upload
    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
        $target_dir = "uploads/"; // Directory to store images
        $image_file = basename($_FILES['category_image']['name']);
        $target_file = $target_dir . uniqid() . "_" . $image_file; // Unique filename
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a valid type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            $error = "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
        } else {
            // Upload file
            if (move_uploaded_file($_FILES['category_image']['tmp_name'], $target_file)) {
                $image_name = $target_file;
            } else {
                $error = "Error: Failed to upload image.";
            }
        }
    } else {
        $error = "Error: No image uploaded or upload failed.";
    }

    // If no errors, proceed to insert into database
    if (empty($error)) {
        $cdt = date('Y-m-d H:i:s'); // Current timestamp
    if($category_id!="")
    {
        $result = $db->updateCategory($category_id, $category_name, $category_disc, $image_name);
        if ($result) {
            $success = "Category updated successfully!";
        } else {
            $error = "Failed to update category. Please try again.";
        }
    }
    else
    {
        $result = $db->addCategory($category_name, $category_disc, $image_name, $cdt);
        if ($result) {
            $success = "Category added successfully!";
            header("Location: CategoryManagement.php");
        } else {
            $error = "Failed to add category. Please try again.";
        }
    }
    }
}

// Button Change to Edit
if($Edit = !empty($_GET['edit']))
{
    $edit_mode = true;
}
else
{
    $edit_mode = false;
}

// Fetch all categories after processing the form
$categories = $db->getAllCategories();
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
<?php
if(!empty($_GET['del']))
{
    $id = base64_decode($_GET['del']);
   
    $db->deleteCategory($id);
    header("Location: CategoryManagement.php");
    exit();

}

if(!empty($_GET['edit']))
{
    $id = base64_decode($_GET['edit']);
    $db->getCategoryById($id);

    // Get the category details for editing
    $category = $db->getCategoryById($id);
    $category_name = $category['category_name'];
    $category_disc = $category['category_disc'];
    $category_image = $category['category_image'];
    $edit_mode = true;
    $success = "";
    $error = "";
        

}

?>
<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1">Jewelry Categories</h3>

        <!-- Display success or error message -->
        <?php if (!empty($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Add Category Form -->
        <div class="xs" style="margin-bottom: 20px;">
            <div class="bs-example4" data-example-id="form-example">
                <h4 style="margin-bottom: 15px; font-size: 18px; color: #333;">Add New Category</h4>
                <form id="add-category-form" action="" method="post" enctype="multipart/form-data" style="background: #f9f9f9; padding: 15px; border: 1px solid #e0e0e0; border-radius: 6px; width: 100%; box-sizing: border-box; display: flex; flex-wrap: wrap; gap: 10px;">
                <input type="hidden" name="category_id" value="<?php if(!empty($_GET['edit'])){echo base64_decode($_GET['edit']);} ?>">
                
                <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="category_image" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Category Image</label>
                        <input type="file" id="category_image" name="category_image" accept="image/*" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>
                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="category_name" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Category Name</label>
                        <input type="text" id="category_name" value="<?php if(!empty($_GET['edit'])){echo $category_name;} ?>" name="category_name" placeholder="Enter category name" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>
                    <div id="editor" style="width: 100%; margin-bottom: 15px;">
                        <label for="description" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Category Description</label>
                        <textarea id="description" name="description" placeholder="Enter description" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff; resize: vertical; min-height: 100px;"><?php if(!empty($_GET['edit'])){echo $category_disc;} ?></textarea>
                    </div>
                    <div style="width: 100%; margin-top: 10px;">
                    <button type="submit" style="width: 100%; padding: 8px; background: #6f42c1; color: #fff; border: none; border-radius: 4px; font-size: 14px; cursor: pointer;"
                        <?php if(!empty($_GET['edit'])){echo "name='update_category'";}else{echo "name='add_category'";} ?>>
                        <?php if(!empty($_GET['edit'])){echo "Update Category";}else{echo "Add Category";} ?>
                    </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Category Table -->
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="table-responsive">
                    <table class="table table-bordered" id="category-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            while ($row = $categories->fetch_assoc()) {
                                $count++;
                                echo "
                                    <tr>
                                        <td>{$count}</td>
                                        <td><img src='" . htmlspecialchars($row['category_image'] ?? '') . "' alt='Category Image' style='max-width: 100px; height: auto;'></td>
                                        <td>" . htmlspecialchars($row['category_name'] ?? '') . "</td>
                                        <td>" . ($row['category_disc'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['cdt'] ?? '') . "</td>
                                        <td>
                                            <a href='javascript:void(0)' class='btn btn-warning btn-sm' onclick='fedit(\"" . base64_encode($row['category_id']) . "\")'>Edit</a>
                                            <a href='javascript:void(0)' class='btn btn-danger btn-sm' onclick='fdel(\"" . base64_encode($row['category_id']) . "\")'>Delete</a>
                                        </td>
                                    </tr>
                                ";
                            }
                            if ($count === 0) {
                                echo "<tr><td colspan='6' style='text-align: center;'>No categories found.</td></tr>";
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
    function fdel(id)
    {
        var r = confirm("Are you sure you want to delete this category?");
        if (r == true) 
        {
            window.location.href = "CategoryManagement.php?del="+id;
        }
    }

    function fedit(id)
    {
        window.location.href = "CategoryManagement.php?edit="+id;
    }
</script>