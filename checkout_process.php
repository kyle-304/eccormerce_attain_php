<?php
include_once "db_config.php";
session_start();

// Check if the cart is not empty
if (empty($_SESSION['cart'])) {
    echo '<p>Your cart is empty. <a href="index.php">Back to Shopping</a></p>';
    exit();
}

// Assuming the user is logged in and you have their user ID
$user_id = $_SESSION['user_id'];

// Retrieve additional user details from the users table
$user_details_sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$user_details_result = $conn->query($user_details_sql);

// Check if user details are retrieved successfully
if ($user_details_result->num_rows > 0) {
    $user_details = $user_details_result->fetch_assoc();

    // Check if 'username' key exists in $user_details array
    $username = isset($user_details['username']) ? $user_details['username'] : '';

    // Calculate the total amount for the order, including quantity
    $total_amount = 0;

    try {
        $conn->begin_transaction();

        foreach ($_SESSION['cart'] as $item) {
            $total_amount += $item['product_price'] * $item['quantity'];

            // Deduct the purchased quantity from the product inventory
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];

            $update_product_sql = "UPDATE products SET quantity = quantity - '$quantity' WHERE product_id = '$product_id'";
            $conn->query($update_product_sql);
        }

        // Add order information into the orders table
        $insert_order_sql = "INSERT INTO orders (user_id, total_amount, username, phone_number) 
                             VALUES ('$user_id', '$total_amount', '$username', '{$user_details['phone_number']}')";
        $conn->query($insert_order_sql);

        // Get the last inserted order_id
        $order_id = $conn->insert_id;

        // Insert order items into the order_items table
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['product_id'];
            $product_name = $item['product_name'];
            $product_price = $item['product_price'];
            $quantity = $item['quantity'];

            $insert_order_item_sql = "INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity) 
                                      VALUES ('$order_id', '$product_id', '$product_name', '$product_price', '$quantity')";
            $conn->query($insert_order_item_sql);
        }

        // Clear the cart after processing the order
        $_SESSION['cart'] = array();

        $conn->commit();
        echo '<p>Thank you for your order! <a href="index.php">Back to Shopping</a></p>';
    } catch (Exception $e) {
        $conn->rollback();
        echo 'Error processing the order: ' . $e->getMessage();
    }
} else {
    echo '<p>Error retrieving user details. <a href="index.php">Back to Shopping</a></p>';
}

$conn->close();
?>
