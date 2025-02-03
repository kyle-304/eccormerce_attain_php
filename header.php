<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>


  <!-- component -->
  <nav class="flex justify-between px-20 py-[0.8rem] items-center bg-[#FF9900]">
    <a href="index.php" class="text-xl text-gray-800 font-bold">JUMIA</a>
    

    <div class="flex items-center">

      <ul class="flex items-center space-x-6">

        <!-- <li class="font-semibold text-gray-700"><a href="checkout.php">Check out</a></li> -->
        <?php if (isset($_SESSION['user_id'])) {
          // User is logged in
          echo '<li class="font-semibold text-gray-700"><a href="logout.php">Log out</a></li>';
        } else {
          // User is not logged in
          echo '<li class="font-semibold text-gray-700"><a href="login.php">Log in</a></li>';
        }

        ?>

        <li>
          <a href="checkout.php">
            <svg class="h-6 w-6" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0)matrix(1, 0, 0, 1, 0, 0)" stroke="#000000">
              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.144"></g>
              <g id="SVGRepo_iconCarrier">
                <path d="M7.2998 5H22L20 12H8.37675M21 16H9L7 3H4M4 8H2M5 11H2M6 14H2M10 20C10 20.5523 9.55228 21 9 21C8.44772 21 8 20.5523 8 20C8 19.4477 8.44772 19 9 19C9.55228 19 10 19.4477 10 20ZM21 20C21 20.5523 20.5523 21 20 21C19.4477 21 19 20.5523 19 20C19 19.4477 19.4477 19 20 19C20.5523 19 21 19.4477 21 20Z" stroke="#000000" stroke-width="0.696" stroke-linecap="round" stroke-linejoin="round"></path>
              </g>

            </svg>
          </a>
        </li>
        <!-- <li>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
        </li> -->

      </ul>
    </div>
  </nav>




</body>

</html>