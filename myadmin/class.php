<?php
session_start();
class database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "silver.com";
    public $conn;
    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
class GeneralSettings extends Database
{
    function getSettings()
    {
        $sql = "SELECT * FROM generalsettings";
        $result = $this->conn->query($sql);
        return $result;
    }
};

class UpdateSettings extends Database
{
    function updateSettings($column, $value, $id)
    {
        $sql = "UPDATE generalsettings SET $column='$value' WHERE id=$id";
        $result = $this->conn->query($sql);
        return $result;
    }
};

class AdminLogin extends Database
{
    function login($email, $password)
    {
        // Hash the input password with the same format
        $hashed_password = md5(sha1($password));

        // Compare with the stored hash
        $sql = "SELECT * FROM generalsettings  WHERE username='$email' AND password='$hashed_password'";
        $result = $this->conn->query($sql);
        return $result;
    }
};

class Logout extends Database
{
    function logout()
    {
        session_destroy();
        header("Location: login.php");
        exit();
    }
};

class productcategory extends Database
{
    function getAllCategories()
    {
        $sql = "SELECT * FROM productcategory";
        $result = $this->conn->query($sql);
        return $result;
    }

    function getCategoryById($id)
    {
        $sql = "SELECT * FROM productcategory WHERE category_id=$id";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    function addCategory($category_name, $category_disc, $category_image, $cdt)
    {
        $sql = "INSERT INTO productcategory (category_name, category_disc, category_image, cdt) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $category_name, $category_disc, $category_image, $cdt);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function updateCategory($category_id, $category_name, $category_disc, $category_image)
    {
        $sql = "UPDATE productcategory SET category_name='$category_name', category_disc='$category_disc',
             category_image='$category_image', cdt=now() WHERE category_id='$category_id'";
        mysqli_query($this->conn, $sql);
        return false;
    }

    function deleteCategory($category_id)
    {
        $sql = "DELETE FROM productcategory WHERE category_id=$category_id";
        mysqli_query($this->conn, $sql);
        return true;
    }
}

class product extends Database
{
    function getAllProducts()
    {
        $sql = "SELECT p.*, pc.category_name 
                    FROM product p 
                    LEFT JOIN productcategory pc ON p.category_id = pc.category_id";
        $result = $this->conn->query($sql);
        return $result;
    }

    function getProductById($id)
    {
        $sql = "SELECT * FROM product WHERE product_id=$id";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    function addProduct($product_name, $product_sku, $product_ammount, $product_shortdisc, $product_qty, $category_id, $tags, $description, $product_image, $discount, $best_product)
    {

        // Cast product_ammount to integer to match int(11) column
        $product_ammount = intval($product_ammount);
        $sql = "INSERT INTO product (product_name, product_sku, product_ammount, product_shortdisc, product_qty, category_id, tags,description, product_image, discount, best_product) 
                    VALUES('$product_name', '$product_sku','$product_ammount', '$product_shortdisc', '$product_qty', '$category_id', '$tags', '$description', '$product_image', '$discount', '$best_product')";

        $result = mysqli_query($this->conn, $sql);
        return $result;
    }

    function updateProduct($product_id, $product_name, $product_sku, $product_ammount, $product_shortdisc, $product_qty, $category_id, $tags, $description, $product_image, $discount, $best_product)
    {
        // Cast product_ammount to integer to match int(11) column

        $product_ammount = intval($product_ammount);
        $sql = "UPDATE product 
                    SET product_name='$product_name', product_sku='$product_sku', product_ammount='$product_ammount', product_shortdisc='$product_shortdisc', product_qty='$product_qty', category_id='$category_id', tags='$tags', description='$description', product_image='$product_image', discount='$discount', best_product='$best_product'
                    WHERE product_id='$product_id'";
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }

    function deleteProduct($product_id)
    {
        $sql = "DELETE FROM product WHERE product_id=?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $product_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
}

class Coupons extends Database
{
    function getAllCoupons()
    {
        $sql = "SELECT * FROM couponmanagement";
        $result = $this->conn->query($sql);
        return $result;
    }

    function getCouponById($id)
    {
        $sql = "SELECT * FROM couponmanagement WHERE coupon_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_assoc();
        }
        return false;
    }

    function addCoupon($coupon_code, $description, $coupon_type, $discount, $min_purchase_amount, $start_date, $exp_date, $coupon_status)
    {
        $sql = "INSERT INTO couponmanagement (coupon_code, coupon_description, coupon_type, coupon_discount_value, min_purchase_ammount, start_date, exp_date, coupon_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssddsss", $coupon_code, $description, $coupon_type, $discount, $min_purchase_amount, $start_date, $exp_date, $coupon_status);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function updateCoupon($coupon_id, $coupon_code, $description, $coupon_type, $discount, $min_purchase_amount, $start_date, $exp_date, $coupon_status)
    {
        $sql = "UPDATE couponmanagement SET coupon_code = ?, coupon_description = ?, coupon_type = ?, coupon_discount_value = ?, min_purchase_ammount = ?, start_date = ?, exp_date = ?, coupon_status = ? WHERE coupon_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssddsssi", $coupon_code, $description, $coupon_type, $discount, $min_purchase_amount, $start_date, $exp_date, $coupon_status, $coupon_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function deleteCoupon($coupon_id)
    {
        $sql = "DELETE FROM couponmanagement WHERE coupon_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $coupon_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function applyCoupon($customer_id, $coupon_id)
    {
        $sql = "UPDATE customers SET coupon_id = ? WHERE customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $coupon_id, $customer_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
}

class AboutUs extends Database
{
    function getAllAboutUs()
    {
        $sql = "SELECT * FROM about_us";
        $result = $this->conn->query($sql);
        return $result;
    }

    function getAboutUsById($id)
    {
        $sql = "SELECT * FROM about_us WHERE about_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_assoc();
        }
        return false;
    }

    function addAboutUs($title, $description, $photos)
    {
        $photos_json = json_encode($photos); // Convert array to JSON
        $sql = "INSERT INTO about_us (title, description, photos) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $title, $description, $photos_json);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function updateAboutUs($about_id, $title, $description, $photos)
    {
        $photos_json = json_encode($photos); // Convert array to JSON
        $sql = "UPDATE about_us SET title = ?, description = ?, photos = ? WHERE about_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssi", $title, $description, $photos_json, $about_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function deleteAboutUs($about_id)
    {
        $sql = "DELETE FROM about_us WHERE about_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $about_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
}

class TermsConditions extends Database
{
    function getAllTerms()
    {
        $sql = "SELECT * FROM terms_conditions";
        $result = $this->conn->query($sql);
        return $result;
    }

    function getTermsById($id)
    {
        $sql = "SELECT * FROM terms_conditions WHERE terms_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_assoc();
        }
        return false;
    }

    function addTerms($title, $content)
    {
        $sql = "INSERT INTO terms_conditions (title, content) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ss", $title, $content);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function updateTerms($terms_id, $title, $content)
    {
        $sql = "UPDATE terms_conditions SET title = ?, content = ? WHERE terms_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $title, $content, $terms_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function deleteTerms($terms_id)
    {
        $sql = "DELETE FROM terms_conditions WHERE terms_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $terms_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
}

class Sliders extends Database
{
    function getAllSliders()
    {
        $sql = "SELECT * FROM sliders ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    function getSliderById($id)
    {
        $sql = "SELECT * FROM sliders WHERE slider_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_assoc();
        }
        return false;
    }

    function addSlider($slide_title, $subtitle, $description, $button_text, $button_url, $background_image)
    {
        $sql = "INSERT INTO sliders (slide_title, subtitle, description, button_text, button_url, background_image, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssss", $slide_title, $subtitle, $description, $button_text, $button_url, $background_image);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function updateSlider($slider_id, $slide_title, $subtitle, $description, $button_text, $button_url, $background_image)
    {
        $sql = "UPDATE sliders SET slide_title = ?, subtitle = ?, description = ?, button_text = ?, button_url = ?, background_image = ? WHERE slider_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssi", $slide_title, $subtitle, $description, $button_text, $button_url, $background_image, $slider_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function deleteSlider($slider_id)
    {
        $sql = "DELETE FROM sliders WHERE slider_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $slider_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
}

class BlockManagement extends Database
{
    function getAllBlocks()
    {
        $sql = "SELECT * FROM blockmanagement"; // Fixed table name
        $result = $this->conn->query($sql);
        return $result;
    }

    function getBlockById($id)
    {
        $sql = "SELECT * FROM blockmanagement WHERE id=$id"; // Fixed table name
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    function addBlock($block_heading, $block_image = null, $cdt)
    {
        $sql = "INSERT INTO blockmanagement (block_heading, block_image, cdt) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $block_heading, $block_image, $cdt);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function updateBlock($block_id, $block_heading, $block_image)
    {
        $sql = "UPDATE blockmanagement SET block_heading='$block_heading', block_image='$block_image', cdt=now() WHERE id='$block_id'"; // Fixed table name
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }

    function deleteBlock($block_id)
    {
        $sql = "DELETE FROM blockmanagement WHERE id=$block_id"; // Fixed table name
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }
}

class customerreviews extends Database
{
    public function getAllReviews()
    {
        $sql = "SELECT * FROM reviews ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function deleteReview($id)
    {
        $sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
}

class Enquiry extends Database
{
    function getAllEnquiries()
    {
        $sql = "SELECT * FROM enquiries ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    function getEnquiryById($id)
    {
        $sql = "SELECT * FROM enquiries WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_assoc();
        }
        return false;
    }

    function deleteEnquiry($id)
    {
        $sql = "DELETE FROM enquiries WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
}

class Policies extends Database
{
    function getAllPolicies()
    {
        $sql = "SELECT * FROM our_policies";
        $result = $this->conn->query($sql);
        return $result;
    }

    function getPolicyById($id)
    {
        $sql = "SELECT * FROM our_policies WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_assoc();
        }
        return false;
    }

    function addPolicy( $privacy_policy, $terms_and_conditions, $shipping_and_return, $refund_policy)
    {
        $sql = "INSERT INTO our_policies (about_us, privacy_policy, terms_and_conditions, shipping_and_return, refund_policy, contact_us) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $privacy_policy, $terms_and_conditions, $shipping_and_return, $refund_policy);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
    
    function updatePolicy($id, $privacy_policy, $terms_and_conditions, $shipping_and_return, $refund_policy)
    {
        $sql = "UPDATE our_policies SET 
            about_us = ?, 
            privacy_policy = ?, 
            terms_and_conditions = ?, 
            shipping_and_return = ?, 
            refund_policy = ?, 
            contact_us = ? 
            WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssi", 
                $privacy_policy, 
                $terms_and_conditions, 
                $shipping_and_return, 
                $refund_policy, 
                $id
            );
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
    
    function deletePolicy($id)
    {
        $sql = "DELETE FROM policies WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
        }
        return false;
    }
}

class OrderManagement extends Database
{
    function getAllOrders()
    {
        $sql = "SELECT o.*, m.full_name AS customer_name 
                FROM orders o 
                LEFT JOIN member_login_details m ON o.user_id = m.id 
                ORDER BY o.created_at DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    function getOrderById($order_id)
    {
        $sql = "SELECT o.*, m.full_name AS customer_name 
                FROM orders o 
                LEFT JOIN member_login_details m ON o.user_id = m.id 
                WHERE o.id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_assoc();
        }
        return false;
    }

    function updateOrderStatus($order_id, $status)
    {
        $sql = "UPDATE orders SET order_status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si", $status, $order_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function addOrderNote($order_id, $note)
    {
        $sql = "INSERT INTO order_notes (order_id, note, created_at) VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("is", $order_id, $note);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function getOrderNotes($order_id)
    {
        $sql = "SELECT * FROM order_notes WHERE order_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }
        return false;
    }

    function getOrderItemsByOrderId($order_id)
{
    $sql = "SELECT * FROM order_item WHERE order_id = ?";
    $stmt = $this->conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result; // This is correct
    }
    return false;
}
}