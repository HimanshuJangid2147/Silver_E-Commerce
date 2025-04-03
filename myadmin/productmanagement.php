<?php
ob_start();
include("header.php");
?>

<?php
$db = new product();
$db_category = new productcategory(); // For fetching categories

// Fetch categories for the dropdown
$categories_result = $db_category->getAllCategories();
$categories = [];
while ($category = $categories_result->fetch_assoc()) {
    $categories[] = $category;
}

// Handle form submission for adding or updating a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_name'])) {
    // Initialize variables
    $product_name = trim($_POST['product_name']);
    $product_sku = trim($_POST['product_sku']);
    $product_ammount = floatval($_POST['product_ammount']);
    $product_shortdisc = trim($_POST['product_shortdisc']);
    $product_qty = intval($_POST['product_qty']);
    $category_id = intval($_POST['category_id']);
    $tags = trim($_POST['tags']);
    $discount = floatval($_POST['discount']);
    $description = trim($_POST['description']);
    $product_id = trim($_POST['product_id']); // Hidden field for edit mode
    $best_product = intval($_POST['best_product']);
    $image_names = []; // Array to store image paths
    $error = "";
    $max_images = 5; // Maximum number of images allowed

    // In edit mode, get existing images and handle deletions
    $existing_images = [];
    if (!empty($product_id)) {
        $product_data = $db->getProductById($product_id);
        $existing_images = json_decode($product_data['product_image'] ?? '[]', true);
        if (!is_array($existing_images)) {
            $existing_images = [];
        }

        // Handle image deletions
        if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
            foreach ($_POST['delete_images'] as $image_to_delete) {
                // Remove the image from the array
                if (($key = array_search($image_to_delete, $existing_images)) !== false) {
                    unset($existing_images[$key]);
                    // Optionally, delete the file from the server
                    if (file_exists($image_to_delete)) {
                        unlink($image_to_delete);
                    }
                }
            }
            $existing_images = array_values($existing_images); // Reindex the array
        }
    }

    // Handle new image uploads
    if (isset($_FILES['product_images']) && !empty($_FILES['product_images']['name'][0])) {
        $target_dir = "uploads/";
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        // Check if total images (existing + new) exceed the limit
        $new_image_count = count(array_filter($_FILES['product_images']['name']));
        if (count($existing_images) + $new_image_count > $max_images) {
            $_SESSION['message'] = "Error: You can only upload a maximum of $max_images images. You already have " . count($existing_images) . " images.";
        } else {
            // Loop through each uploaded file
            foreach ($_FILES['product_images']['name'] as $key => $value) {
                if ($_FILES['product_images']['error'][$key] == 0) {
                    $image_file = basename($_FILES['product_images']['name'][$key]);
                    $target_file = $target_dir . uniqid() . "_" . $image_file;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Validate file type
                    if (!in_array($imageFileType, $allowed_types)) {
                        $_SESSION['message'] = "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
                        break;
                    }

                    // Move the uploaded file
                    if (move_uploaded_file($_FILES['product_images']['tmp_name'][$key], $target_file)) {
                        $image_names[] = $target_file; // Add the image path to the array
                    } else {
                        $_SESSION['message'] = "Error: Failed to upload image - " . $image_file;
                        break;
                    }
                }
            }
        }
    }

    // Combine existing images with new images
    $final_images = array_merge($existing_images, $image_names);

    // Validate that at least one image exists for new products
    if (empty($product_id) && empty($final_images)) {
        $_SESSION['message'] = "Error: At least one image is required for a new product.";
    }

    // Convert the image paths array to a JSON string
    $image_names_json = json_encode($final_images);

    // Process add or update
    if (empty($_SESSION['message'])) {
        if (!empty($product_id)) {
            // Update existing product
            $result = $db->updateProduct($product_id, $product_name, $product_sku, $product_ammount, $product_shortdisc, $product_qty, $category_id, $tags, $description, $image_names_json, $discount, $best_product);
            if ($result) {
                $_SESSION['message'] = "Product updated successfully!";
                header("Location: productmanagement.php");
                exit();
            } else {
                $_SESSION['message'] = "Failed to update product. Error: " . $db->conn->error;
            }
        } else {
            // Add new product
            $result = $db->addProduct($product_name, $product_sku, $product_ammount, $product_shortdisc, $product_qty, $category_id, $tags, $description, $image_names_json, $discount, $best_product);
            if ($result) {
                $_SESSION['message'] = "Product added successfully!";
                header("Location: productmanagement.php");
                exit();
            } else {
                $_SESSION['message'] = "Failed to add product. Error: " . $db->conn->error;
            }
        }
    }
}

