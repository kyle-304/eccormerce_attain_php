<?php
session_start();
include_once "db_config.php";

// Get product_id and quantity from the URL or form submission
$product_id = $_GET['product_id'];
$quantity = $_GET['quantity'];

// Fetch product details from the database
$sql = "SELECT * FROM products WHERE product_id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();

    // Add the item to the cart with quantity information
    $_SESSION['cart'][$product_id] = [
        'product_id' => $product['product_id'],
        'product_name' => $product['product_name'],
        'product_price' => $product['product_price'],
        'image' => $product['image'],
        'quantity' => $quantity, // Store the selected quantity
    ];

    header("Location: index.php"); // Redirect back to the index page
    exit();
} else {
    echo "Product not found.";
}
