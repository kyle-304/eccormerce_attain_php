<?php
include_once "db_config.php"; // Adjust the path based on your directory structure
session_start();

// Fetch featured products from the database
$sql = "SELECT * FROM products WHERE quantity > 0 LIMIT 8";
$result = $conn->query($sql);

// Check if the user is logged in
$isUserLoggedIn = isset($_SESSION['user_id']);

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
  <title>Your Website</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function addToCart(productId, maxQuantity) {
      var quantityInput = document.getElementById("quantity_" + productId).value;

      // Validate the entered quantity
      var quantity = parseInt(quantityInput, 10);
      if (isNaN(quantity) || quantity < 1 || quantity > maxQuantity) {
        alert("Please enter a valid quantity between 1 and " + maxQuantity + ".");
        return;
      }

      <?php if ($isUserLoggedIn) : ?>
        // If user is logged in, redirect to add_to_cart.php with product_id and quantity
        window.location.href = "add_to_cart.php?product_id=" + productId + "&quantity=" + quantity;
      <?php else : ?>
        // If user is not logged in, display a pop-up message
        alert("You need to be logged in to add products to your cart.");
      <?php endif; ?>
    }
  </script>
</head>

<body>

  <?php include "header.php" ?>

  <section class="text-gray-600 body-font h-screen">
    <div class="container px-[12rem] mx-auto">
      <br>
      <div class="flex flex-wrap -m-4">
        <?php if (!empty($products)) : ?>
          <?php foreach ($products as $product) : ?>
            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
              <a class="block relative h-48 rounded overflow-hidden">
                <img alt="ecommerce" class="object-cover object-center w-full h-full block" src="images/<?php echo $product['image']; ?>">
              </a>
              <div class="mt-4">
                <h2 class="text-gray-900 title-font text-lg font-medium"><?php echo $product['product_name']; ?></h2>
                <p class="mt-1">ksh <?php echo $product['product_price']; ?></p>
                <!-- <p>Quantity Available: <?php echo $product['quantity']; ?></p> -->
                <?php if ($product['quantity'] > 0) : ?>
                  <div class="flex items-center">
                    <input type="number" id="quantity_<?php echo $product['product_id']; ?>" class="border rounded-md p-1 w-16 text-center" value="1" min="1" max="<?php echo $product['quantity']; ?>">
                    <button class="ml-2 bg-gray-100 text-gray-900 px-3 py-1 rounded-md hover:bg-gray-200" onclick="addToCart(<?php echo $product['product_id']; ?>, <?php echo $product['quantity']; ?>)">Add to Cart</button>
                  </div>
                <?php else : ?>
                  <p class="text-red-500">Out of Stock</p>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
      </div>
    <?php else : ?>
      <p>No products available.</p>
    <?php endif; ?>
    </div>
  </section>

 <?php include "footer.php"?>

</body>



</html>