// Check for edit mode
$edit_mode = !empty($_GET['edit']);
$product_data = null;
if ($edit_mode) {
    $id = base64_decode($_GET['edit']);
    $product_data = $db->getProductById($id);
}

// Fetch all products after processing the form
$products = $db->getAllProducts();
?>

<style>
    .ck-editor__editable_inline {
        min-height: 300px;
        resize: vertical;
        overflow: auto;
        border: 1px solid #ccc;
    }

    .alert {
        margin-bottom: 15px;
    }

    .image-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .image-preview img {
        max-width: 100px;
        height: auto;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .image-preview .image-container {
        position: relative;
    }

    .image-preview .delete-checkbox {
        position: absolute;
        top: 5px;
        right: 5px;
    }
</style>

<?php
// Handle product deletion
if (!empty($_GET['del'])) {
    $id = base64_decode($_GET['del']);
    // Optionally, delete associated images from the server
    $product_data = $db->getProductById($id);
    $images = json_decode($product_data['product_image'] ?? '[]', true);
    if (is_array($images)) {
        foreach ($images as $image) {
            if (file_exists($image)) {
                unlink($image);
            }
        }
    }
    $db->deleteProduct($id);
    $_SESSION['message'] = "Product deleted successfully!";
    header("Location: productmanagement.php");
    exit();
}
?>

<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1">Jewelry Products</h3>

        <!-- Display success or error message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo strpos($_SESSION['message'], 'successfully') !== false ? 'success' : 'danger'; ?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <!-- Add/Edit Product Form -->
        <div class="xs" style="margin-bottom: 20px;">
            <div class="bs-example4" data-example-id="form-example">
                <h4 style="margin-bottom: 15px; font-size: 18px; color: #333;"><?php echo $edit_mode ? 'Edit Product' : 'Add New Product'; ?></h4>
                <form id="add-product-form" method="POST" enctype="multipart/form-data" style="background: #f9f9f9; padding: 15px; border: 1px solid #e0e0e0; border-radius: 6px; width: 100%; box-sizing: border-box; display: flex; flex-wrap: wrap; gap: 10px;">
                    <input type="hidden" name="product_id" value="<?php echo $edit_mode ? htmlspecialchars(base64_decode($_GET['edit'])) : ''; ?>">

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="category_id" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Category</label>
                        <select id="category_id" name="category_id" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                            <option value="">Select Category</option>
                            <?php
                            foreach ($categories as $category) {
                                $selected = ($edit_mode && $product_data['category_id'] == $category['category_id']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($category['category_id']) . '" ' . $selected . '>' . htmlspecialchars($category['category_name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="product_images" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Product Images (Select multiple, max 5)</label>
                        <input type="file" id="product_images" name="product_images[]" accept="image/*" multiple <?php echo !$edit_mode ? 'required' : ''; ?> style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                        <?php if ($edit_mode && $product_data['product_image']): ?>
                            <p>Current Images (check to delete):</p>
                            <div class="image-preview">
                                <?php
                                $images = json_decode($product_data['product_image'], true);
                                if (is_array($images)) {
                                    foreach ($images as $image) {
                                        echo '<div class="image-container">';
                                        echo '<img src="' . htmlspecialchars($image) . '" alt="Product Image">';
                                        echo '<input type="checkbox" class="delete-checkbox" name="delete_images[]" value="' . htmlspecialchars($image) . '">';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="product_name" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Product Name</label>
                        <input type="text" id="product_name" name="product_name" value="<?php echo $edit_mode ? htmlspecialchars($product_data['product_name']) : ''; ?>" placeholder="Enter product name" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>
                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="product_sku" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Product SKU</label>
                        <input type="text" id="product_sku" name="product_sku" value="<?php echo $edit_mode ? htmlspecialchars($product_data['product_sku']) : ''; ?>" placeholder="Enter SKU" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>
                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="product_ammount" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Amount (₹)</label>
                        <input type="number" id="product_ammount" name="product_ammount" step="0.01" value="<?php echo $edit_mode ? htmlspecialchars($product_data['product_ammount']) : ''; ?>" placeholder="Enter amount" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>
                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="discount" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Discount</label>
                        <input type="number" id="discount" name="discount" step="0.01" value="<?php echo $edit_mode ? htmlspecialchars($product_data['discount']) : ''; ?>" placeholder="Enter discount" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>
                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="product_qty" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Quantity</label>
                        <input type="number" id="product_qty" name="product_qty" value="<?php echo $edit_mode ? htmlspecialchars($product_data['product_qty']) : ''; ?>" placeholder="Enter quantity" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>
                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="tags" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Tags</label>
                        <input type="text" id="tags" name="tags" value="<?php echo $edit_mode ? htmlspecialchars($product_data['tags']) : ''; ?>" placeholder="Enter tags" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>
                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="best_product" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Best Product</label>
                        <select id="best_product" name="best_product" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                            <option value="0" <?php echo $edit_mode && $product_data['best_product'] == 0 ? 'selected' : ''; ?>>No</option>
                            <option value="1" <?php echo $edit_mode && $product_data['best_product'] == 1 ? 'selected' : ''; ?>>Yes</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 300px; margin-bottom: 10px;">
                        <label for="short_description" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Short Description</label>
                        <input type="text" id="product_shortdisc" name="product_shortdisc" value="<?php echo $edit_mode ? htmlspecialchars($product_data['product_shortdisc']) : ''; ?>" placeholder="Enter short description" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                    </div>
                    <div id="editor" style="width: 100%; margin-bottom: 15px;">
                        <label for="description" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Description</label>
                        <textarea id="description" name="description" placeholder="Enter description" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff; resize: vertical; min-height: 100px;"><?php echo $edit_mode ? htmlspecialchars($product_data['description']) : ''; ?></textarea>
                    </div>
                    <div style="width: 100%; margin-top: 10px;">
                        <button type="submit" style="width: 100%; padding: 8px; background: #6f42c1; color: #fff; border: none; border-radius: 4px; font-size: 14px; cursor: pointer;">
                            <?php echo $edit_mode ? 'Update Product' : 'Add Product'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Table -->
        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <div class="table-responsive">
                    <table class="table table-bordered" id="product-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Images</th>
                                <th>Product Name</th>
                                <th>Best Product</th>
                                <th>SKU</th>
                                <th>Amount (₹)</th>
                                <th>Discount</th>
                                <th>Short Description</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Tags</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="product-table-body">
                            <?php
                            $count = 0;
                            while ($row = $products->fetch_assoc()) {
                                $count++;
                                $display_amount = number_format($row['product_ammount'] ?? 0, 2);
                                echo "
                                    <tr>
                                        <td>{$count}</td>
                                        <td>";
                                // Display multiple images
                                $images = json_decode($row['product_image'] ?? '[]', true);
                                if (is_array($images) && !empty($images)) {
                                    echo '<div class="image-preview">';
                                    foreach ($images as $image) {
                                        echo '<img src="' . htmlspecialchars($image) . '" alt="Product Image">';
                                    }
                                    echo '</div>';
                                } else {
                                    echo 'No images';
                                }
                                echo "</td>
                                        <td>" . htmlspecialchars($row['product_name'] ?? '') . "</td>
                                        <td>" . ($row['best_product'] === '1' ? 'Yes' : 'No') . "</td>
                                        <td>" . htmlspecialchars($row['product_sku'] ?? '') . "</td>
                                        <td>₹{$display_amount}</td>
                                        <td>" . htmlspecialchars($row['discount'] ?? '') . "%" . "</td>
                                        <td>" . substr(strip_tags($row['product_shortdisc'] ?? ''), 0, 50) . "..." . "</td>
                                        <td>" . htmlspecialchars($row['product_qty'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['category_name'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['tags'] ?? '') . "</td>
                                        <td>" . substr(strip_tags($row['description'] ?? ''), 0, 50) . "..." . "</td>
                                        <td>
                                            <a href='javascript:void(0)' class='btn btn-warning btn-sm' onclick='fedit(\"" . base64_encode($row['product_id']) . "\")'>Edit</a>
                                            <a href='javascript:void(0)' class='btn btn-danger btn-sm' onclick='fdel(\"" . base64_encode($row['product_id']) . "\")'>Delete</a>
                                        </td>
                                    </tr>
                                ";
                            }
                            if ($count === 0) {
                                echo "<tr><td colspan='13' style='text-align: center;'>No products found.</td></tr>";
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

<?php include("footer.php"); ?>

<script>
    function fdel(id) {
        var r = confirm("Are you sure you want to delete this product?");
        if (r == true) {
            window.location.href = "productmanagement.php?del=" + id;
        }
    }

    function fedit(id) {
        window.location.href = "productmanagement.php?edit=" + id;
    }
</script>