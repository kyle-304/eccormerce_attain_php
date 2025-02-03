<?php
include_once "../db_config.php";

// Check if the admin is not logged in, redirect to admin login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle product update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $new_product_name = mysqli_real_escape_string($conn, $_POST['new_product_name']);
    $new_product_price = mysqli_real_escape_string($conn, $_POST['new_product_price']);
    $new_quantity = mysqli_real_escape_string($conn, $_POST['new_quantity']); // Added line for quantity update

    $update_product_sql = "UPDATE products SET product_name = '$new_product_name', product_price = '$new_product_price', quantity = '$new_quantity' WHERE product_id = '$product_id'";
    $conn->query($update_product_sql);

    // Redirect to admin dashboard after updating the product
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
    $products = array();  // Empty array if no products are found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>
<body class="bg-gray-100">

<div class="max-w-md">
    <h2 class="text-2xl font-bold mb-4">Update Product</h2>

    <form method="post" action="" >
        <div class="mb-4">
            <label for="product_id" class="block text-sm font-medium text-gray-600">Select Product to Update:</label>
            <select id="product_id" name="product_id" class="mt-1 p-2 w-full border rounded-md" required>
                <?php
                foreach ($products as $product) {
                    echo '<option value="' . $product['product_id'] . '">' . $product['product_name'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="new_product_name" class="block text-sm font-medium text-gray-600">New Product Name:</label>
            <input type="text" id="new_product_name" name="new_product_name" class="mt-1 p-2 w-full border rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="new_product_price" class="block text-sm font-medium text-gray-600">New Product Price:</label>
            <input type="text" id="new_product_price" name="new_product_price" class="mt-1 p-2 w-full border rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="new_quantity" class="block text-sm font-medium text-gray-600">New Quantity:</label>
            <input type="number" id="new_quantity" name="new_quantity" class="mt-1 p-2 w-full border rounded-md" value="0" required>
        </div>

        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Update Product</button>
    </form>
</div>

</body>
</html>
