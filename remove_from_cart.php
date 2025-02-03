<?php
session_start();

// Check if the product_id is provided in the query string
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Check if the user has a cart stored in the session
    if (isset($_SESSION['cart'])) {
        // Remove the product from the cart based on the product ID
        unset($_SESSION['cart'][$productId]);

        // Redirect back to the checkout page
        header("Location: checkout.php");
        exit();
    }
}

// If no product_id is provided or if the user does not have a cart, redirect to checkout page
header("Location: checkout.php");
exit();
