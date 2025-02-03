<?php
include_once "../db_config.php"; // Adjust the path based on your directory structure

// Check if the admin is not logged in, redirect to admin login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']); // New line to get quantity

    // Insert product details into the products table
    $insert_product_sql = "INSERT INTO products (product_name, product_price, quantity) VALUES ('$product_name', '$product_price', '$quantity')";
    $conn->query($insert_product_sql);

    // Get the last inserted product_id
    $product_id = $conn->insert_id;

    // Handle image upload (similar to image.php)
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../images/'; // Create a directory named 'uploads' in your project
        $filename = uniqid() . '_' . $_FILES['product_image']['name'];
        $image_path = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path)) {
            // Update the product record with the filename
            $update_image_sql = "UPDATE products SET image = '$filename' WHERE product_id = '$product_id'";
            $conn->query($update_image_sql);
        } else {
            // Handle the case when the file couldn't be moved
            echo "Failed to move the uploaded file.";
        }
    }

    // Redirect to admin dashboard after adding the product and image
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body class="bg-gray-100">

<div class="max-w-md">
    <h2 class="text-2xl font-bold mb-4">Add Product</h2>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="product_name" class="block text-sm font-medium text-gray-600">Product Name:</label>
            <input type="text" id="product_name" name="product_name" class="mt-1 p-2 w-full border rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="product_price" class="block text-sm font-medium text-gray-600">Product Price:</label>
            <input type="text" id="product_price" name="product_price" class="mt-1 p-2 w-full border rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium text-gray-600">Quantity:</label>
            <input type="number" id="quantity" name="quantity" class="mt-1 p-2 w-full border rounded-md" value="0" required>
        </div>

        <div class="mb-4">
            <!-- Input for uploading product image -->
            <label for="product_image" class="block text-sm font-medium text-gray-600">Product Image:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*" class="mt-1" required>
        </div>

        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Add Product</button>
    </form>
</div>

</body>
</html>
