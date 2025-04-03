<?php
// index.php

// Include the Database class
include 'class.php';

// Create a new Database object
$db = new Database();
$conn = $db->getConnection();

// Test the connection
if ($conn) {
    echo "Connected successfully to the database!<br>";

    // Query the users table
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<h2>Users List</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row['id'] . " - Name: " . $row['name'] . "<br>";
            }
        } else {
            echo "No users found in the table.";
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }
} else {
    echo "Failed to connect to the database.";
}

// Close the connection
$db->closeConnection();
?>

<!-- Include other parts of your page -->
<?php include 'header.php'; ?>
<!-- Your HTML content -->
<?php include 'footer.php'; ?>