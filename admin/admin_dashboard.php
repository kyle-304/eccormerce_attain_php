<?php
include_once "../db_config.php";  // Adjust the path based on your directory structure

session_start();

// Check if the admin is not logged in, redirect to admin login page
if (!isset($_SESSION['admin_id'])) {
   header("Location: admin_login.php");
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Dashboard</title>
   <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 font-sans">

   <div class="flex h-screen">

      <!-- Sidebar -->
      <div class="bg-gray-800 text-white w-64 p-4">
         <h1 class="text-2xl font-semibold mb-4">Admin Dashboard</h1>
         <ul>
            <li class="mb-2"><a href="?page=add_product" class="text-gray-300 hover:text-white">Add Product</a></li>
            <li class="mb-2"><a href="?page=update_product" class="text-gray-300 hover:text-white">Update Product</a></li>
            <li class="mb-2"><a href="?page=remove_product" class="text-gray-300 hover:text-white">Remove Product</a></li>
            <li class="mb-2"><a href="?page=add_admin" class="text-gray-300 hover:text-white">Add Admin</a></li>
            <li class="mb-2"><a href="?page=logout" class="text-gray-300 hover:text-white">Logout</a></li>
         </ul>
      </div>

      <!-- Main Content -->
      <div class="flex-1 p-8">


         <?php
         // Check if a specific page is requested
         $page = isset($_GET['page']) ? $_GET['page'] : '';

         // Include the content of the requested page
         if ($page) {
            $pagePath = "{$page}.php";
            if (file_exists($pagePath)) {
               include($pagePath);
            } else {
               echo "<p class='text-red-500'>Page not found!</p>";
            }
         } else {
            // Default content when no specific page is requested
            echo " ";
         }
         ?>
      </div>
   </div>

</body>

</html>