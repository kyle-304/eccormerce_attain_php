<?php
include_once "db_config.php"; // Adjust the path based on your directory structure
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Check if the user has a cart stored in the session
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: checkout.php"); // Redirect to checkout page if the cart is empty
    exit();
}

// Fetch products in the user's cart from the database
$cartProductIds = array_keys($_SESSION['cart']);
$cartProducts = getCartProducts($cartProductIds);

// Insert order details into the database
$userId = $_SESSION['user_id'];


// Insert order details into the database
$sqlOrder = "INSERT INTO orders (user_id, total_amount, order_date, name, address, email) 
            VALUES ('$userId', '$totalValue', CURRENT_TIMESTAMP, 'John Doe', '123 Street', 'john@example.com')";

if ($conn->query($sqlOrder)) {
    $orderId = $conn->insert_id;

    // Insert order items into the database
    foreach ($cartProducts as $cartProduct) {
        $productId = $cartProduct['product_id'];
        $productName = $cartProduct['product_name'];
        $productPrice = $cartProduct['product_price'];
        $quantity = $_SESSION['cart'][$productId];

        $sqlOrderItem = "INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity) 
                        VALUES ('$orderId', '$productId', '$productName', '$productPrice', '$quantity')";

        $conn->query($sqlOrderItem);
    }

    // Clear the user's cart after placing the order
    unset($_SESSION['cart']);

    // Redirect to a thank you or order confirmation page
    header("Location: order_confirmation.php?order_id=$orderId");
    exit();
} else {
    // Handle the case where the order insertion failed
    echo "Error placing order: " . $conn->error;
    // You may want to redirect the user back to the checkout page or display an error message
}

// Function to fetch product details for all products in the cart
function getCartProducts($cartProductIds)
{
    global $conn;
    $cartProducts = array();

    if (!empty($cartProductIds)) {
        $cartProductIdsString = implode(",", $cartProductIds);
        $sql = "SELECT * FROM products WHERE product_id IN ($cartProductIdsString)";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cartProducts[] = $row;
            }
        }
    }

    return $cartProducts;
}


