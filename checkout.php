<?php
include_once "db_config.php"; // Adjust the path based on your directory structure
session_start();

// Check if the cart is empty
// if (empty($_SESSION['cart'])) {
//     echo '<p>Your cart is empty. <a href="index.php">Back to Shopping</a></p>';
//     exit();
// }

// Remove a product from the cart if the 'remove' parameter is present in the URL
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Display cart items and total
$total = 0;


?>


<!--  -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php include "header.php" ?>


<body>
    <div class="h-screen bg-gray-100 pt-20">
        <?php
        if (empty($_SESSION['cart'])) {
            echo '<p class="text-center text-cl">Your cart is empty. <a href="index.php" class="text-orange-500">Back to Shopping</a></p>';
            exit();
        }
        ?>

        <h1 class="mb-10 text-center text-2xl font-bold">Cart Items</h1>
        <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">


            <div class="rounded-lg md:w-2/3">
                <?php foreach ($_SESSION['cart'] as $key => $item) { ?>
                    <div class="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start">
                        <img src="images/<?php echo $item['image']; ?>" alt="<?php echo $item['product_name']; ?>" class="object-cover object-center w-[7rem] h-[7rem] block" />
                        <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                            <div class="mt-5 sm:mt-0">
                                <h2 class="text-lg font-bold text-gray-900"><?php echo $item['product_name']; ?></h2>
                                <div class="flex justify-between sm:mt-4 sm:space-x-4">
                                    <p class="text-sm">Price: Ksh <?php echo $item['product_price']; ?></p>
                                    <p class="text-sm">Quantity: <?php echo $item['quantity']; ?></p>
                                    <p class="text-sm">Total: Ksh <?php echo $item['product_price'] * $item['quantity']; ?></p>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
                                <div class="flex items-center space-x-4">
                                    <a href="checkout.php?remove=<?php echo $key; ?>">
                                        <svg class="h-6 w-4" width="111px" height="111px" viewBox="-2.4 -2.4 20.80 20.80" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <title>action / 9 - action, cancel, close, delete, exit, remove, x icon</title>
                                                <g id="Free-Icons" stroke-width="1.6" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
                                                    <g transform="translate(-157.000000, -158.000000)" id="Group" stroke="#000000" stroke-width="1.6">
                                                        <g transform="translate(153.000000, 154.000000)" id="Shape">
                                                            <path d="M19,5 L5,19 M19,19 L5,5"> </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <?php
                            $total += $item['product_price'] * $item['quantity'];
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>


            <!-- Sub total -->
            <div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">
                <div class="flex justify-between">
                    <p class="text-lg font-bold">Total</p>
                    <div class="">
                        <p class="mb-1 text-lg font-bold">Ksh <?php echo $total; ?></p>
                    </div>
                </div>
                <a href="checkout_process.php" class="mt-6 w-full rounded-md bg-orange-400 py-1.5 font-medium text-blue-50 hover:bg-orange-500 block text-center">Proceed
                    to Checkout</a>
            </div>
        </div>
    </div>
    
</body>

  <?php include "footer.php"?>


</html>


<style>
    @layer utilities {

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    }
</style>