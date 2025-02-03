<?php
include_once "db.php";
session_start();

// Check if the admin is not logged in, redirect to admin login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    // Check if a file was uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/'; // Create a directory named 'uploads' in your project

        // Generate a unique filename
        $filename = uniqid() . '_' . $_FILES['product_image']['name'];

        // Move the uploaded file to the designated directory
        move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_dir . $filename);

        // Update the product record with the filename
        $update_image_sql = "UPDATE products SET image = '$filename' WHERE product_id = '$product_id'";
        $conn->query($update_image_sql);
    }

    // Redirect to admin dashboard after updating the product image
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch products for display
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Check if there are products in the database
if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = array(); // Empty array if no products are found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Images</title>
</head>
<body>

<h2>Add Image to Product</h2>

<form method="post" action="" enctype="multipart/form-data">
    <label for="product_id">Select Product:</label>
    <select id="product_id" name="product_id" required>
        <?php
foreach ($products as $product) {
    echo '<option value="' . $product['product_id'] . '">' . $product['product_name'] . '</option>';
}
?>
    </select><br>

    <label for="product_image">Upload Image:</label>
    <input type="file" id="product_image" name="product_image" accept="image/*" required><br>

    <input type="submit" value="Add Image">
</form>

</body>
</html>
