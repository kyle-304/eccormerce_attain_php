<?php
include_once "db_config.php";  // Adjust the path based on your directory structure
session_start();

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    echo '<p>Your cart is empty. <a href="index.php">Back to Shopping</a></p>';
    exit();
}

// Insert order details into the database
$user_id = 1;  // Replace with the actual user ID
$total_amount = 0;

// Calculate the total amount and insert the order
foreach ($_SESSION['cart'] as $item) {
    $total_amount += $item['product_price'] * $item['quantity'];
}

// Insert order information into the orders table
$insert_order_sql = "INSERT INTO orders (user_id, total_amount, name, address, email) VALUES ('$user_id', '$total_amount', '{$_POST['name']}', '{$_POST['address']}', '{$_POST['email']}')";
$conn->query($insert_order_sql);

// Get the last inserted order_id
$order_id = $conn->insert_id;

// Insert order items into the order_items table
foreach ($_SESSION['cart'] as $item) {
    $product_id = $item['product_id'];
    $product_name = $item['product_name'];
    $product_price = $item['product_price'];
    $quantity = $item['quantity'];

    $insert_order_item_sql = "INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity) VALUES ('$order_id', '$product_id', '$product_name', '$product_price', '$quantity')";
    $conn->query($insert_order_item_sql);
}

// Clear the cart after processing the order
$_SESSION['cart'] = array();

echo '<p>Thank you for your order! <a href="index.php">Back to Shopping</a></p>';
?>
